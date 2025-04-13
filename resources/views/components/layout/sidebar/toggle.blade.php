<x-ui.button
    type="button"
    x-on:click="$store.sidebar.toggle()"
    aria-label="{{ __('Toggle sidebar') }}"
    {{ $attributes->class(['shrink-0 lg:hidden']) }}
>{{ $slot }}</x-ui.button>
