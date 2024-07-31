@props([
    'action',
    'post' => null,
    'patch' => null,
    'put' => null,
    'delete' => null,
])

<form action="{{ $action }}" method="post" {{ $attributes }}>
    @if($patch)
        @method('PATCH')
    @endif
    @if($put)
        @method('PUT')
    @endif
    @if($delete)
        @method('DELETE')
    @endif

    @csrf

    {{ $slot }}
</form>
