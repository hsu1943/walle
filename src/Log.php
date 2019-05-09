<?php

/**
 * File Log
 * User: husu1943
 * Date: 2019/4/20
 * Time: 10:06
 */

namespace Walle;

class Log
{
    private $logFile;

    function __construct($path)
    {
        if (empty($path)) {
            $path = __DIR__ . '/runtime/log/';
        }
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }
        $this->logFile = $path . 'app_' . date('Ymd') . '.log';
    }

    public function add($msg)
    {
        file_put_contents($this->logFile, $msg, FILE_APPEND);
    }

    public static function is_json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}