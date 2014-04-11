<?php

return array(

    'json'     => public_path().'/developers/api_data.json',

    'path'     => 'developers/explorer',

    'endpoint' => 'https://api.domain.com/base',

    'prepends' => array(
        array(
            'group'       => 'Parameter',
            'type'        => 'Number',
            'field'       => 'app_id',
            'value'       => 1,
            'optional'    => false,
            'description' => 'Application ID'
        ),
        array(
            'group'       => 'Parameter',
            'type'        => 'String',
            'field'       => 'secret',
            'value'       => '0d1zg7XY3IDxHLs45EfV42645usN9CFb',
            'optional'    => false,
            'description' => 'Application Secret'
        )
    ),

    'template' => 'explore::template',

    'sidebar'  => 'explore::sidebar',

    'footer'   => 'explore::footer'

);