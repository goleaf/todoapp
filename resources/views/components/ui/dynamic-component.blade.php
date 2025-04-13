@props(['component'])

@php
    // Direct approach to avoid circular references
    $parts = explode('.', $component);
    $tag = array_pop($parts);
    $path = implode('/', $parts);
    
    if (!empty($path)) {
        $path = $path . '/';
    }
    
    $viewPath = "components.{$path}{$tag}";
@endphp

@if(view()->exists($viewPath))
    @include($viewPath, ['attributes' => $attributes, 'slot' => $slot])
@else
    <span class="text-red-500">Component not found: {{ $component }}</span>
@endif 