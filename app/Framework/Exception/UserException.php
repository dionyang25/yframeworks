<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/10
 * Time: 11:33
 * 用户自定义异常处理
 */
namespace app\Framework\Exception;
use Exception;
abstract class UserException extends Exception{
    abstract function handle();
}
