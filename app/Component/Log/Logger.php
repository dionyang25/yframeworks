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

    /**
     * 显示debug改写addRecord
     */
    /**
     * Adds a log record.
     *
     * @param  int     $level   The logging level
     * @param  string  $message The log message
     * @param  array   $context The log context
     * @return Boolean Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = array())
    {
        if (!$this->handlers) {
            $this->pushHandler(new StreamHandler('php://stderr', static::DEBUG));
        }

        $levelName = static::getLevelName($level);

        // check if any handler will handle this message so we can return early and save cycles
        $handlerKey = null;
        reset($this->handlers);
        while ($handler = current($this->handlers)) {
            if ($handler->isHandling(array('level' => $level))) {
                $handlerKey = key($this->handlers);
                break;
            }

            next($this->handlers);
        }

        if (null === $handlerKey) {
            return false;
        }

        if (!static::$timezone) {
            static::$timezone = new \DateTimeZone(date_default_timezone_get() ?: 'UTC');
        }

        // php7.1+ always has microseconds enabled, so we do not need this hack
        if ($this->microsecondTimestamps && PHP_VERSION_ID < 70100) {
            $ts = \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)), static::$timezone);
        } else {
            $ts = new \DateTime(null, static::$timezone);
        }
        $ts->setTimezone(static::$timezone);

        $record = array(
            'message' => (string) $message,
            'context' => $context,
            'level' => $level,
            'level_name' => $levelName,
            'channel' => $this->name,
            'datetime' => $ts,
            'extra' => array(),
        );

        foreach ($this->processors as $processor) {
            $record = call_user_func($processor, $record);
        }

        //添加debug
        if($this->debug){
            $info_logs = app('params')->get('info_logs');
            $single_debug_log = $record;
            $single_debug_log['run_time(ms)'] = microtime(true)*1000 - $this->begin_time;
            $info_logs[] = $single_debug_log;
            app('params')->set('info_logs',$info_logs);
        }

        while ($handler = current($this->handlers)) {
            if (true === $handler->handle($record)) {
                break;
            }

            next($this->handlers);
        }

        return true;
    }
}
