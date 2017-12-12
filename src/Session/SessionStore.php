<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/11
 * Time: 17:09
 */

namespace XYLibrary\Session;


class SessionStore implements SessionStoreInterface
{
    protected $handler;

    protected $name;

    protected $sessionId;

    protected $attributes = [];

    protected $started = false;

    public function __construct($name, \SessionHandlerInterface $sessionHandler)
    {
        $this->name = $name;
        $this->handler = $sessionHandler;
    }

    /**
     * 启动session
     * @return bool
     */
    public function start()
    {
        $this->loadSession();
        return $this->started = true;
    }

    /**
     * 加载session内容到内存
     */
    protected function loadSession()
    {
        $this->attributes = array_merge($this->attributes, $this->readFromHandler());
    }

    /**
     * 通过handler具体session实现读取session内容
     * @return array|mixed|string
     */
    protected function readFromHandler()
    {
        if ($data = ($this->handler->read($this->getId()))) {
            $data = @unserialize($data);
            if ($data != false && !is_null($data) && is_array($data)) {
                return $data;
            }
        }
        return [];
    }

    /**
     * 保存-持久化
     */
    function save()
    {
        $this->handler->write($this->getId(), serialize($this->attributes));
        $this->started = false;
    }

    /***
     * 获取session中所有信息
     * @return array
     */
    function all()
    {
        return $this->attributes;
    }

    /**
     * 获取session中指定的key
     * @param $key
     * @param null $default
     * @return mixed
     */
    function get($key, $default = null)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        return value($default);
    }

    /**
     * 获取session中的key 同时删除key
     * @param $key
     * @param null $value
     * @return mixed
     */
    function pull($key, $value = null)
    {
        return tap($this->get($key, $value), function ($value) use ($key) {
            $this->forget($key);
        });
    }

    /**
     * 存放session key\value
     * @param $key
     * @param null $value
     */
    function put($key, $value = null)
    {
        if (!is_array($key)) {
            $key = [$key => $value];
        }
        foreach ($key as $arrKey => $arrValue) {
            $this->attributes[$arrKey] = $arrValue;
        }
    }

    /**
     * 移除 返回移除key对应的value
     * @param $key
     * @return mixed
     */
    function remove($key)
    {
        return $this->pull($key);
    }

    /**
     * 删除
     * @param $keys
     */
    function forget($keys)
    {
        $keys = (array)$keys;
        foreach ($keys as $key) {
            if (array_key_exists($key, $this->attributes)) {
                unset($this->attributes[$key]);
            }
        }
    }

    /**
     * 清空session
     */
    function flush()
    {
        $this->attributes = [];
    }

    /**
     * 是否存在
     * @param $key
     * @return bool
     */
    function exists($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * 是否存在且存在是否为null
     * @param $key
     * @return bool
     */
    function has($key)
    {
        return is_null($this->get($key));
    }

    /**
     * 获取session name
     * @return mixed
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * 获取session id
     * @return mixed
     */
    function getId()
    {
        return $this->sessionId;
    }

    /**
     * 设置session id
     * @param $id
     */
    function setId($id)
    {
        $this->sessionId = $id ? $id : md5($this->getName() . time());
    }

}