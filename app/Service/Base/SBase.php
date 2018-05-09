<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/4/28
 * Time: 16:22
 * 单例服务提供
 */
namespace app\Service\Base;
class SBase{
    /**
     * @return static
     */
    public static function getInstance(){
        //尝试获取实例
        $class_name = get_called_class();
        $class = app($class_name);
        if(is_null($class)){
            //使用闭包注册实例
            $closure = function () use ($class_name){
                return new $class_name();
            };
            app()->register($class_name,$closure);
            $class = app($class_name);
        }
        return $class;
    }
}
