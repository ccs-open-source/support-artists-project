<div class="form-group">
    <label for="{{$field}}">
        {{ $label ?? '' }}
        @if(!empty($validation) && ($validation['required'] ?? false) == true)
            <span class="required font-danger">*</span>
        @endif
    </label>
    <div class="input-group date">
        <input
            type="text"
            data-autoloading="datetimepicker"
            autocomplete="off"
            data-date-start-date="{{ $startDate ?? '' }}"
            data-date-end-date="{{ $endDate ?? '' }}"
            data-date-language="{{ collect(explode("_", app()->getLocale()))->first() }}"
            name="{{ $field ?? '' }}@error($field) is-invalid @enderror"
            id="{{ $id ?? '' }}"
            class="form-control {{ $class ?? '' }}"
            value="{{ isset ($field) && isset($record->$field) ? $record->$field : (isset($default) ? $default : old($field))  }}"
            placeholder="{{ $placeholder ?? $label }}"
            {{ !empty($readOnly) ? 'readonly="readonly"' : '' }}
            {{ !empty($disabled) ? 'disabled="disabled"' : '' }}
            @if (!empty($data))
            @foreach ($data as $attr => $value)
            {{ 'data-' . $attr . '=' . $value }}
            @endforeach
            @endif
            @if (!empty($validation))
            @foreach ($validation as $rule => $setting)
            {{ 'data-validation-' . $rule . '=' . $setting }}
            @endforeach
            @endif
            @if (!empty($format))
            {{ 'data-input-format-cleave=' . $format }}
            @endif
            @if (!empty($setDateOn))
            data-set-date-on="{{ $setDateOn }}"
            @endif
        >

        @if (!empty($append))
            <div class="input-group-append {{ $appendClass ?? '' }}"  data-item="{{ $field ?? ''}}">
                <span class="input-group-text">{!! $append !!}</span>
            </div>
        @endif

        <div class="input-group-append" data-date-item="{{ $field }}">
            <span class="input-group-text">
                <i class="la la-calendar"></i>
            </span>
        </div>
    </div>
    <small class="form-text">
        {!! $help ?? '' !!}
        @error($field)
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </small>
</div>
