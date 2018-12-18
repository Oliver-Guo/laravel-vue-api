<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
     */

    'supportsCredentials'    => false,
    'allowedOrigins'         => env('ALLOWED_ORIGINS') ? array_filter(explode(',', env('ALLOWED_ORIGINS'))) : ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders'         => ['*'],
    'allowedMethods'         => ['*'],
    'exposedHeaders'         => ['authorization', 'apitimestamp'],
    'maxAge'                 => 0,

];
