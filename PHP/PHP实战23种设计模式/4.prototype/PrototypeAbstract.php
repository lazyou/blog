<?php
namespace prototype;

/**
 * 原型接口
 */
abstract class PrototypeAbstract
{
    /**
     * 名字
     * 
     * @return string
     */
    protected $_name;

    abstract public function getName();

    /**
     * 获取原型对象
     * 
     * @return object
     */
    abstract public function getPrototype();
}
