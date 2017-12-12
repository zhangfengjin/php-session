<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/11
 * Time: 17:23
 */

namespace XYLibrary\Session\Connectors;


interface ConnectorInterface
{
    /**
     * 连接缓存实现接口
     * 返回具体的缓存实现对象实例FileStore\CacheStore等
     * @param $config
     * @return mixed
     */
    function connections($config);
}