<?php namespace Teepluss\Explore;

use API, Config, File, Input, View, Request;

class ExploreController extends \Controller {

    protected $json;

    public function __construct()
    {
        if ( ! File::exists(Config::get('explore::explore.json')))
        {
            throw new FileNotFoundException('JSON is not exists.');
        }

        $json = File::get(Config::get('explore::explore.json'));
        $this->json = json_decode($json, true);

        View::share('json', $this->json);
    }

    public function index($offset = 0)
    {
        $data = $this->json[$offset];

        $response = null;

        $data['parameter']['fields']['Parameter'] = array_merge(
            Config::get('explore::explore.prepends'),
            $data['parameter']['fields']['Parameter']
        );

        if (Request::getMethod() == 'POST')
        {
            $values = array_combine(Input::get('fields'), Input::get('values'));

            $response = \API::invokeRemote(Input::get('endpoint'), $data['type'], $values);
        }

        return View::make('explore::index', compact('data', 'response'));
    }

}