<?php namespace Teepluss\Explore;

use HTML;
use Exception;

class Explore {

    /**
     * Render style for package.
     *
     * @param  string $url
     * @param  array  $attributes
     * @return string
     */
    public function style($url, $attributes = array())
    {
        return HTML::style('packages/teepluss/explore/'. $url, $attributes);
    }

    /**
     * Render script for package.
     *
     * @param  string $url
     * @param  array  $attributes
     * @return string
     */
    public function script($url, $attributes = array())
    {
        return HTML::script('packages/teepluss/explore/'. $url, $attributes);
    }

    /**
     * Make remote request.
     *
     * @param  string $method
     * @param  string $url
     * @param  array  $data
     * @param  array  $curl_opts_extends
     * @return mixed
     */
    public function makeRequest($method, $url, $data = array(), $curl_opts_extends = array())
    {
        $curl = curl_init();
        $data = http_build_query($data);

        $url = rtrim($url, '/');

        if (preg_match('/get/i', $method))
        {
            $url = strpos($url, '?') ? $url.'&'.$data : $url.'?'.$data;
            $data = null;
        }

        $curl_opts = array(
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_SSL_VERIFYPEER => 2,
            CURLOPT_ENCODING       => ''
        );

        // Override or extend curl options
        if (count($curl_opts_extends) > 0)
        {
            foreach ($curl_opts_extends as $key => $val)
            {
                $curl_opts[$key] = $val;
            }
        }

        // Suppoert https request.
        if (preg_match('/^https/', $url))
        {
            $curl_opts[CURLOPT_SSL_VERIFYHOST] = 0;
            $curl_opts[CURLOPT_SSL_VERIFYPEER] = 0;
        }

        curl_setopt_array($curl, $curl_opts);

        // Response returned.
        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return array(
            'httpCode' => $httpCode,
            'response' => $response
        );
    }

    /**
     * Checks if string is valid json.
     *
     * @param $string
     * @return bool
     * @author Andreas Glaser
     */
    function isJson($string)
    {
        // make sure provided input is of type string
        if (!is_string($string)) {
            return false;
        }

        // trim white spaces
        $string = trim($string);

        // get first character
        $firstChar = substr($string, 0, 1);

        // get last character
        $lastChar = substr($string, -1);

        // check if there is a first and last character
        if (!$firstChar || !$lastChar) {
            return false;
        }

        // make sure first character is either { or [
        if ($firstChar !== '{' && $firstChar !== '[') {
            return false;
        }

        // make sure last character is either } or ]
        if ($lastChar !== '}' && $lastChar !== ']') {
            return false;
        }

        // let's leave the rest to PHP.
        // try to decode string
        json_decode($string);

        // check if error occurred
        $isValid = json_last_error() === JSON_ERROR_NONE;

        return $isValid;
    }

}