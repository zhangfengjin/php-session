<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/11
 * Time: 17:02
 */

namespace XYLibrary\Session\Middleware;


use XYLibrary\Session\SessionManager;

class StartSession
{
    protected $manager;

    public function __construct(SessionManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * session
     */
    public function handler()
    {
        $session = $this->startSession();
        //将当前请求的URL存储到session
        //添加cookie
        $config = app("config")["session"];
        $expired = $config['expire_on_close'] ? 0 : time() + $config['lifetime'];
        setcookie($session->getName(), $session->getId(), $expired,
            $config["path"], $config["domain"], $config["secure"], $config["http_only"]);
    }

    /**
     * 最终调用 将内存中的session持久化
     */
    public function terminate()
    {
        $this->manager->driver()->save();
    }

    /**
     * 启动session
     * @return mixed
     */
    protected function startSession()
    {
        return tap($this->getSession(), function ($session) {
            $session->start();
        });
    }

    /**
     * 获取session实现
     * @return mixed
     */
    protected function getSession()
    {
        return tap($this->manager->driver(), function ($session) {
            $session->setId(isset($_COOKIE[$session->getName()]) ? $_COOKIE[$session->getName()] : null);
        });
    }
}