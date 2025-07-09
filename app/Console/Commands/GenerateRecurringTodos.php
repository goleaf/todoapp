<?php

namespace App\Console\Commands;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateRecurringTodos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todos:generate-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new instances of recurring todos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to generate recurring todos...');
        
        // Get all recurring todos that are templates (parents)
        $recurringTodos = Todo::where('is_recurring', true)
            ->whereNull('recurring_parent_id')
            ->get();
            
        $this->info("Found {$recurringTodos->count()} recurring todo templates");
        
        $totalGenerated = 0;
        
        foreach ($recurringTodos as $todo) {
            $generated = $this->generateTodoInstances($todo);
            $totalGenerated += $generated;
        }
        
        $this->info("Total generated: $totalGenerated new todo instances");
        
        return Command::SUCCESS;
    }
    
    /**
     * Generate instances for a recurring todo
     */
    private function generateTodoInstances(Todo $todo): int
    {
        $now = Carbon::now();
        $lastGenerated = $todo->last_generated_at ? Carbon::parse($todo->last_generated_at) : null;
        $repeatUntil = $todo->repeat_until ? Carbon::parse($todo->repeat_until)->endOfDay() : null;
        
        // If we have a repeat until date and we're past it, skip
        if ($repeatUntil && $now->gt($repeatUntil)) {
            return 0;
        }
        
        // Get the last instance created
        $latestInstance = $todo->recurrenceInstances()
            ->orderBy('due_date', 'desc')
            ->first();
            
        // Calculate from when we should start generating
        $startFrom = $latestInstance ? Carbon::parse($latestInstance->due_date) : Carbon::parse($todo->due_date);
        
        // Find dates to generate based on the frequency
        $dates = $this->getGenerationDates($todo, $startFrom, $repeatUntil);
        
        $generated = 0;
        
        foreach ($dates as $date) {
            // Skip if due date is in the past (more than a day)
            if ($date->lt($now->copy()->subDay())) {
                continue;
            }
            
            // Skip if we've already generated this instance
            if ($latestInstance && $date->lte(Carbon::parse($latestInstance->due_date))) {
                continue;
            }
            
            // Create new instance
            $newTodo = $todo->replicate();
            $newTodo->recurring_parent_id = $todo->id;
            $newTodo->is_recurring = false;
            $newTodo->status = 'pending';
            $newTodo->due_date = $date;
            $newTodo->created_at = now();
            $newTodo->updated_at = now();
            
            // Clear any repeat-specific fields (they're only needed on the parent)
            $newTodo->repeat_frequency = null;
            $newTodo->repeat_interval = null;
            $newTodo->repeat_days = null;
            $newTodo->repeat_until = null;
            $newTodo->last_generated_at = null;
            
            $newTodo->save();
            
            $generated++;
        }
        
        // Update last generated timestamp on the parent
        if ($generated > 0) {
            $todo->last_generated_at = now();
            $todo->save();
        }
        
        $this->line("Generated $generated instances for todo: {$todo->title}");
        
        return $generated;
    }
    
    /**
     * Calculate the dates to generate based on the frequency
     */
    private function getGenerationDates(Todo $todo, Carbon $startFrom, ?Carbon $repeatUntil): array
    {
        $dates = [];
        $now = Carbon::now();
        $lookAheadDays = 30; // Generate instances for the next 30 days by default
        $maxInstances = 10;  // Maximum instances to generate at once
        
        // If we have a specific repeat until date, use that as the limit
        $endDate = $repeatUntil ?? $now->copy()->addDays($lookAheadDays);
        
        $currentDate = $startFrom->copy();
        
        switch ($todo->repeat_frequency) {
            case 'daily':
                for ($i = 0; $i < $maxInstances && $currentDate->lt($endDate); $i++) {
                    $currentDate = $currentDate->copy()->addDays($todo->repeat_interval ?? 1);
                    if ($currentDate->gt($endDate)) break;
                    $dates[] = $currentDate->copy();
                }
                break;
                
            case 'weekly':
                $repeatDays = $todo->repeat_days ?? [];
                
                for ($i = 0; $i < $maxInstances * 7 && $currentDate->lt($endDate); $i++) {
                    // Move to the next day
                    $currentDate = $currentDate->copy()->addDay();
                    
                    // If we've moved to the next week based on interval, reset
                    if ($todo->repeat_interval > 1) {
                        $weeksSinceStart = $startFrom->diffInWeeks($currentDate);
                        if ($weeksSinceStart % $todo->repeat_interval != 0) {
                            continue;
                        }
                    }
                    
                    // For weekly, check if this day of week is included
                    $dayOfWeek = $currentDate->dayOfWeekIso; // 1-7 (Mon-Sun)
                    
                    if (empty($repeatDays) || in_array($dayOfWeek, $repeatDays)) {
                        if ($currentDate->gt($endDate)) break;
                        $dates[] = $currentDate->copy();
                        
                        if (count($dates) >= $maxInstances) break;
                    }
                }
                break;
                
            case 'monthly':
                for ($i = 0; $i < $maxInstances && $currentDate->lt($endDate); $i++) {
                    $currentDate = $currentDate->copy()->addMonths($todo->repeat_interval ?? 1);
                    if ($currentDate->gt($endDate)) break;
                    $dates[] = $currentDate->copy();
                }
                break;
                
            case 'custom':
                // Custom frequency not implemented yet
                break;
        }
        
        return $dates;
    }
} 