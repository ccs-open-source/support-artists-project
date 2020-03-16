<div class="form-group {{ $class ?? '' }}">
    @if(!empty($label))
    <label for="{{$field ?? ''}}">
        @if(!empty($validation) && ($validation['required'] ?? false) == true)
            {{ $label ?? '' }}&nbsp;<span class="required text-danger">*</span>
        @else
            {{ $label ?? '' }}
        @endif
    </label>
    @endif
    @if (!empty($append) || !empty($prepend))
        <div class=""> {{--  input-group --}}
        @if (!empty($prepend))
            <div class="input-group-prepend" data-item="{{ $field ?? ''}}">
                <span class="input-group-text">{!!  $prepend !!}</span>
            </div>
        @endif
    @endif
    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $field ?? '' }}"
        title="{{ $placeholder ?? '' }}"
        {{ !empty($id) ? "id=\"$id\"" : "" }}
        class="form-control {{ $classInput ?? '' }}@error($field) is-invalid @enderror"
        value="{{ isset ($field) && isset($record->$field) ? $record->$field : (isset($default) ? $default : old($field))  }}"
        placeholder="{{ $placeholder ?? $label }}"
        {{ !empty($maxLength) ? 'maxlength='.$maxLength : '' }}
        {{ !empty($readOnly) ? 'readonly="readonly"' : '' }}
        {{ !empty($disabled) ? 'disabled="disabled"' : '' }}
        @if (!empty($validation))
            @foreach ($validation as $rule => $setting)
                {{ 'data-validation-' . $rule . '=' . $setting }}
            @endforeach
        @endif
        @if (!empty($data))
            @foreach ($data as $attr => $value)
            {{ 'data-' . $attr . '=' . $value }}
            @endforeach
        @endif
        @if (!empty($format))
            {{ 'data-input-format-cleave=' . $format }}
        @endif
        @if (!empty($pattern))
            {{ 'data-input-pattern=' . $pattern }}
        @endif
    >

    @if (!empty($append) || !empty($prepend))
        @if (!empty($append))
            <div class="input-group-append {{ $appendClass ?? '' }}"  data-item="{{ $field ?? ''}}">
                <span class="input-group-text">{!! $append !!}</span>
            </div>
        @endif
        </div>
    @endif
    <small class="form-text">
        {!! $help ?? '' !!}

        @error($field)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </small>
</div>
