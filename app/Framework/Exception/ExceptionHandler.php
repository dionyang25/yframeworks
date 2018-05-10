<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/7
 * Time: 19:41
 * 错误处理handler
 */
namespace app\Framework\Exception;
use light\Http\Response;

class ExceptionHandler{

    public static function handleException($exception)
    {
        /**
         * 接口返回
         */
        if ($exception instanceof UserException) {
            return $exception->handle();
        }

        //去除handler注册防止循环调用
        restore_error_handler();
        restore_exception_handler();

        //处理错误 记录日志
        app('log')->error('runtime exception: '. $exception->getMessage(), [
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ]);
            if (app()->configGet('app.debug')) {
                throw new \Exception('Http Request handle error', $exception->getCode(), $exception);
            }
            //生产屏蔽exception
            $ret = app('common')->error_output(
                [
                    'id'=>99999
                ]
            );
            $response = new Response($ret, is_subclass_of($exception, 'light\Exceptions\HttpException') ? $exception->getStatusCode() : $exception->getCode());
            $response->send();
            return false;
    }

    /**
     * Unregisters this error handler by restoring the PHP error and exception handlers.
     */
    public function unregister()
    {
        restore_error_handler();
        restore_exception_handler();
    }
}
