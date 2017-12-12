<?php
/**
 * Created by PhpStorm.
 * User: fengjin1
 * Date: 2017/12/11
 * Time: 17:11
 */

namespace XYLibrary\Session\Store;


use XYLibrary\Utils\Filesystem;

class FileSession implements \SessionHandlerInterface
{
    protected $fileSystem;
    protected $path;
    protected $minutes;

    public function __construct(Filesystem $filesystem, $path, $minutes)
    {
        $this->fileSystem = $filesystem;
        $this->path = $path;
        $this->minutes = $minutes;
    }

    public function open($save_path, $name)
    {
        return true;
    }

    /**
     * @param string $session_id
     * @return string
     */
    public function read($session_id)
    {
        if ($this->fileSystem->exists($path = ($this->path . "/$session_id"))) {
            $timestamp = time() - $this->minutes * 60;
            if (filemtime($path) >= $timestamp) {
                //没有过期
                return $this->fileSystem->get($path, true);
            }
        }
        return '';
    }

    /**
     * 写入
     * @param string $session_id
     * @param string $session_data
     * @return bool
     */
    public function write($session_id, $session_data)
    {
        $this->fileSystem->put($this->path . "/" . $session_id, $session_data, true);
        return true;
    }

    public function close()
    {
        return true;
    }

    /**
     * session 销毁
     * @param string $session_id
     * @return bool
     */
    public function destroy($session_id)
    {
        $this->fileSystem->delete($this->path . "/" . $session_id);
        return true;
    }

    /**
     * session回收
     * @param int $maxlifetime
     */
    public function gc($maxlifetime)
    {
        //获取session文件夹下所有过期文件
        //删除
    }
}