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
            data-autoloading="datepicker"
            autocomplete="off"
            data-date-format="{{ $formatDate ?? 'yyyy-mm-dd' }}"
            data-date-orientation="{{ $orientation ?? 'bottom' }}"
            data-date-start-date="{{ $startDate ?? '' }}"
            data-date-end-date="{{ $endDate ?? '' }}"
            data-date-language="{{ collect(explode("_", app()->getLocale()))->first() }}"
            name="{{ $field ?? '' }}"
            {{ !empty($id) ? "id=\"$id\"" : "" }}
            class="form-control {{ $class ?? '' }}"
            value="{{ isset ($field) && isset($record->$field) ? $record->$field : (isset($default) ? $default : old($field))  }}"
            placeholder="{{ $placeholder ?? $label }}"
            title="{{ $placeholder ?? '' }}"
            {{ !empty($readOnly) ? 'readonly="readonly"' : '' }}
            {{ !empty($disabled) ? 'disabled="disabled"' : '' }}
            @if (!empty($data))
                @foreach ($data as $attr => $value)
                {{ 'data-' . $attr . '=' . $value }}
                @endforeach
            @endif
{{--            {{ !empty($required) ? 'required' : '' }}--}}
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
            <div class="input-group-append {{ $appendClass ?? '' }} hide"  data-item="{{ $field ?? ''}}">
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
    </small>
</div>
