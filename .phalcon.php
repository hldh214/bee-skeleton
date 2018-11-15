<?php
return [
    // MySQL配置 - 开发环境生成模型
    'database' => [
        'adapter'  => 'Mysql',
        "host"     => 'host',
        'username' => "user",
        'password' => "pass",
        'dbname'   => "fsxq_pub",
        'port'     => 62008,
        'charset'  => 'utf8mb4'
    ],

    // 应用配置 - 开发环境使用
    'application' => [
        'modelsDir' => __DIR__ . '/src/Model/'
    ],
];