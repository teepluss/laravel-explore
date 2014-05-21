<?php

$path = Config::get('explore::explore.path');

Route::match(array('GET', 'POST'), '/'.$path.'/request/{id?}', array(
    'as'   => 'explore.request',
    'uses' => 'Teepluss\Explore\ExploreController@request'
));

Route::get('/'.$path.'/{id?}', array(
    'as'   => 'explore.index.get',
    'uses' => 'Teepluss\Explore\ExploreController@index'
));