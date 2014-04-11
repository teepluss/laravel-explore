<?php

return array(

    'json'     => public_path().'/developers/api_data.json',

    'path'     => 'developers/explorer',

    'endpoint' => 'http://api.likeshopping.loc/v1',

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
            'value'       => '6d1zg7XY3IDxHLs45EfV42844usN9CVb',
            'optional'    => false,
            'description' => 'Application Secret'
        ),
        array(
            'group'       => 'Parameter',
            'type'        => 'String',
            'field'       => 'session_id',
            'value'       => 'S2yS10SEmEL2KU0nnH4lt247/wTduuviVlsWA7nNtwuf5Ry.NlIV1.5zJXDm',
            'optional'    => true,
            'description' => 'Session ID'
        )
    ),

    'template' => 'explore::template',

    'sidebar'  => 'explore::sidebar',

    'footer'   => 'explore::footer'

);