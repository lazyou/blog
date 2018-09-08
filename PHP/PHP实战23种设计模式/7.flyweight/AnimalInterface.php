<?php
namespace flyweight;

/**
 * 动物接口
 * @package flyweight
 */
interface AnimalInterface
{
    /**
     * 获取类型
     * @return string
     */
    public function getType();
}