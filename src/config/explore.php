<?php

return array(

    'endpoint' => 'http://learn.loc/api',

    'prepends'   => array(
        array(
            'group'       => 'Parameter',
            'type'        => 'Number',
            'field'       => 'app_id',
            'optional'    => false,
            'description' => 'Application ID'
        ),
        array(
            'group'       => 'Parameter',
            'type'        => 'String',
            'field'       => 'secret',
            'optional'    => false,
            'description' => 'Application Secret'
        ),
        array(
            'group'       => 'Parameter',
            'type'        => 'String',
            'field'       => 'session_id',
            'optional'    => true,
            'description' => 'Session ID'
        )
    ),

    'template' => 'explore::template',

    'sidebar'  => 'explore::sidebar',

    'json'     => public_path().'/developers/api_data.json'

);