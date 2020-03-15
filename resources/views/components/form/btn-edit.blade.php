<a href="{{ $route ?? '#' }}"
    {{ !empty($target) ? 'target=' . $target : ''}}
    class="{{ $class ?? 'btn btn-sm btn-outline-primary' }}"
   @if (!empty($data))
       @foreach ($data as $attr => $value)
       {!! 'data-' . $attr . '="' . $value . '" ' !!}
       @endforeach
   @endif
@if(!empty($tooltip))
    data-toggle="tooltip"
    @foreach ($tooltip as $attr => $value)
        @if ($attr == 'placement')
            data-placement={{ !empty($value) ? $value : 'right' }}
        @endif
    @endforeach
        @if ($attr == 'title')
            title="{{ $value }}"
        @endif
@endif
>
    @if(!empty($target) && strtolower($target) == '_blank')
        <i class="la la-external-link"></i>
        {{ $label ?? trans('actions.edit-new-window') }}
    @else
        <i class="la la-pencil"></i>
        {{ $label ?? trans('actions.edit') }}
    @endif
</a>
