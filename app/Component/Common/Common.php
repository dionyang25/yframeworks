<?php
namespace app\Component\Common;
/**
 * 通用函数
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/4/25
 * Time: 19:47
 */
class Common{

    /**
     * 将一维数组转为字符串 (array('a' => 1, 'b' => 2, 'c => '+1') To: a=1, b=2, c=c+1)
     * @param array 需要转换的数组对象
     * @return string
     */
    public function arrayToString(array $datas = array())
    {
        $str = NULL;

        if(!empty($datas))
        {
            $s = array('like', 'update', 'id', 'key', 'starting', 'from', 'desc', 'group');

            $i = 1;
            $dataCount = count($datas);
            foreach($datas as $key => $data)
            {
                $str .= (in_array($key, $s) ? '`' . $key . '`' : $key) . ($data && in_array($data, array('?+1', '?-1', '?+2', '?-2')) ? '=' . $key . strtr($data, array('?' => NULL)) : '=\'' . self::mysql_real_escape_string($data) . '\'') . ($i < $dataCount ? ', ' : NULL);
                $i++;
            }
        }
        return $str;
    }

    /**
     * 输出格式规范
     * @param $result
     * @return array
     */
    public function output($result){
        $user_info = app('params')->get('user_info');
        $is_login = (!empty($user_info) && !empty($user_info['puid']))?1:0;
        $crt = app('request')->get('crt');
        $ret = [
            'result'=>$result,
            'is_login'=>$is_login
        ];
        if(!empty($crt)){
            $ret['crt'] = (int)$crt;
        }
        if(app()->configGet('app.debug')){
            $ret['debug'] = app('params')->get('info_logs');
        }
        return $ret;
    }

    /**
     * 输出格式规范
     * @param $result
     * @return array
     */
    public function error_output($result){
        $user_info = app('params')->get('user_info');
        $is_login = (!empty($user_info) && !empty($user_info['puid']))?1:0;
        $ret = [
            'error'=>$result,
            'is_login'=>$is_login
        ];
        if(app()->configGet('app.debug')){
            $ret['debug'] = app('params')->get('info_logs');
        }
        return $ret;
    }

    /**
     * 对passport_uid_handle扩展进行封装
     * @param integer $puid
     * @return string
     */
    public function puidToEuid($puid)
    {
        $euid = '';
        if (extension_loaded('passport_uid_handle')) {
            $euid = p_encry_uid($puid);
        }
        return $euid;
    }

    /**
     * 加密
     */
    public function encrypt($code, $key){
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $code, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    /**
     * 转译字符串（防mysql注入）
     * @param string $string
     * @return string
     */
    public static function mysql_real_escape_string($var)
    {
        if(!empty($var)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $var);
        }

        return $var;
    }
}
