<?php namespace Teepluss\Explore;

use Illuminate\Routing\Controller;
use Config, Explore, File, Input, View, Request, Route;
use Illuminate\Support\Facades\Input;

class ExploreController extends Controller {

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
        $config = Config::get('explore');

        // Checking json file.
        if ( ! File::exists($config['json']))
        {
            throw new FileNotFoundException('apidoc json data not found.');
        }

        // Decoding json.
        $json = File::get($config['json']);
        $json = json_decode($json, true);

        $jsonData = array();

        // Re-array structure.
        foreach ($json as $i => $j)
        {
            if (isset($j['parameter']) and count($j['parameter']['fields']) > 1)
            {
                $parameters = array();

                foreach ($j['parameter']['fields'] as $fields)
                {
                    $parameters = array_merge($parameters, $fields);
                }

                $json[$i]['parameter']['fields'] = array('Parameter' => $parameters);
            }
        }

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

        if (isset($data['parameter']['fields']['Parameter']))
        {
            $data['parameter']['fields']['Parameter'] = array_merge(
                (array) Config::get('explore.prepends'),
                $data['parameter']['fields']['Parameter']
            );

            $data['parameter']['fields']['Parameter'] = array_merge(
                $data['parameter']['fields']['Parameter'],
                (array) Config::get('explore.appends')
            );
        }
        else
        {
            $data['parameter']['fields']['Parameter'] = (array) Config::get('explore.prepends');

            $data['parameter']['fields']['Parameter'] = array_merge(
                $data['parameter']['fields']['Parameter'],
                (array) Config::get('explore.appends')
            );
        }

        return View::make('explore::index', compact('data', 'offset'));
    }

    public function request($offset = null)
    {
        $dataResponse = null;

        if (Request::getMethod() == 'POST')
        {
            $fields = Input::get('fields');
            $values = Input::get('values');

            $params = array();

            $data = $this->json[$offset];

            if (count($fields)) foreach ($fields as $i => $field)
            {
                $field = trim($field);

                if ( ! $field) continue;

                $params[$field] = $values[$i];
            }

            $response = Explore::makeRequest($data['type'], Input::get('endpoint'), $params);

            // $dataResponse = htmlspecialchars($response['response']);

            // try
            // {
            //     $dataResponse = Explore::prettyPrint($dataResponse);
            // }
            // catch (\Exception $e) { }

            $dataResponse = $response;
        }

        return View::make('explore::request', compact('dataResponse'));
    }

}
