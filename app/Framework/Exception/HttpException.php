<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/7
 * Time: 19:41
 */
namespace app\Framework\Exception;
use light\Http\Response;

class HttpException extends UserException {
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

    public function handle(){
        $ret = app('common')->error_output(
            [
                'id'=>$this->status_code,
                'text'=>$this->status_code_msg
            ]
        );
        $response = new Response($ret);
        $response->send();
        return false;
    }
}
