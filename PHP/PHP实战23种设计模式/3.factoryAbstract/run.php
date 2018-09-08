<?php
/**
 * 创建型模式
 *
 * php抽象工厂模式
 *
 * 说说我理解的 __工厂模式__ 和 __抽象工厂模式__的区别：
 *      工厂就是一个独立公司，负责生产对象；
 *      抽象工厂就是集团，负责生产子公司（工厂）；
 */
// 注册自加载
spl_autoload_register('autoload');

function autoload($class)
{
    $class = explode('\\', $class);
    $class = end($class) . '.php';
    require $class;
}

use factoryAbstract\Factory;
use factoryAbstract\Income;
use factoryAbstract\AnimalFactory;
use factoryAbstract\PlantFactory;

// 初始化一个动物生产线, 包含了一族产品
$animal = new AnimalFactory();

// 初始化一个植物生产线, 包含了一族产品
$plant = new PlantFactory();

function call(Factory $factory) {
    $earn = function (Income $income) {
        $income->money();
    };

    $earn($factory->createFarm());

    $earn($factory->createZoo());
}

call($animal);
call($plant);