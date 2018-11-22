<?php
namespace Star\Util\Cache;

/**
 * Hash缓存结构
 *  - 基于哈希表[hash]
 *
 * @package Star\Util\Cache
 */
trait Hash
{
    /**
     * 保存
     *
     * @param string $field 主记录ID
     * @param string $value
     */
    public function save($field, $value)
    {
        self::connect()->hSet(self::$prefix, $field, $value);
    }

    /**
     * 获取
     *
     * @param string $field
     * @return string|null
     */
    public function get($field)
    {
        return self::connect()->hGet(self::$prefix, $field);
    }

    /**
     * 删除
     *
     * @param string $field 记录ID
     */
    public function delete($field)
    {
        self::connect()->hDel(self::$prefix, $field);
    }

    /**
     * 计数器做自增
     *
     * @param string $field
     * @param int $number
     */
    public function inc($field, $number = 1)
    {
        self::connect()->hIncrBy(self::$prefix, $field, $number);
    }

    /**
     * 计数器自减
     *
     * @param string $field
     * @param int $number
     */
    public function dec($field, $number = -1)
    {
        self::connect()->hIncrBy(self::$prefix, $field, $number);
    }
}