<?php

namespace app\Framework\Cache;
use Exception;
class YacDriver extends \light\CacheComponent\YacDriver
{
    function __call($name, $arguments)
    {
        try{
            return call_user_func_array([$this->driver,$name],$arguments);
        }catch (Exception $e){
            return false;
        }
    }
}
