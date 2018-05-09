<?php

namespace app\Framework\Cache;

use light\CacheComponent\Cache as CacheOrigin;

/**
 * 缓存封装, 实际存储, 需要另外封装驱动.
 * 仅封装针对缓存的常规逻辑, 如需使用对应驱动的高级特性, 请绕过, 直接实例化.
 *
 * Class Cache
 */
class Cache extends CacheOrigin
{
    //不使用key()方法转义第一个字符的命令列表
    private $commands_without_key = [];

    /**
     * Cache constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->namespace = 'app\\Framework\\Cache\\';
        return parent::__construct($config);
    }


    /**
     * 直接执行Driver对应方法
     * @param $name
     * @param $arguments
     * @return
     */
     function __call($name, $arguments)
    {
        try{
            if(isset($arguments[0]) && !in_array($name,$this->commands_without_key)){
                $arguments[0] = $this->key($arguments[0]);
            }
            if(app()->configGet('app.debug')){
                app('log')->info('redis debug log:',[
                    'action'=>$name,
                    'params'=>$arguments
                ]);
            }
            return call_user_func_array([$this->driver,$name],$arguments);
        }catch (\Exception $e){
            app('log')->error('runtime exception: '. $e->getMessage(), [
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }

    }
}
