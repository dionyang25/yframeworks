<?php

return [
    // 项目名称
    'name' => 'light',

    // 项目地址
    'base_url' => 'http://localhost',

    // 开发/调试模式
    'debug' => false,

    //日志模块设定统一
    'log'=>[
        //日志级别
        'log_level'=>'INFO',

        // 系统日志
        'log_file' => '/data1/log-data/light.log',

        'show_memory_usage'=>1
    ],

    // 启用组件
    'component' => [
        'light\ViewBlade\ViewComponent',
        'app\Component\Params\ParamsComponent',
        'app\Component\Cache\RedisComponent',
        'app\Component\Cache\YacComponent',
        'app\Component\Common\CommonComponent',
        'app\Component\Tools\CurlComponent',
    ],
];
