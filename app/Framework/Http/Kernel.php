<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/3
 * Time: 13:44
 */
namespace app\Framework\Http;
use app\Framework\Router;
use light\Http\Kernel as KernelOrigin;
use Exception;
use light\Http\Request;
use light\Http\Response;

class Kernel extends KernelOrigin{
    /**
     * 处理 Request 请求
     *
     * @param Request $request
     *
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request)
    {
            // 注册 Request
            $this->app->register('request', $request);

            // 启用 App
            $this->app->bootstrap();

            // 加载 Router
            $router = new Router();
            require $this->app->basePath.'/bootstrap/routes.php';

            // 注册 Router
            $this->app->register('router', $router);

            // 任务分发
            $response = $router->dispatch($request);

        return $response;
    }
}
