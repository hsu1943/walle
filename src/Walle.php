<?php

namespace Walle;

/**
 * Class Walle
 * @package Walle
 * @property Db $db
 * @property Cache $cache
 * @property Log $log
 * @property Walle $app
 */
class Walle
{
    public $config;
    public $db;
    public $log;
    public $cache;
    public static $app;

    function __construct($config)
    {
        $this->config = $config;
        $this->log = new Log($this->getConfig('log')['path']);
        $this->cache = new Cache($this->getConfig('cache'));
    }

    public function getConfig($key)
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : false;
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance($config)
    {
        if (!(self::$app instanceof Walle)) {
            self::$app = new Walle($config);
        }
        return self::$app;
    }

    public function initDb()
    {
        if($this->db == null) {
            $this->db = new Db($this->getConfig('db'));
        }
        return $this->db;
    }

}