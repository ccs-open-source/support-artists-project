@extends('layouts.main')

@section('body')
    <div class="row mt-5">
        <div class="col col-12 col-md-8">
            <form action="{{ route('profile.stream.store') }}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-header">
                        {{ trans('profile.title-stream-create') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col col-12 col-md-12">
                                @input(['field' => 'title', 'label' => trans('profile.stream-title'), 'validation' => ['required' => true]])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12 col-md-8">
                                @select(['field' => 'tags', 'multiple' => true, 'label' => trans('profile.stream-tags'), 'help' => trans('profile.stream-tags-help'), 'data' => ['autoload' => 'select2', 'select2-tags' => true]])
                            </div>
                            <div class="col col-12 col-md-4">
                                @input(['field' => 'publish_at', 'label' => trans('profile.stream-publish-at'), 'data' => ['provide' => 'datepicker']])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12 col-md-12">
                                @textarea(['field' => 'description', 'label' => trans('profile.stream-description')])
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col col-12 col-md-6">
                                @select(['field' => 'provider', 'label' => trans('profile.stream-provider'), 'options' => $provider, 'validation' => ['required' => true]])
                            </div>
                            <div class="col col-12 col-md-6">
                                @input(['field' => 'provider_id', 'label' => trans('profile.stream-provider-id'), 'help' => trans('profile.stream-provider-id-help'), 'validation' => ['required' => true]])
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col col-12 col-md-6">
                                @checkbox(['field' => 'isLive', 'label' => trans('profile.stream-is-live'), 'value' => 1, 'class' => 'mt-2'])
                            </div>
                            <div class="col col-12 col-md-6 text-right">
                                @btnTertiary(['label' => trans('actions.cancel'), 'type' => 'button'])
                                @btnPrimary(['label' => trans('actions.save')])
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="col col-12 col-md-4">
            @include('pages.profiles.partials.sidebar')
        </div>
    </div>
@endsection
