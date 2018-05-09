<?php

return [
    // 数据库1
    'database1' => [
        'master' => [
            [
                'database_type' => 'mysql',
                'database_name' => '',
                'server' => '',
                'prefix' => '',
                'port' => 3306,
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8_unicode_ci',
            ]
        ],
        'slave' => [
            [
                'database_type' => 'mysql',
                'database_name' => '',
                'server' => '',
                'prefix' => '',
                'port' => 3306,
                'username' => '',
                'password' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8_unicode_ci',
            ]
        ]
    ],

    // 数据库2
    'database2' => [

    ]
];
