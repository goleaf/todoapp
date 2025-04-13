@props([
    'title',
    'description' => null,
    'actions' => null,
])

<div class="md:flex md:items-center md:justify-between border-b border-gray-200 dark:border-gray-700 pb-5 mb-6">
    <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:truncate sm:text-3xl sm:tracking-tight">
            {{ $title }}
        </h2>
        
        @if($description)
            <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">
                {{ $description }}
            </p>
        @endif
    </div>
    
    @if($actions)
        <div class="mt-4 flex md:ml-4 md:mt-0">
            {{ $actions }}
        </div>
    @endif
</div> 