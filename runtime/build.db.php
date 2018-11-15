<?php
return [
    // MySQL连接配置
    'mysql' => [
        'default' => [
            'adapter'  => 'Mysql',
            "host"     => 'gz-cdb-4wrd58ix.sql.tencentcdb.com',
            'username' => "dev",
            'password' => "xiaoheiban888DAFA",
            'dbname'   => "fsxq_pub",
            'port'     => 62008,
            'charset'  => 'utf8mb4'
        ]
    ],

    // Redis连接配置
    'redis' => [
        'default' => [
            'host'       => '193.112.141.56',
            'port'       => 16379,
            'persistent' => false,
            'auth'       => 'xiaoheiban123'
        ],
        // 认证缓存
        'auth' => [
            'host'       => '193.112.141.56',
            'port'       => 16379,
            'persistent' => false,
            'auth'       => 'xiaoheiban123'
        ]
    ],

    'mq' => [
        'default' => [
            'host'     => '193.112.141.56',
            'port'     => 5672,
            'login'    => 'guest',
            'password' => 'guest',
            'vhost'    => '/',
        ]
    ],
];