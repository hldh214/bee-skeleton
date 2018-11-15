<?php
require __DIR__ . '/../../.htrouter.php';

// 创建容器
$di = new \Phalcon\Di();

// 注册系统默认组件
$di->setShared('eventsManager',Phalcon\Events\Manager::class);
$di->setShared('modelsManager',Phalcon\Mvc\Model\Manager::class);
$di->setShared('modelsMetadata', \Phalcon\Mvc\Model\MetaData\Memory::class);

// 加载框架自定义组件
require(CONFIG_PATH . '/di.php');
// 加载中间件
require(CONFIG_PATH . '/middleware.php');

// 实例化应用
$micro = new \Star\Util\Micro($di);

$micro->db->query('show databases');