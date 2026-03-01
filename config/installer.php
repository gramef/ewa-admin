<?php
/*
 * File name: installer.php
 * Last modified: 2022.10.13 at 19:21:17
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'demo_app' => env('DEMO_APP', false),
    'currentVersion' => 'v310',

    'core' => [
        'minPhpVersion' => '7.3'
    ],
    'final' => [
        'key' => true,
        'publish' => false
    ],

    'permissions' => [
        'storage/framework/' => '775',
        'storage/logs/' => '775',
        'bootstrap/cache/' => '775'
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Form Wizard Validation Rules & Messages
    |--------------------------------------------------------------------------
    |
    | This are the default form vield validation rules. Available Rules:
    | https://laravel.com/docs/5.4/validation#available-validation-rules
    |
    */
    'environment' => [
        'form' => [
            'rules' => [
                'app_name' => 'required|string|max:50',
                'purchase_code' => 'required|string|max:36|min:36',
                'environment' => 'required|string|max:50',
                'environment_custom' => 'required_if:environment,other|max:50',
                'app_debug' => 'required|string|in:true,false',
                'app_log_level' => 'required|string|max:50',
                'app_url' => 'required|url',
                'database_connection' => 'required|string|max:50',
                'database_hostname' => 'required|string',
                'database_port' => 'required|numeric',
                'database_name' => 'required|string',
                'database_username' => 'required|string',
                'database_password' => 'required|string',
            ]
        ]
    ]
];