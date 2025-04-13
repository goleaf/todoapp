@props([
    'formControlAttributes' => '',
    'size' => 'base',
    'label' => null,
    'id' => null,
    'value' => '',
])

<x-input.input.index
    :formControlAttributes="$formControlAttributes"
    :size="$size"
    :label="$label"
    :id="$id"
    :value="$value"
    {{ $attributes }}
/> 