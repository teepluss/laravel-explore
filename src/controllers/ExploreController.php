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

        $jsonData = array();

        // Sidebar navigator.
        $navigators = array();
        foreach ($json as $j)
        {
            $index = $j['type'].'-'.$j['name'];

            $navigators[$j['group']][$index] = $j;

            $jsonData[$index] = $j;
        }

        $this->json = $jsonData;

        View::share('navigators', $navigators);
    }

    /**
     * Console.
     *
     * @param  integer $offset
     * @return string
     */
    public function index($offset = null)
    {
        if (is_null($offset))
        {
            reset($this->json);
            $offset = key($this->json);
        }

        $data = $this->json[$offset];

        $response = null;

        if (isset($data['parameter']['fields']['Parameter']))
        {
            $data['parameter']['fields']['Parameter'] = array_merge(
                (array) Config::get('explore::explore.prepends'),
                $data['parameter']['fields']['Parameter']
            );

            $data['parameter']['fields']['Parameter'] = array_merge(
                $data['parameter']['fields']['Parameter'],
                (array) Config::get('explore::explore.appends')
            );
        }
        else
        {
            $data['parameter']['fields']['Parameter'] = (array) Config::get('explore::explore.prepends');

            $data['parameter']['fields']['Parameter'] = array_merge(
                $data['parameter']['fields']['Parameter'],
                (array) Config::get('explore::explore.appends')
            );
        }

        if (Request::getMethod() == 'POST')
        {
            $fields = Input::get('fields');
            $values = Input::get('values');

            $params = array();

            if (count($fields)) foreach ($fields as $i => $field)
            {
                $field = trim($field);

                if ( ! $field) continue;

                $params[$field] = $values[$i];
            }

            $response = Explore::makeRequest($data['type'], Input::get('endpoint'), $params);

            $dataResponse = htmlspecialchars($response['response']);

            try
            {
                $dataResponse = Explore::prettyPrint($dataResponse);
            }
            catch (\Exception $e) { }
        }

        return View::make('explore::index', compact('data', 'dataResponse', 'offset'));
    }

}