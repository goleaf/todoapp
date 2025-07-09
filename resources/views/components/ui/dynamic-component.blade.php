@props(['component', 'cacheExpiry' => 3600])







@if(config('app.env') === 'production')
    @php
        // Generate a base cache key. @cache directive will vary based on rendered content.
        // Include attributes potentially affecting the render output in the key.
        $cacheKey = 'dynamic_component_render:' . $component . ':' . md5(json_encode($attributes->getAttributes()));
    @endphp
    @cache($cacheKey, $cacheExpiry)
        <x-dynamic-component :component="$component" {{ $attributes }}>
            {{ $slot }}
        </x-dynamic-component>
    @endcache
@else
    {{-- Render directly in non-production --}}
    <x-dynamic-component :component="$component" {{ $attributes }}>
        {{ $slot }}
    </x-dynamic-component>
@endif 