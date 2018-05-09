<?php
namespace app\Component\Params;
/**
 * 参数保存及路由参数辅助
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/4/25
 * Time: 19:47
 */
class Params{

    static protected $params = [];

    /**
     * 获取参数/服务
     * @param $result
     * @param int $is_login
     * @return array
     */
    static public function get($key=''){
        if(empty($key)){
            return self::$params;
        }
        if(is_array($key)){
            //批量获取支持
            $ret = [];
            foreach ($key as $vo){
                $ret[$vo] =  isset(self::$params[$vo])?self::$params[$vo]:null;
            }
            return $ret;
        }
        return isset(self::$params[$key])?self::$params[$key]:null;
    }

    /**
     * 设置参数/服务
     * @param $result
     * @param $key
     * @param $val
     * @return array
     */
    static public function set($key,$val=''){
        if(is_array($key)){
            //批量插入支持
            self::$params = array_merge(self::$params,$key);
        }else{
            self::$params[$key] = $val;
        }
        return ;
    }

    /**
     * 获取路由解析后匹配的参数（中间件使用）
     */
    static public function parseRouteParams(){
        $currentRoute = app('router')->getCurrentRoute();
        if(empty($currentRoute) || empty($currentRoute[2])){
            return false;
        }
        return $currentRoute[2];
    }
}
