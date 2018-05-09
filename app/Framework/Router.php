<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/3
 * Time: 12:00
 */
namespace app\Framework;
use light\Routing\Router as RouterOrigin;
class Router extends RouterOrigin{
    public function getCurrentRoute(){
        return $this->currentRoute;
    }
}
