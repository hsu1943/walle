<?php

require __DIR__ . '/../vendor/autoload.php';

use Walle\App;

$config = require __DIR__ . '/config-test.php';
App::getInstance($config);

App::$app->log->add(date('Y-m-d H:i:s') . 'log add test' . PHP_EOL);
App::$app->cache->set('testkey', 'test cache content', 10);
var_dump(App::$app->cache->get('testkey'));