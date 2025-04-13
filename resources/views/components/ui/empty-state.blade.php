@props([
    'icon' => null,
    'title' => null,
    'description' => null,
    'action' => null,
    'actionText' => null,
    'actionUrl' => null,
])

<x-ui.empty-state.index
    :icon="$icon"
    :title="$title"
    :description="$description"
    :action="$action"
    :actionText="$actionText"
    :actionUrl="$actionUrl"
    {{ $attributes }}
>
    {{ $slot }}
</x-ui.empty-state.index> 