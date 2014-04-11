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

        $json = json_decode($json, true);

        $this->json = $json;

        $navigators = array();

        foreach ($json as $j)
        {
            $navigators[$j['group']][] = $j;
        }

        View::share('navigators', $navigators);
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

            $response = $this->prettyPrint($response);
        }

        return View::make('explore::index', compact('data', 'response', 'offset'));
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

        //s($method, $url, $data);

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

    protected function prettyPrint($json)
    {
        $result = '';
        $level = 0;
        $in_quotes = false;
        $in_escape = false;
        $ends_line_level = NULL;
        $json_length = strlen( $json );

        for( $i = 0; $i < $json_length; $i++ ) {
            $char = $json[$i];
            $new_line_level = NULL;
            $post = "";
            if( $ends_line_level !== NULL ) {
                $new_line_level = $ends_line_level;
                $ends_line_level = NULL;
            }
            if ( $in_escape ) {
                $in_escape = false;
            } else if( $char === '"' ) {
                $in_quotes = !$in_quotes;
            } else if( ! $in_quotes ) {
                switch( $char ) {
                    case '}': case ']':
                        $level--;
                        $ends_line_level = NULL;
                        $new_line_level = $level;
                        break;

                    case '{': case '[':
                        $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;

                    case ':':
                        $post = " ";
                        break;

                    case " ": case "\t": case "\n": case "\r":
                        $char = "";
                        $ends_line_level = $new_line_level;
                        $new_line_level = NULL;
                        break;
                }
            } else if ( $char === '\\' ) {
                $in_escape = true;
            }
            if( $new_line_level !== NULL ) {
                $result .= "\n".str_repeat( "\t", $new_line_level );
            }
            $result .= $char.$post;
        }

        return $result;
    }

}