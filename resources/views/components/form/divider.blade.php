@if (empty($type) || (!empty($type) && $type != 'primary'))
    <div class="separator separator--space-lg separator--border-dashed {{ $class ?? '' }}"></div>
@elseif (!empty($type) && $type == 'primary')
    <div class="divider {{ $classs ?? '' }}">
        <span></span>
        {!! !empty($title) ? '<span>'.$title.'</span>' : '' !!}
        <span></span>
    </div>
@endif
