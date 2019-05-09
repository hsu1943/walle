<?php

/**
 * Database
 * User: hsu1943
 * Date: 2019/4/20
 * Time: 10:06
 */

namespace Walle;

class Db
{
    public $conn;
    public $config;

    function __construct($config)
    {
        if (empty($config['host']) || empty($config['user']) || empty($config['dbName']) || empty($config['pass'])) {
            throw new \ErrorException('参数错误');
        }
        $this->config = $config;
    }

    public function init()
    {
        if ($this->conn == null) {
            try {
                $this->conn = new \PDO(
                    "mysql:host={$this->config['host']}; dbname={$this->config['dbName']}; charset=UTF8MB4",
                    $this->config['user'],
                    $this->config['pass']
                );
            } catch (\Exception $e) {
                echo "Error!: " . $e->getMessage() . PHP_EOL;
                $this->conn = null;
            }
        }
        return $this->conn;
    }
}
