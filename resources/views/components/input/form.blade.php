@props(['method' => 'POST'])

@php
    $spoofedMethod = in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']);
    $realMethod = $spoofedMethod ? 'POST' : $method;
@endphp

<form method="{{ $realMethod }}" {{ $attributes }}>
    @csrf
    
    @if($spoofedMethod)
        @method($method)
    @endif
    
    {{ $slot }}
</form>
