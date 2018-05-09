<?php
namespace app\Component\Common;
use light\Component;

/**
 * 参数存储组件
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/4/25
 * Time: 16:14
 */
class CommonComponent implements  Component {

    public function getAccessor()
    {
        return 'common';
    }

    public function register()
    {
        return function () {
            return new Common();
        };
    }
}
