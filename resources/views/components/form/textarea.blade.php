<div class="form-group {{ $class ?? '' }}">
    <label for="{{$field}}">
        @if(!empty($validation) && ($validation['required'] ?? false) == true)
            {!! $label ?? '' !!}<span class="required font-danger">*</span>
        @else
            {!! $label ?? '' !!}
        @endif
    </label>
    <textarea
        placeholder="{{ $placeholder ?? $label }}"
        class="form-control {{ $classInput ?? '' }}"
        name="{{ $field ?? '' }}"
        {{ !empty($id) ? "id=\"$id\"" : "" }}
        cols="{{ $cols ?? '' }}"
        rows="{{ $rows ?? '3' }}"
        {{ !empty($maxLength) ? 'maxlength='.$maxLength : '' }}
        {{ !empty($readOnly) ? 'readonly="readonly"' : '' }}
        {{ !empty($disabled) ? 'disabled="disabled"' : '' }}
        @if (!empty($validation))
            @foreach ($validation as $rule => $setting)
                {{ 'data-validation-' . $rule . '=' . $setting }}
            @endforeach
        @endif

    >{{ isset ($field) && isset($record->$field) ? $record->$field : (isset($default) ? $default : old($field))  }}</textarea>
    <small class="form-text">
        {!! $help ?? '' !!}
    </small>
</div>
