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

class ServiceManagerServiceProvider implements ServiceProvider
{
    protected $app;

    function __construct(Container $app)
    {
        $this->app = $app;
    }

    function register()
    {

    }

    function registerSession()
    {
        $this->app->bind("session", function ($app) {
            return new
        });
    }
}