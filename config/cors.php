<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to ['*']
    | to accept any value.
    |
    */

    'supportsCredentials' => false,
    'allowedOrigins' => ['localhost'],
    'allowedOriginsPatterns' => ['/localhost:\d/'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['GET'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];
