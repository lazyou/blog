<?php
namespace factory;

/**
 * 农场
 * 
 * 生产动物
 */
class Farm implements factory
{
    public function __construct()
    {
        echo "初始化了一个农场 \n\r";
    }

    /**
     * 生产方法
     * 
     * 生产动物
     * 
     * @param string $type 动物类型
     */
    public function produce($type = '')
    {
        switch ($type) {
            case 'chicken':
                return new Chicken();
                break;
            case 'pig':
                return new Pig();
                break;
            default:
                echo "该农场不支持产生该农物\n\r";
                break;
        }
    }
}
