<?php namespace Teepluss\Explore;

use HTML;

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

    /**
     * Formats a JSON string for pretty printing
     *
     * @param  string $json The JSON to make pretty
     * @param  bool $html Insert nonbreaking spaces and <br />s for tabs and linebreaks
     * @return string The prettified output
     */
    function prettyPrint($json, $html = false)
    {
        $tabcount   = 0;
        $result     = '';
        $inquote    = false;
        $ignorenext = false;

        if ($html)
        {
            $tab = "&nbsp;&nbsp;&nbsp;";
            $newline = "<br/>";
        }
        else
        {
            $tab = "\t";
            $newline = "\n";
        }

        for ($i = 0; $i < strlen($json); $i++)
        {
            $char = $json[$i];

            if ($ignorenext)
            {
                $result .= $char;
                $ignorenext = false;
            }
            else
            {
                switch ($char)
                {
                    case '{':
                        $tabcount++;
                        $result .= $char . $newline . str_repeat($tab, $tabcount);
                        break;
                    case '}':
                        $tabcount--;
                        $result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
                        break;
                    case ',':
                        $result .= $char . $newline . str_repeat($tab, $tabcount);
                        break;
                    case '"':
                        $inquote = !$inquote;
                        $result .= $char;
                        break;
                    case '\\':
                        if ($inquote) $ignorenext = true;
                        $result .= $char;
                        break;
                    default:
                        $result .= $char;
                }
            }
        }

        return $result;
    }

}