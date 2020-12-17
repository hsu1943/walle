<?php

/**
 * Database
 * User: hsu1943
 * Date: 2019/4/20
 * Time: 10:06
 */

namespace Walle;

use PDO;

class Db
{
    public $conn;
    public $config;

    function __construct($config)
    {
        if (empty($config['host']) || empty($config['user']) || empty($config['dbName']) || empty($config['pass'])) {
            throw new \ErrorException('db parameter error');
        }
        $this->config = $config;
    }

    public function init()
    {
        if ($this->conn == null) {
            $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->config['host']}; dbname={$this->config['dbName']}; charset=UTF8MB4",
                    $this->config['user'],
                    $this->config['pass'],
                    $option
                );
            } catch (\Exception $e) {
                throw new \PDOException($e->getMessage());
            }
        }
        return $this->conn;
    }
}
