<?php
namespace prototype;

/**
 * 原型实体
 */
class Prototype extends PrototypeAbstract
{
    /**
     * 构造函数
     */
    public function __construct($name = '')
    {
        $this->_name = $name;
    }

    /**
     * 魔术方法 设置属性
     */
    public function __set($name = '', $value = '')
    {
        // $name 动态添加属性
        $this->$name = $value;
    }

    /**
     * 打印对象名
     */
    public function getName()
    {
        echo "我是对象" . $this->_name . "\n\r";
    }

    /**
     * 获取原型对象
     */
    public function getPrototype()
    {
        return clone $this;
    }
}
