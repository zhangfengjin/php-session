<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/11
 * Time: 17:24
 */

namespace XYLibrary\Session\Connectors;


use XYLibrary\Session\Store\FileSession;

class FileConnector implements ConnectorInterface
{
    protected $app;

    function __construct($app)
    {
        $this->app = $app;
    }

    function connections($config)
    {
        return new FileSession($this->app["files"], $config["files"], $config["lifetime"]);
    }
}