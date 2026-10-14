@props([
    'action',
    'method' => 'POST',
])

<form
    action="{{ $action }}"
    method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}"
    enctype="multipart/form-data"
    {{ $attributes->merge(['class' => '']) }}>

    @if(strtoupper($method) !== 'GET')
        @csrf
    @endif

    @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    {{ $slot }}

</form>