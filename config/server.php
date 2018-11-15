<?php
return [
    // http服务配置
    'http' => [
        'name'   => 'bee-http',
        'host'   => '0.0.0.0',
        'port'   => 8000,
        'option' => [
            'pid_file'          => RUNTIME_PATH . '/http.pid',
            'log_file'          => RUNTIME_PATH . '/http_server.log',
            'worker_num'        => 8,
            'daemonize'         => true,
            'dispatch_mode'     => 3,
            'enable_coroutine'  => false,
            'open_cpu_affinity' => true,
            'max_request'       => 5000, // 单个worker处理请求数达到5000，自动退出
            'backlog'           => 1024,
        ]
    ]
];