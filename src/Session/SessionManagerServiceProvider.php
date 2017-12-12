<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/12
 * Time: 14:31
 */

namespace XYLibrary\Session;


use XYLibrary\Contracts\ServiceProvider\Factory as ServiceProvider;
use XYLibrary\IoC\Container;
use XYLibrary\Session\Connectors\FileConnector;
use XYLibrary\Session\Middleware\StartSession;

class SessionManagerServiceProvider implements ServiceProvider
{
    protected $app;

    function __construct(Container $app)
    {
        $this->app = $app;
    }

    function register()
    {
        $this->registerSession();
        $this->registerStartSession();
    }

    /**
     *注册session
     */
    function registerSession()
    {
        $this->app->bind("session", function ($app) {
            return tap(new SessionManager($app), function ($manager) {
                $this->registerFileSession($manager);
            });
        });
    }

    /**
     * 注册file session
     * @param $manager
     */
    function registerFileSession($manager)
    {
        $manager->addConnector("file", function () {
            return new FileConnector($this->app);
        });
    }

    /**
     * 注册
     */
    function registerStartSession()
    {
        $this->app->bind("session.start", function ($app) {
            return new StartSession($this->app["session"]);
        });
    }
}