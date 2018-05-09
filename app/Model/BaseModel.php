<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/4/26
 * Time: 15:08
 */
namespace app\Model;
use light\App;
use light\MedooModel\MedooModel;

class BaseModel extends MedooModel{
    public $database = 'game';
    public $primary = 'id';
    public $timestamps = false;
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
                //获取配置
                $config = app()->configGet('database');
                return new $class_name($config);
            };
            App::getInstance()->register($class_name,$closure);
            $class = app($class_name);
        }
        return $class;
    }
}

