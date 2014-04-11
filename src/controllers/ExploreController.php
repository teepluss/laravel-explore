<?php namespace Teepluss\Explore;

use API, Config, Explore, File, Input, View, Request;

class ExploreController extends \Controller {

    /**
     * Json data.
     *
     * @var string
     */
    protected $json;

    /**
     * Controller construct.
     *
     * Read json data from apiDoc json.
     */
    public function __construct()
    {
        // Checking json file.
        if ( ! File::exists(Config::get('explore::explore.json')))
        {
            throw new FileNotFoundException('JSON is not exists.');
        }

        // Decoding json.
        $json = File::get(Config::get('explore::explore.json'));
        $json = json_decode($json, true);

        $this->json = $json;

        // Sidebar navigator.
        $navigators = array();
        foreach ($json as $j)
        {
            $navigators[$j['group']][] = $j;
        }

        View::share('navigators', $navigators);
    }

    /**
     * Console.
     *
     * @param  integer $offset
     * @return string
     */
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

            $response = Explore::makeRequest($data['type'], Input::get('endpoint'), $values);

            $dataResponse = $response['response'];

            try
            {
                $dataResponse = Explore::prettyPrint($dataResponse);
            }
            catch (\Exception $e) { }
        }

        return View::make('explore::index', compact('data', 'dataResponse', 'offset'));
    }

}