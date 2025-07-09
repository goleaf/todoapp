@props([

    'text' => '',
    'position' => 'top', // top, bottom, left, right
])

















<div {{ $attributes->merge(['class' => 'relative group']) }}>
    {{ $slot }}
    
    <div class="absolute z-10 hidden group-hover:block {{ $positionClasses }}">
        <div class="bg-gray-700 dark:bg-gray-600 text-white text-sm rounded py-1 px-2 max-w-xs text-center shadow-lg">
            {{ $text }}
        </div>
        <div class="absolute w-0 h-0 border-4 {{ $arrowClasses }}"></div>
    </div>
</div> 