<{{ $tag ?? 'a' }} href="{{ $href ?? '' }}" class="{{ empty($notDefaultClass) ? 'btn btn-refresh btn-lm btn-primary' : '' }} {{ $class ?? '' }}" role="button"

@if (!empty($data))
    @foreach ($data as $attr => $value)
        {!! 'data-' . $attr . '="' . $value . '" ' !!}
    @endforeach
@endif
>
    <i class="la la-plus"></i>
    {{ $label ?? trans('actions.new') }}
</{{ $tag ?? 'a' }}>
