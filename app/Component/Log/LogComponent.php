<?php
namespace app\Component\Log;
use light\Component;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;

/**
 * 参数存储组件
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/4/25
 * Time: 16:14
 */
class LogComponent implements Component {

    public function getAccessor()
    {
        return 'log';
    }

    /**
     * 组件注册方法
     *
     * @return mixed
     */
    public function register()
    {
        return function () {
            $file = app()->configGet('app.log.log_file', '/tmp/light.log');
            $level = app()->configGet('app.log.log_level', 'ERROR');
//            $handler = app()->configGet('app.log.log_handler');

//            if (!$handler || ! $handler instanceof HandlerInterface) {
                $handler = new StreamHandler($file, $level);
//            }
            $format = app()->configGet('app.log.format');
            $date_format = app()->configGet('app.log.date_format');
            //set formatter
            $formatter = new LineFormatter($format,$date_format);
            $handler->setFormatter($formatter);
            $log = new Logger(app()->name());
            $log->pushHandler($handler);
            if(app()->configGet('app.log.show_memory_usage')){
                $log->pushProcessor(new MemoryUsageProcessor());
                $log->pushProcessor(new MemoryPeakUsageProcessor());
            }
            return $log;
        };
    }
}
