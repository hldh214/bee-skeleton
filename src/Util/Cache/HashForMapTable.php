<?php
namespace Star\Core\Cache;

use Star\Core\Exception\Exception;

/**
 * Hash映射数据表的缓存结构
 *  - 通过key（key = prefix + 数据表字段名称），field（主记录ID），value（数据字段值）实现对表数据缓存
 *  - 将一个表按照表字段结构拆分成多个hash
 *
 * @package Star\Core\Table
 */
trait HashForMapTable
{
    /**
     * 以HASH方式保存数据
     *  - 以数组key为HASH表名，主记录ID为key，数组value为value
     *
     * 此处封装针对HASH表及数据数据映射，其他类型或数据请重写覆盖
     *
     * @param mixed $id 主记录ID
     * @param array $data
     */
    public function save($id, array $data = [])
    {
        self::connect()->hSet(static::$prefix, $id, igbinary_serialize($data));
    }

    /**
     * 根据key去指定HASH表获取id对应数据
     *
     * @param int $id
     * @param string $field
     * @return string|false
     * @throws Exception
     */
    public function get($id, $field)
    {
        $data = $this->find($id);

        if (isset($data[$field])) {
            return $data[$field];
        }

        return false;
    }

    /**
     * 根据ID获取对应缓存所有数据
     * 即对应数据库哪一行数据
     *
     * @param int $id
     * @return array
     */
    public function find($id)
    {
        return igbinary_unserialize(static::connect()->hGet(static::$prefix, $id));
    }

    /**
     * 根据记录ID删除相关缓存数据
     *
     * @param mixed $id 记录ID
     */
    public function delete($id)
    {
        static::connect()->hDel(static::$prefix, $id);
    }

    /**
     * 检查指定数据是否存在
     *
     * @param int $id
     * @return int bool
     * @throws Exception
     */
    public function exist($id)
    {
        return static::connect()->hExists(static::$prefix, $id);
    }
}
