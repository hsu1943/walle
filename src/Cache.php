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
        if (!isset($config['path']) || empty($config['path'])) {
            throw new \ErrorException('can\'t find the "path" of cache in "config.php"');
        }
        if (!isset($config['key']) || empty($config['key'])) {
            throw new \ErrorException('can\'t find the "key" of cache in "config.php"');
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
        list($fileKey, $subDir) = $this->getMd5Key($key);
        $filePath = $this->path . $subDir . '/' . $fileKey;
        if (!file_exists($filePath)) {
            return false;
        }
        $str = file_get_contents($filePath);
        $data = unserialize($str);
        if ($data[1] == 0 || (time() < ($data[1] + $data[2]))) {
            // 未过期或永不过期
            $value = empty($data[0]) ? '' : json_decode($data[0], true);
            return $value;
        }
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        return false;
    }

    /**
     * 设置缓存
     * @param $key string
     * @param $value string
     * @param int $expire 过期时间单位（s）默认0永不过期
     * @return bool
     */
    public function set($key, $value, $expire = 0)
    {
        list($fileKey, $subDir) = $this->getMd5Key($key);
        $path = $this->path . $subDir;
        if ($value === null && file_exists($path . '/' . $fileKey)) {
            unlink($path . '/' . $fileKey);
            return true;
        }
        $value = empty($value) ? '' : json_encode($value, 320);
        if (!$key || !is_string($value) || !is_int($expire)) {
            return false;
        }
        $dataStr = serialize([$value, $expire, time()]);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
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