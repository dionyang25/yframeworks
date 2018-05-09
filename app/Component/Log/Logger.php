<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/7
 * Time: 18:07
 */
namespace app\Component\Log;
use Monolog\Logger as LoggerOrigin;
class Logger extends LoggerOrigin {
    private $debug = false;
    private $begin_time;

    public function __construct($name, $handlers = array(), $processors = array())
    {
        $this->debug = app()->configGet('app.debug');
        if($this->debug){
            //记录起始时间
            $this->begin_time = microtime(true)*1000;
        }
        parent::__construct($name, $handlers, $processors);
    }

    //改写info 使其在测试环境能够将错误记录于输出
    public function info($message, array $context = array())
    {
        if($this->debug){
            $info_logs = app('params')->get('info_logs');
            $info_logs[] = [
                'message'=>$message,
                'context'=>$context,
                'run_time(ms)'=>microtime(true)*1000-$this->begin_time
            ];
            app('params')->set('info_logs',$info_logs);
        }
        return parent::info($message, $context);
    }
}
