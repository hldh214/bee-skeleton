<?php
return [
    // MySQL配置 - 开发环境生成模型
    'database' => [
        'adapter'  => 'Mysql',
        "host"     => 'gz-cdb-4wrd58ix.sql.tencentcdb.com',
        'username' => "dev",
        'password' => "xiaoheiban888DAFA",
        'dbname'   => "fsxq_pub",
        'port'     => 62008,
        'charset'  => 'utf8mb4'
    ],

    // 应用配置 - 开发环境使用
    'application' => [
        'modelsDir' => __DIR__ . '/src/Model/'
    ],
];