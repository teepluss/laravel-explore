<?php

$config = Config::get('explore');

$path = $config['path'];
$filter = array_get($config, 'filter', '');

Route::group(array('before' => $filter), function() use ($path)
{
    Route::match(array('GET', 'POST'), '/'.$path.'/request/{id?}', array(
        'as'   => 'explore.request',
        'uses' => 'Teepluss\Explore\ExploreController@request'
    ));

    Route::get('/'.$path.'/{id?}', array(
        'as'   => 'explore.index.get',
        'uses' => 'Teepluss\Explore\ExploreController@index'
    ));
});