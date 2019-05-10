<?php

/**
 * Config
 * User: hsu1943
 * Date: 2019/4/20
 * Time: 10:11
 */

$config = [
    'log' => [
        'path' => __DIR__ . '/runtime/log/',
    ],
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'dbName' => 'test',
        'pass' => 'root',
        'port' => '3306',
    ],
    'cache' => [
        'path' => __DIR__ . '/runtime/cache/',
        'key' => 'WFrwQhqeLNidJ_aXzNt24QyCpYuWqY0m',
    ],
    'mail' => [
        'stmp' => 'smtp.qq.com',
        'port' => '465',
        'username' => '88888888@qq.com',
        'password' => 'mcpvfesfesgesgescajd',
        'email' => '88888888@qq.com',
    ],
];
return $config;