<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StreamDetailController extends Controller
{
    /**
     *
     * @param Request $request
     * @param Response $response
     * @param Stream $stream
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, Response $response, Stream $stream)
    {
        return view('pages.stream.index', [
            'stream' => $stream
        ]);
    }
}
