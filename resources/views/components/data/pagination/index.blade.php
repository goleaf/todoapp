@props(['paginator'])

@if ($paginator->hasPages())
    @if (method_exists($paginator, 'links') && method_exists($paginator, 'onEachSide'))
        {{-- Full paginator with numbers --}}
        @include('components.data.pagination.tailwind', ['paginator' => $paginator])
    @else
        {{-- Simple paginator with prev/next only --}}
        @include('components.data.pagination.simple-tailwind', ['paginator' => $paginator])
    @endif
@endif 