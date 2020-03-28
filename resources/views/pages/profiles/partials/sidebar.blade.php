<h3>{{ trans('profile.hi-artist', ['artist' => $record->realName]) }}</h3>
<img src="{{ $record->avatar }}?s=500" alt="{{ $record->name }}" class="img-fluid img-thumbnail rounded mb-2">
<div class="card">
    <div class="card-header">
        {{ trans('profile.menu') }}
    </div>


    <div class="list-group list-group-flush">
        <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action @inUrl('profile/general') active @endinUrl">
            {{ trans('profile.menu-general') }}
        </a>
        <a href="#" class="list-group-item list-group-item-action  @inUrl('profile/stream') active @endinUrl">
            {{ trans('profile.menu-stream') }}
        </a>
        <a href="{{ route('profile.social') }}" class="list-group-item list-group-item-action @inUrl('profile/social') active @endinUrl">
            {{ trans('profile.menu-social') }}
        </a>
        <a href="#" class="list-group-item list-group-item-action @inUrl('profile/grpd') active @endinUrl">
            {{ trans('profile.menu-gdpr') }}
        </a>
    </div>
</div>
