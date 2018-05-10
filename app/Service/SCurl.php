<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/9
 * Time: 15:19
 */
namespace app\Service;
use app\Service\Base\SBase;

class SCurl extends SBase
{
    public $curl_obj;
    private $error;

    public function fetch($source, $params = [], $method = 'get',$settings = [])
    {

        $curl = app('curl');
        $api_config = app()->configGet('api.api_list');
        if (!array_key_exists($source, $api_config)) {
            $this->setError(-1);
            return false;
        }
        if(empty($settings['domain'])){
            $settings['domain'] = app()->configGet('app.domain');
        }
        switch ($method) {
            case 'get':
                $curl->get($settings['domain'].$api_config[$source], $params);
        }

        $this->curl_obj = $curl;
        if($curl->error){
            $this->setError($curl->error_code,$curl->error_message);
            //记录日志
            app('log')->warning('curl request error',[
                'curl_error'=>$curl->error_code.':'.$curl->error_message,
                'url'=>$settings['domain'].$api_config[$source],
                'params'=>$params
            ]);
            return false;
        }
        $response = $curl->response;
        if(empty($settings['raw'])){
            $response = json_decode($response,true);
        }
        return $response;
    }

    public function setError($code,$msg =''){
        $this->error['code'] = $code;
        $this->error['msg'] = $msg;
        return ;
    }

    public function getError(){
        return $this->error;
    }
}
