<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/7
 * Time: 19:41
 */
namespace app\Framework\Exception;
class HttpException extends \Exception{
    public $status_code;
    public $status_code_msg;

    function __construct($status, $message = null, $code = 0, \Exception $previous = null){
        $this->status_code = $status;
        $error_code_msg = app()->configGet('error.error_code_msg');
        if(isset($error_code_msg[$this->status_code])){
            $this->status_code_msg = $error_code_msg[$this->status_code];
        }
        parent::__construct($message = null, $code = 0, $previous);
    }
}
