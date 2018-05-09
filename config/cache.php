<?php

return [
    // 驱动
//    'driver' => 'redis',

    // 默认过期时间
    'timeout' => 3,

    // 默认前缀
    'prefix' => 'aaa_',

    // 配置
    'config' => [
        'redis' => [
            'host' => '127.0.0.1',
            'port' => 6379,
            'db' => 0,
            'password' => null,
//            'timeout'=>0,
        ],
        'memcached' => [
            'host' => '127.0.0.1',
            'port' => 11211
        ],
        'yac' => []
    ]
];
