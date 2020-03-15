<a href="{{ $href ?? '' }}"
   class="btn btn-lm btn-tertiary {{ $class ?? '' }}"
   {{ !empty($disabled) ? 'disabled' : '' }}
@if (!empty($data))
    @foreach ($data as $attr => $value)
        {!! 'data-' . $attr . '="' . $value . '" ' !!}
    @endforeach
@endif
>
    {!! $icon ?? '' !!}
    {{ $title ?? trans('actions.back') }}
</a>
