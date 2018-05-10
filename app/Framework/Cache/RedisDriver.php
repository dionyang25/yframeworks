<?php

namespace app\Framework\Cache;

use Exception;
use light\CacheComponent\RedisDriver as RedisDriverOrigin;
class RedisDriver extends RedisDriverOrigin
{
    /**
     * 构造函数, 唯一的传入参数, 是用来初始化连接的.
     *
     * @param $config
     */
    public function __construct(array $config)
    {
        if (isset($config['cluster']) && $config['cluster']) {
            $redis = new Client($config['nodes'], ['cluster' => 'redis', 'exceptions' => false]);
        }
        else {
            $host = $config['host'];
            $port = isset($config['port']) ? $config['port'] : 6379;
            $timeout = isset($config['timeout']) ? $config['timeout'] : 3;
            $db = isset($config['db']) ? $config['db'] : 0;
            $password = isset($config['password']) ? $config['password'] : null;

            $redis = new \Redis();
            if(isset($config['pconnect']) && $config['pconnect'] == 1){
                $redis->pconnect($host, $port, $timeout);
            }else{
                $redis->connect($host, $port, $timeout);
            }
            $redis->auth($password);
            $redis->select($db);
        }

        $this->driver = $redis;

        return $this;
    }

    /**
     * 设置并发锁
     */
    public function setLock($key,$ttl = 1){
        return $this->driver->set($key,1,['nx','ex'=>$ttl]);
    }

    function __call($name, $arguments)
    {
        try{
            return call_user_func_array([$this->driver,$name],$arguments);
        }catch (Exception $e){
            return false;
        }
    }
}
