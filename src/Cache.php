<?php

/**
 * file Cache
 * User: hsu1943
 * Date: 2019/4/20
 * Time: 14:44
 */

namespace Walle;

class Cache
{
    private $path;
    private $cacheKey;

    function __construct($config)
    {
        if (empty($config['path'])) {
            $config['path'] = __DIR__ . '/runtime/cache/';
        }
        if (!is_dir($config['path'])) {
            @mkdir($config['path'], 0777, true);
        }
        $this->path = $config['path'];
        $this->cacheKey = $config['key'];
    }

    /**
     * 获取缓存
     * @param $key
     * @return bool
     */
    public function get($key)
    {
        $keydata = $this->getMd5Key($key);
        $fileKey = $keydata[0];
        $subDir = $keydata[1];
        $filepath = $this->path . $subDir . '/' . $fileKey;
        if (!file_exists($filepath)) {
            return false;
        }
        $str = file_get_contents($filepath);
        $data = unserialize($str);
        if ($data[1] == 0 || (time() < ($data[1] + $data[2]))) {
            return $data[0];
        }
        unlink($filepath);
        return false;
    }

    /**
     * 设置缓存
     * @param $key string
     * @param $value string
     * @param int $expire 过期时间单位（s）
     * @return bool
     */
    public function set($key, $value, $expire = 0)
    {
        if (!$key || !is_string($value) || !is_int($expire)) {
            return false;
        }
        $keydata = $this->getMd5Key($key);
        $fileKey = $keydata[0];
        $subDir = $keydata[1];
        $dataStr = serialize([$value, $expire, time()]);
        $path = $this->path . $subDir;
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }
        file_put_contents($path . '/' . $fileKey, $dataStr);
        return true;
    }


    private function getMd5Key($key)
    {
        $str = md5($this->cacheKey . $key);
        return [$str, substr($str, 0, 3)];
    }

    public static function randStr($len)
    {
        $strs = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm_";
        $randStr = '';
        for ($i = 0; $i < $len; $i++) {
            $randStr .= $strs[mt_rand(0, strlen($strs) - 1)];
        }
        return $randStr;
    }
}