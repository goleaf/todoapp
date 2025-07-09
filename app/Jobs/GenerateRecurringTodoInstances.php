<?php

namespace App\Jobs;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateRecurringTodoInstances implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The todo instance.
     *
     * @var \App\Models\Todo
     */
    protected $todo;

    /**
     * Create a new job instance.
     */
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Only process recurring parent todos
        if (!$this->todo->isRecurringParent()) {
            return;
        }

        $now = Carbon::now();
        $repeatUntil = $this->todo->repeat_until ? Carbon::parse($this->todo->repeat_until)->endOfDay() : null;
        
        // If we have a repeat until date and we're past it, skip
        if ($repeatUntil && $now->gt($repeatUntil)) {
            return;
        }
        
        // Get the last instance created
        $latestInstance = $this->todo->recurrenceInstances()
            ->orderBy('due_date', 'desc')
            ->first();
            
        // Calculate from when we should start generating
        $startFrom = $latestInstance 
            ? Carbon::parse($latestInstance->due_date) 
            : ($this->todo->due_date ? Carbon::parse($this->todo->due_date) : now());
        
        // Find dates to generate based on the frequency
        $dates = $this->getGenerationDates($startFrom, $repeatUntil);
        
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
            $newTodo = $this->todo->replicate();
            $newTodo->recurring_parent_id = $this->todo->id;
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
            $this->todo->last_generated_at = now();
            $this->todo->save();
        }
    }
    
    /**
     * Calculate the dates to generate based on the frequency
     */
    private function getGenerationDates(Carbon $startFrom, ?Carbon $repeatUntil): array
    {
        $dates = [];
        $now = Carbon::now();
        $lookAheadDays = 30; // Generate instances for the next 30 days by default
        $maxInstances = 5;  // Maximum instances to generate at once
        
        // If we have a specific repeat until date, use that as the limit
        $endDate = $repeatUntil ?? $now->copy()->addDays($lookAheadDays);
        
        $currentDate = $startFrom->copy();
        
        switch ($this->todo->repeat_frequency) {
            case 'daily':
                for ($i = 0; $i < $maxInstances && $currentDate->lt($endDate); $i++) {
                    $currentDate = $currentDate->copy()->addDays($this->todo->repeat_interval ?? 1);
                    if ($currentDate->gt($endDate)) break;
                    $dates[] = $currentDate->copy();
                }
                break;
                
            case 'weekly':
                $repeatDays = $this->todo->repeat_days ?? [];
                
                for ($i = 0; $i < $maxInstances * 7 && $currentDate->lt($endDate); $i++) {
                    // Move to the next day
                    $currentDate = $currentDate->copy()->addDay();
                    
                    // If we've moved to the next week based on interval, reset
                    if ($this->todo->repeat_interval > 1) {
                        $weeksSinceStart = $startFrom->diffInWeeks($currentDate);
                        if ($weeksSinceStart % $this->todo->repeat_interval != 0) {
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
                    $currentDate = $currentDate->copy()->addMonths($this->todo->repeat_interval ?? 1);
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