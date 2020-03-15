<button type="submit"
        name="{{ $name ?? 'submit' }}"
        value="{{ $value ?? 'save' }}"
        class="btn btn-lg btn-lm btn-secondary {{ $class ?? '' }}"
        {{ !empty($disabled) ? 'disabled="disabled"' : ''}}
@if (!empty($data))
    @foreach ($data as $attr => $value)
        {!! 'data-' . $attr . '="' . $value . '" ' !!}
    @endforeach
@endif
>
    {{ $title ?? 'Secondary' }}
</button>
