<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/11
 * Time: 17:04
 */

namespace XYLibrary\Session;


class SessionManager
{
    protected $app;

    protected $connectors;

    protected $connections;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * 添加session实现连接
     * @param $driver
     * @param \Closure $closure
     */
    public function addConnector($driver, \Closure $closure)
    {
        if (!isset($this->connectors[$driver])) {
            $this->connectors[$driver] = $closure;
        }
    }

    /**
     * 获取session具体实现
     * @param null $driver
     * @return mixed
     */
    public function driver($driver = null)
    {
        $driver = $driver ? $driver : $this->getDefaultDriver();
        if (!isset($this->connections[$driver])) {
            $instance = $this->resolve($driver);
            $this->connections[$driver] = new SessionStore($this->getCookieName(), $instance);
        }
        return $this->connections[$driver];
    }

    /**
     * 解析
     * @param $driver
     * @return mixed
     */
    protected function resolve($driver)
    {
        $instance = call_user_func($this->connectors[$driver]);
        $config = $this->getConfig();
        return $instance->connections($config);
    }

    /**
     * 获取session默认实现
     * @return mixed
     */
    protected function getDefaultDriver()
    {
        return $this->app["config"]["session"]["driver"];
    }

    /**
     * 获取session配置文件信息
     * @return mixed
     */
    protected function getConfig()
    {
        return $this->app["config"]["session"];
    }

    protected function getCookieName()
    {
        return $this->app["config"]["session"]["cookie"];
    }

    public function __call($method, $arguments)
    {
        return $this->driver()->$method(...$arguments);
    }

}