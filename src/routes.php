<?php

Route::match(array('GET', 'POST'), '/explore/{id?}', array(
    'as'   => 'explore.index.get',
    'uses' => 'Teepluss\Explore\ExploreController@index'
));