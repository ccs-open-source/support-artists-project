<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStreamPost;
use App\Models\Stream;
use Illuminate\Http\Request;

class ProfileStreamController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $stream = Stream::where('artist_id', auth('web-artists')->id())->get();
        return view('pages.profiles.stream', ['streams' => $stream, 'record' => auth('web-artists')->user()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('pages.profiles.stream-create', [
            'record' => auth('web-artists')->user(),
            'provider' => [
                (object)['id' => '', 'value' => trans('actions.select-one')],
                (object)['id' => 'youtube', 'value' => 'Youtube'],
                (object)['id' => 'vimeo', 'value' => 'Vimeo']
            ]
        ]);
    }

    /**
     * Create a new Stream Record
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateStreamPost $request)
    {
        $stream = new Stream;
        $stream->artist_id = auth()->id();
        $stream->title = $request->title;
        $stream->provider = $request->provider;
        $stream->provider_id = $request->provider_id;
        $stream->tags = $request->tags;
        $stream->isLive = !empty($request->isLive) ? $request->isLive : 0;
        $stream->publish_at = $request->publish_at;
        $stream->description = $request->description;
        $stream->save();

        return redirect()->route('profile.stream')->with('message', [
            'type' => 'success',
            'message' => trans('profile.stream-created-with-success')
        ]);
    }
}
