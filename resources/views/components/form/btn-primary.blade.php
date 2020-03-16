<button type="{{ $type ?? 'submit' }}"
        name="{{ $name ?? 'submit' }}"
        value="{{ $value ?? 'save-and-edit' }}"
        class="btn btn-primary {{ $class ?? '' }}"
        {{ !empty($disabled) ? 'disabled="disabled"' : ''}}
		@if (!empty($data))
		    @foreach ($data as $attr => $value)
		        {!! 'data-' . $attr . '="' . $value . '" ' !!}
		    @endforeach
		@endif
>
{{--    <i class="la la-pencil-square"></i>--}}
    {{ $title ?? 'Primary Action' }}
</button>
