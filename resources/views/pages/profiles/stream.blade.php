@extends('layouts.main')

@section('body')
    <div class="row mt-5">
        <div class="col col-12 col-md-8">
            @empty($streams->count())
                <div class="card">
                    <div class="card-header">
                        {{ trans('profile.title-stream') }}
                    </div>
                    <div class="card-body text-center">
                        <p>{{ trans('profile.stream-is-empty') }}</p>
                        <a href="{{ route('profile.stream.create') }}" class="btn btn-success">
                            {{ trans('profile.stream-create-one') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        {{ trans('profile.title-stream') }}
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th>{{ trans('profile.stream-title') }}</th>
                                    <th>{{ trans('profile.stream-title') }}</th>
                                    <th>{{ trans('profile.stream-title') }}</th>
                                    <th>{{ trans('actions.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-striped">
                            @foreach($streams as $stream)
                                <tr>
                                    <td>{{ $stream->title }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group">
                                            @btnEdit(['label' => trans('actions.edit'), 'route' => route('profile.stream.edit', $stream)])
                                            @btnDelete(['label' => trans('actions.delete'), 'route' => route('profile.stream.delete', $stream)])
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @btnCreate(['label' => trans('actions.create'), 'class' => 'btn-sm', 'route' => route('profile.stream.create')])
                    </div>
                </div>
            @endif

        </div>
        <div class="col col-12 col-md-4">
            @include('pages.profiles.partials.sidebar')
        </div>
    </div>
@endsection
