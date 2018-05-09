<?php
/**
 * Created by PhpStorm.
 * User: yanghaonan
 * Date: 2018/5/3
 * Time: 13:35
 */
namespace app\Framework;
use light\App as AppOrigin;
use app\Framework\Http\Kernel as HttpKernel;
use light\Console\Kernel as ConsoleKernel;
class App extends AppOrigin{
    protected $component = [
        'app\Component\Log\LogComponent'
    ];
    /**
     * bootstrap
     */
    public function bootstrap()
    {
        set_exception_handler(['app\Framework\Exception\ExceptionHandler','handleException']);
        return parent::bootstrap();
    }

    /**
     * 注册 Kernel
     *
     * @return $this
     */
    public function registerKernel()
    {
        if ($this->runningInConsole()) {
            $this->register('ConsoleKernel', new ConsoleKernel($this));
        }
        else {
            $this->register('HttpKernel', new HttpKernel($this));
        }

        return $this;
    }
}
