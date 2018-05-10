yframeworks
====

PHP综合性框架

提供服务：组件、路由、中间件、异常处理、日志服务、debug

特点：

1.轻量级的model

2.可自定义不同的异常处理（继承UserException抽象类即可）

3.自定义中间件

4.常用组件：redis、yac、curl等

5.整合api获取服务：SCurl

6.开发环境debug （参考配置文件）设置debug=true。且使用app('common')->output()进行输出即可。或使用app('params')->get('log_infos')获取debug信息。
