<?php

namespace app\Component\Cache;

use app\Framework\Cache\Cache;
use light\Component;

class YacComponent implements Component
{
    /**
     * 组件访问器
     *
     * @return mixed
     */
    public function getAccessor()
    {
        return 'yac';
    }

    /**
     * 组件注册方法
     *
     * @return mixed
     */
    public function register()
    {
        return function () {
            $driver = $this->getAccessor();
            $config = app()->configGet('cache');
            if (!$config) return null;
            //覆盖默认配置
            $items = ['timeout','prefix'];
            foreach ($items as $vo){
                if(isset($config['config'][$driver][$vo])){
                    $config[$vo] = $config['config'][$driver][$vo];
                }
            }
            $config['driver'] = $driver;
            return new Cache($config);
        };
    }
}
