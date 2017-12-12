<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/11
 * Time: 17:09
 */

namespace XYLibrary\Session;


interface SessionStoreInterface
{
    /**
     * 获取存储sessionId的cookie名称
     * @return mixed
     */
    function getName();

    /**
     * session id
     * @return mixed
     */
    function getId();

    /**
     * 设置session id
     * @param $id
     * @return mixed
     */
    function setId($id);

    /**
     * 启动session
     * @return mixed
     */
    function start();

    /**
     * 保存-持久化
     * @return mixed
     */
    function save();

    /**
     * 获取session中的所有信息
     * @return mixed
     */
    function all();

    /**
     * 获取session中指定的key
     * @param $key
     * @param null $default
     * @return mixed
     */
    function get($key, $default = null);

    /**
     * 获取session中的key 同时删除key
     * @param $key
     * @param null $value
     * @return mixed
     */
    function pull($key, $value = null);

    /**
     * 向session中添加key\value
     * @param $key
     * @param null $value
     * @return mixed
     */
    function put($key, $value = null);

    /**
     * 移除session中的key
     * @param $key
     * @return mixed
     */
    function remove($key);

    /**
     * 删除session中指定的keys
     * @param $keys
     * @return mixed
     */
    function forget($keys);

    /**
     * 删除session中的内容
     * @return mixed
     */
    function flush();

    /**
     * session中是否存在key
     * @param $key
     * @return mixed
     */
    function exists($key);

    /**
     * session是否存在且是否为null
     * @param $key
     * @return mixed
     */
    function has($key);
}