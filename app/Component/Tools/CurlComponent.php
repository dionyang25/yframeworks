<?php
/**
 * Curl组件
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/9
 * Time: 15:47
 */
namespace app\Component\Tools;
use Curl\Curl;
use light\Component;

class CurlComponent implements  Component {

    public function getAccessor()
    {
        return 'curl';
    }

    public function register()
    {
        return function () {
            $curl = new Curl();
            $curl_options =app()->configGet('tools.curl_options');
            $timeout = isset($curl_options['timeout'])?$curl_options['timeout']:3;
            $curl->setOpt(CURLOPT_TIMEOUT,$timeout);
            return $curl;
        };
    }
}
