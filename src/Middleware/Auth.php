<?php
namespace Star\Middleware;

use Star\Util\Micro;
use Phalcon\Events\Event;

/**
 * 用户身份鉴权中间件
 *
 * @package Star\Middleware
 */
class Auth
{
    /**
     * 加密盐
     *
     * @var string
     */
    private $salt = '0dad8211701ccd71ded06c3d37871e8a==';

    /**
     * 路由匹配前置事件
     *  - 身份认证
     *  - 生成Request ID
     *
     * @param Event $event
     * @param Micro $micro
     * @return bool
     */
    public function beforeHandleRoute(Event $event, Micro $micro)
    {
        return true;
    }

    /**
     * 生成请求ID
     *
     * @param Micro $micro
     * @param $userId
     * @return string
     * @throws \Phalcon\Security\Exception
     */
    private function createRequestId(Micro $micro, $userId)
    {
        $time   = time();
        $random = $micro->security->getRandom()->hex(4);

        return "HTTP-{$time}-{$userId}-{$random}";
    }
}
