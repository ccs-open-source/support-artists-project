<div class="form-group {{ $class ?? '' }}">
    @if(!empty($label))
    <label for="{{ $field }}">
        @if(!empty($validation) && ($validation['required'] ?? false) == true)
            {{ $label }}&nbsp;<span class="required text-danger">*</span>
        @else
            {{ $label }}
        @endif
    </label>
    @endif
    @if(!empty($edit) || !empty($create) || !empty($appendOptions))
        <div class="input-group">
    @endif
    <select
        style="width: 100%;"
        class="form-control {{ $selectClass ?? '' }}" {!! !empty($noSelect2) ? '' : 'data-autoloading="select2"' !!}
        {!! !empty($allowClear) ? ' data-allowclear="true"' : '' !!}
        name="{{$field}}{{ !empty($multiple) ? '[]' : '' }}@error($field) is-invalid @enderror"
        data-placeholder="{{ $placeholder ?? '' }}"
        {!! !empty($multiple) ? 'multiple="multiple"' : '' !!}

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

        @if (!empty($disabled))
            disabled="disabled"
        @endif
{{--        placeholder="{{ $placeholder ?? '' }}"--}}
        id="{{ $id ?? $field }}" {{ isset($multiple) ? 'multiple="multiple"' : '' }}>
            @if (!empty($placeholder) && empty($noSelect2))
                <option value="">{{ $placeholder ?? ''  }}</option>
            @endif
{{--        @endif--}}
        @if(!empty($options))
            @foreach($options as $option)

                    <?php
                    $selected = false;
                    if(isset($record) && isset($record->$field)) {
                        if(!isset($selectedItems)) {
                            $items = explode(",", $record->$field);
                            $selectedItems = array();

                            foreach ($items as $item) {
                                array_push($selectedItems, (object)array("id" => $item));
                            }
                        }
                    }

                    if(isset($option->id) && !empty($selectedItems)) {
                        foreach($selectedItems as $item) {
                            if((!empty($item->id) && $option->id == $item->id) || (!($item instanceof stdClass) && $option->id == $item)) {
                                $selected = true;
                            }
                        }
                    } else if(!empty($selectedItems)){
                        foreach($selectedItems as $item) {
                            if((!empty($item->id) && $option == $item->id) || (!($item instanceof stdClass) && $option == $item)) {
                                $selected = true;
                            }
                        }
                    }
                    ?>

                    @if(!empty($selectedOption) && isset($option->id) && $option->id == $selectedOption)
                        <?php $selected = 'selected="selected"'; ?>
                    @endif

                    @if(isset($option->id) && old($field) == $option->id)
                        <?php $selected = 'selected="selected"'; ?>
                    @endif

                    <option
                        data-option="{{ base64_encode(json_encode($option)) }}"
                        value="{{ isset($option->id) ? $option->id : $option }}"
                        {{ empty($selected) && !empty($record) && isset($record->$field) && ((isset($option->id) && $option->id == $record->$field) || (!isset($option->id) && $option == $record->$field)) ? 'selected=selected' : '' }}
                        {{ !empty($selected) ? 'selected=selected' : '' }}>
                        {{ $option->value ?? $option }}
                    </option>
            @endforeach
        @endif
    </select>
    @if(!empty($edit) || !empty($create) || !empty($appendOptions))
        <div class="input-group-append">
            <div class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                <i class="la la-cogs"></i>
            </div>
            <div class="dropdown-menu" x-placement="bottom-start">
                @if(!empty($create))
                    <a href="#" class="js-{{$field}}-create dropdown-item">
                        <i class="la la-plus"></i>
                        {{ trans('actions.create') }}
                    </a>
                @endif
                @if(!empty($edit))
                    <a href="#" class="js-{{$field}}-edit dropdown-item">
                        <i class="la la-pencil"></i>
                        {{ trans('actions.edit') }}
                    </a>
                @endif
                @if(!empty($appendOptions))
                    @foreach($appendOptions as $appendOption)
                        <a href="{{ $appendOption['href'] ?? '#' }}" target="{{ $appendOption['target'] ?? '' }}" class="dropdown-item {{ $appendOption['class'] ?? '' }}" data-field="{{ $field }}">
                            @if(!empty($appendOption['icon']))
                                <i class="{{ $appendOption['icon'] }}"></i>
                            @endif
                            {{ $appendOption['label'] }}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endif
    <small class="form-text">
        {!! $help ?? '' !!}
        @error($field)
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </small>
</div>

