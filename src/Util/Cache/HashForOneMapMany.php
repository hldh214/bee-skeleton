<?php
namespace Star\Util\Cache;

/**
 * Hash一对多的缓存结构
 *  - 通过key（key = prefix + ID）实现一对多的缓存
 *
 * @package Star\Core\Table
 */
trait HashForOneMapMany
{
    /**
     * 保存
     *
     * @param string $cate
     * @param string $field 主记录ID
     * @param string $value
     */
    public function save($cate, $field, $value)
    {
        $table = self::$prefix . $cate;
        self::connect()->hSet($table, $field, $value);
    }

    /**
     * 获取指定field的value
     *
     * @param string $cate
     * @param string $field
     * @return mixed
     */
    public function get($cate, $field)
    {
        $table = self::$prefix . $cate;
        return self::connect()->hGet($table, $field);
    }

    /**
     * 获取所有Hash数据
     *
     * @param string $cate
     * @return string|false
     */
    public function find($cate)
    {
        $table = self::$prefix . $cate;
        return self::connect()->hGetAll($table);
    }

    /**
     * 检查数据是否存在
     *
     * @param string $key
     * @param int $field
     * @return bool
     */
    public function exist($key, $field)
    {
        $table = self::$prefix . $key;
        return self::connect()->hGet($table, $field);
    }

    /**
     * 删除
     *
     * @param string $cate
     * @param string $field 记录ID
     */
    public function delete($cate, $field)
    {
        $table = self::$prefix . $cate;
        self::connect()->hDel($table, $field);
    }

    /**
     * 计数器做自增
     *
     * @param string $cate
     * @param string $field
     * @param int $number
     */
    public function inc($cate, $field, $number = 1)
    {
        $table = self::$prefix . $cate;
        self::connect()->hIncrBy($table, $field, $number);
    }

    /**
     * 计数器自减
     *
     * @param string $cate
     * @param string $field
     * @param int $number
     */
    public function dec($cate, $field, $number = -1)
    {
        $table = self::$prefix . $cate;
        self::connect()->hIncrBy($table, $field, $number);
    }

    /**
     * 获取总记录数
     *
     * @param string $cate
     * @return mixed
     */
    public function count($cate)
    {
        $table = self::$prefix . $cate;
        return self::connect()->hLen($table);
    }
}