@props(['key', 'params' => []])

@php
    $translation = __($key, $params);
@endphp

{{ $translation }} 