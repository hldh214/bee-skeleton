<?php

namespace Star\Util\Cache;

/**
 * List 缓存结构
 *  - 基于字符串[List]
 *
 * @package Star\Util\Cache
 */
Trait ListObject
{
    public function rpush($key, $value)
    {
        return self::connect()->rpush(self::$prefix . $key, $value);
    }

    public function lpush($key, $value)
    {
        return self::connect()->lpush(self::$prefix . $key, $value);
    }

    public function lsize($key)
    {
        return self::connect()->lsize(self::$prefix . $key);
    }

    public function blpop($keys, $timeout)
    {
        return self::connect()->blpop(array_map(function ($each) {
            return self::$prefix . $each;
        }, $keys), $timeout);
    }
}
