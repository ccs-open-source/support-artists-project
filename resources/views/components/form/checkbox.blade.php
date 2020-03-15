
<div class="form-check {{ $class ?? '' }}">
    <input class="form-check-input" type="radio" name="{{ $field }}" id="{{ $id ?? '' }}" value="{{ $value ?? 1 }}" {{ isset($record) && isset($record->$field) && !empty($record->$field) ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $field }}">
        {{ $label }}
    </label>
</div>
