<?php

$config = Config::get('explore');

$path = $config['path'];
$middleware = array_get($config, 'middleware');

$group = [];

if ( ! is_null($middleware))
{
    $group['middleware'] = $middleware;
}

Route::group($group, function() use ($path)
{
    Route::match(['GET', 'POST'], '/'.$path.'/request/{offset?}', [
        'as'   => 'explore.request',
        'uses' => 'Teepluss\Explore\ExploreController@request'
    ]);

    Route::get('/'.$path.'/{offset?}', [
        'as'   => 'explore.index.get',
        'uses' => 'Teepluss\Explore\ExploreController@index'
    ]);
});
