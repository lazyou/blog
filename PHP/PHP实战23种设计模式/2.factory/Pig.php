<?php
namespace factory;

/**
 * 实体猪
 */
class Pig implements AnimalInterface
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        echo "产生了一只猪 \n\r";
    }
}
