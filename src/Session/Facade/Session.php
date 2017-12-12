<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/12
 * Time: 15:04
 */

namespace XYLibrary\Session\Facade;


use XYLibrary\Facade\Facade;

class Session extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "session";
    }
}