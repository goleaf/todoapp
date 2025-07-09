<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearComponentCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'components:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the blade component cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear all component caches
        $this->clearIconCache();
        $this->clearComponentCache();
        
        $this->info('Component cache cleared successfully.');
        return Command::SUCCESS;
    }
    
    /**
     * Clear the icon cache
     */
    protected function clearIconCache()
    {
        // Get all cache keys matching the icon pattern
        $keys = Cache::get('cache_keys:icons', []);
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        // Clear the index
        Cache::forget('cache_keys:icons');
        
        $this->line('Icon cache cleared.');
    }
    
    /**
     * Clear the component cache
     */
    protected function clearComponentCache()
    {
        // Get all cache keys matching the component pattern
        $keys = Cache::get('cache_keys:components', []);
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        // Clear the index
        Cache::forget('cache_keys:components');
        
        $this->line('Component cache cleared.');
    }
} 