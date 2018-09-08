<?php
/**
 * 创建型模式
 *
 * php原型模式
 * 用于创建对象成本过高时
 *
 */

 // 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    $class = explode('\\', $class);
    $class = end($class) . '.php';
    require $class;
}

use prototype\Prototype;

// 创建一个原型对象
$prototype = new Prototype();

// 获取一个原型的 clone
$prototypeCloneOne = $prototype->getPrototype();
$prototypeCloneOne->_name = 'one';
$prototypeCloneOne->getName();

// 获取一个原型的 clone
$prototypeCloneTwo = $prototype->getPrototype();
$prototypeCloneTwo->_name = 'two';
$prototypeCloneTwo->getName();

// 再次获取 $prototypeCloneOne 的名称
$prototypeCloneOne->getName();
