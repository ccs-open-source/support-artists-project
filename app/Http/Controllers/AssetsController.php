<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssetsController extends Controller
{
    public function utp(Request $request, Response $response)
    {
        $settings = [];

        $settings['version'] = date('ymd');

        $settings['env'] = config('app.env');
        $settings['hashes'] = ['key' => []];
        $settings['auditInfos'] = null;


        return response('window.Artist4Artist = ' . json_encode($settings))
            ->header('Content-Type', 'application/javascript')
            ->header("Cache-Control", 'no-cache, no-store, must-revalidate');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function lang(Request $request, Response $response)
    {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return response('window.translations = ' . json_encode($strings))
            ->header('Content-Type', 'application/javascript')
            ->header("Cache-Control", 'no-cache, no-store, must-revalidate');
    }

    /**
     * Get Language by File rather than get all languages.
     * @param Request $request
     * @param Response $response
     * @param $file
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|void
     */
    public function langByFile(Request $request, Response $response, $file)
    {
        $lang   = config('app.locale');
        $file   = resource_path('lang/' . $lang . '/' . $file . '.php');

        if (file_exists($file)) {
            $strings = require $file;
            $name           = basename($file, '.php');

            return response('window.translations.'.$name.' = ' . json_encode($strings))
                ->header('Content-Type', 'application/javascript')
                ->header("Cache-Control", 'no-cache, no-store, must-revalidate');
        }

        return abort(404, "Resource was not found");
    }

    public function getVersion(Request $request, Response $response)
    {
        /*$version = $this->getAppVersion();

        if ($request->wantsJson()) {
            $result = new Result();
            $result->items = $version;
            $result->auditInfo->stop();

            return response()->json($result);
        }*/

        return date('ymd');
    }
}
