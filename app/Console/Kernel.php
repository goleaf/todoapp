<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\TranslationManager::class,
        Commands\ComponentManager::class,
        Commands\UserManager::class,
        Commands\GenerateRecurringTodos::class,
        Commands\ClearComponentCache::class,
        Commands\BuildComponentManifest::class,
        Commands\CleanBladePHPCode::class,
        Commands\OptimizeBladeStorage::class,
        Commands\SimulateUsageData::class,
    ];
    
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run the generate recurring todos command daily at midnight
        $schedule->command('todos:generate-recurring')->dailyAt('00:00');
        
        // Schedule component optimization commands
        $schedule->command('blade:build-manifest')->dailyAt('01:00');
        $schedule->command('blade:optimize-storage')->dailyAt('01:30');
        $schedule->command('components:clear')->weekly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 