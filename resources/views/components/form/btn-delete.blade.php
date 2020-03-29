<a
    href="{{ $route ?? '#' }}"
    class="{{ $class ?? 'btn btn-sm btn-danger' }}"
    @if (!empty($data))
        @foreach ($data as $attr => $value)
            {{ 'data-' . $attr . '=' . $value }}
        @endforeach
    @endif>
    <i class="la la-trash"></i>
    {{ $label ?? trans('actions.delete') }}
</a>
