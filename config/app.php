<?php

return [
    // 项目名称
    'name' => 'light',

    // 项目地址
    'base_url' => 'http://localhost',

    // 开发/调试模式
    'debug' => false,

    // 系统日志
    'log_file' => '/data/www-data/logs/light.log',

    // 日志级别
    'log_level' => 'ERROR',

    // 启用组件
    'component' => [
        'light\ViewBlade\ViewComponent',
        'app\Component\Params\ParamsComponent',
        'app\Component\Cache\RedisComponent',
        'app\Component\Common\CommonComponent',
    ],
];
