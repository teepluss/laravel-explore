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

        if (isset($data['parameter']['fields']['Parameter']))
        {
            $data['parameter']['fields']['Parameter'] = array_merge(
                Config::get('explore::explore.prepends'),
                $data['parameter']['fields']['Parameter']
            );
        }
        else
        {
            $data['parameter']['fields']['Parameter'] = Config::get('explore::explore.prepends');
        }

        if (Request::getMethod() == 'POST')
        {
            $values = array_combine(Input::get('fields'), Input::get('values'));
            //$values = array_filter($values);

            $response = $this->makeRequest($data['type'], Input::get('endpoint'), $values);

            $response = json_encode(json_decode($response), JSON_PRETTY_PRINT);
        }

        return View::make('explore::index', compact('data', 'response'));
    }

    /**
     * Make POST request via CURL.
     *
     * @param  string $url
     * @param  array
     * @param  array
     * @return array
     */
    protected function makeRequest($method, $url, $data = array(), $curl_opts_extends = array())
    {
        $curl = curl_init();
        $data = http_build_query($data);

        $url = rtrim($url, '/');

        if (preg_match('/get/i', $method))
        {
            $url = strpos($url, '?') ? $url.'&'.$data : $url.'?'.$data;
            $data = null;
        }

        s($method, $url, $data);

        $curl_opts = array(
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_SSL_VERIFYPEER => 2
        );

        // Override or extend curl options
        if (count($curl_opts_extends) > 0)
        {
            foreach ($curl_opts_extends as $key => $val)
            {
                $curl_opts[$key] = $val;
            }
        }

        curl_setopt_array($curl, $curl_opts);

        // Response returned.
        $response = curl_exec($curl);

        $status   = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $response;
    }

}