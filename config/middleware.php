<?php

return [
    'middleware' => [
        \Illuminate\Http\Middleware\HandleCors::class,
    ],

    'middlewareGroups' => [
        'web' => [],

        'api' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            'bindings',
        ],
    ],
];
