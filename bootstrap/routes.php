<?php

$router = new \app\Framework\Router();

$router->get('/', function () use ($router) {
    return app()->configGet('app.name');
});
//
//$router->get('/home', 'IndexController@home');
//
//$router->group(['prefix'=>'/{type:\d+}/{version}','middleware'=>'MBaseInit|MClient'],function () use ($router){
//    $router->group(['prefix'=>'{c:upgrade}','middleware'=>'MLoginUser'],function () use ($router){
//        $router->get('{a:check}','UpgradeController@check');
//        return;
//    });
//});
