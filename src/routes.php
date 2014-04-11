<?php

$path = Config::get('explore::explore.path');

Route::match(array('GET', 'POST'), '/'.$path.'/{id?}', array(
    'as'   => 'explore.index.get',
    'uses' => 'Teepluss\Explore\ExploreController@index'
));