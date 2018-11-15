<?php
namespace Star\Middleware;

use Phalcon\Events\Event;
use Star\Util\Micro;
use Star\Util\Exception;

/**
 * 日志记录中间件
 *
 * @package Pay\Http\Middleware
 */
class Log
{
    /**
     * 业务处理前置事件
     *
     * @param Event $event
     * @param Micro $micro
     * @param array $params
     */
    public function beforeHandleRequest(Event $event, Micro $micro, $params = [])
    {
        $this->save(
            [
                'request_id' => $micro->global['requestId'],
                'user_id'    => $micro->global['userId'],
                'type'       => 'http:before',
                'receive'    => [
                    'server' => $_SERVER,
                    'post'   => $_POST,
                    'get'    => $_GET,
                    'raw'    => $micro->request->getRawBody()
                ]
            ]
        );
    }

    /**
     * 业务处理中事件
     *
     * @param Event $event
     * @param Micro $micro
     * @param array $params
     */
    public function handleRequest(Event $event, Micro $micro, $params = [])
    {
        $this->save(
            [
                'request_id' => $micro->global['requestId'],
                'user_id'    => $micro->global['userId'],
                'type'       => 'http:handle',
                'running'    => $params
            ]
        );
    }

    /**
     * 业务处理结束事件
     *
     * @param Event $event
     * @param Micro $micro
     * @param array $params
     */
    public function afterHandleRequest(Event $event, Micro $micro, $params = [])
    {
        // 保存日志
        $this->save(
            [
                'request_id' => $micro->global['requestId'],
                'user_id'    => $micro->global['userId'],
                'type'       => 'http:after',
                'running'    => $params
            ]
        );
    }

    /**
     * 异常与错误
     *
     * @param Event $event
     * @param Micro $micro
     * @param \Throwable $throwable
     */
    public function handleThrowable(Event $event, Micro $micro, \Throwable $throwable)
    {
        $traces = $throwable->getTrace();
        $trace = array_shift($traces);

        // 异常信息
        $running = [
            'message'  => $throwable->getMessage(),
            'code'     => $throwable->getCode(),
            'file'     => $trace['file'] ?? '',
            'line'     => $trace['line'] ?? -1,
            'function' => $trace['function'],
            'trace'    => $traces,
        ];

        // 框架异常
        if ($throwable instanceof Exception) {
            $running['data'] = $throwable->data;
            $running['args'] = $throwable->args;
        }

        $log = [
            'request_id' => $micro->global['requestId'],
            'user_id'    => $micro->global['userId'],
            'type'       => 'http:exception',
            'running'    => $running
        ];

        // 保存日志
        $this->save($log);
    }

    /**
     * http shutdown
     *
     * @param Event $event
     * @param Micro $micro
     */
    public function handleShutdown(Event $event, Micro $micro)
    {
        // 获取错误信息
        $error = error_get_last();

        if ($error) {
            $log = [
                'request_id' => $micro->global['requestId'],
                'user_id'    => $micro->global['userId'],
                'type'       => 'http:shutdown',
                'running'    => $error
            ];

            $this->save($log);
        }
    }

    /**
     * 保存日志
     *  - 异步http方式
     *
     * @param array $data
     *
     */
    public function save($data = [])
    {
        $filename = RUNTIME_PATH . '/' . date('Y-m-d') . '.log';
        $data['create_time'] = time();
        file_put_contents($filename, json_encode($data) . PHP_EOL, 8);
    }
}
