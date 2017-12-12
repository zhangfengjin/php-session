<?php

return [

    'driver' => 'file',

    'lifetime' => 120,

    'expire_on_close' => false,

    'encrypt' => false,

    'files' => __DIR__ . '/../stroage/sessions',

    'connection' => null,

    'table' => 'sessions',

    'store' => null,

    'lottery' => [2, 100],

    'cookie' => 'xy_session',

    'path' => '/',

    'domain' => null,

    'secure' => false,

    'http_only' => true,
];
