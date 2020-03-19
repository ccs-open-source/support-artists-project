
<div class="form-check {{ $class ?? '' }}">
    <input class="form-check-input" type="checkbox" name="{{ $field }}" id="{{ $id ?? $field }}" value="{{ $value ?? 1 }}" {{ isset($record) && isset($record->$field) && !empty($record->$field) ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $field }}">
        {{ $label }}
    </label>
</div>
