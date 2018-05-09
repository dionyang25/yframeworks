<?php
namespace app\Component\Log;
use light\Component;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\HandlerInterface;
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
            $file = app()->configGet('app.log_file', '/tmp/light.log');
            $level = app()->configGet('app.log_level', 'ERROR');
            $handler = app()->configGet('app.log_handler');

            if (!$handler || ! $handler instanceof HandlerInterface) {
                $handler = new StreamHandler($file, $level);
            }
            $format = app()->configGet('app.log_config.format');
            $date_format = app()->configGet('app.log_config.date_format');
            //set formatter
            $formatter = new LineFormatter($format,$date_format);
            $handler->setFormatter($formatter);
            $log = new Logger(app()->name());
            $log->pushHandler($handler);

            return $log;
        };
    }
}
