<?php
namespace factory;

/**
 * 实体鸡
 */
class Chicken implements AnimalInterface
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        echo "产生了一只鸡 \n\r";
    }
}
