<?php
/**
 * 1. 单例模式
 * https://github.com/TIGERB/easy-tips/blob/master/patterns/singleton/Singleton.php
 * 
 * 单例模式维基百科介绍: https://zh.wikipedia.org/wiki/%E5%8D%95%E4%BE%8B%E6%A8%A1%E5%BC%8F
 *  1. 一个类能返回对象一个引用(永远是同一个)和一个获得该实例的方法（必须是静态方法，通常使用 `getInstance` 这个名称）;
 * 
 *  2. 当我们调用这个方法时，如果类持有的引用不为空就返回这个引用，如果类保持的引用为空就创建该类的实例并将实例的引用赋予该类保持的引用；
 * 
 *  3. 同时我们还将该类的 __构造函数定义为私有方法__，这样其他处的代码就无法通过调用该类的构造函数来实例化该类的对象，只有通过该类提供的静态方法来得到该类的唯一实例
 * 
 *  注意点： 单例模式在 __多线程__ 的应用场合下必须小心使用
 */

class Singleton 
{
    /**
     * 自身实例
     *
     * @var object
     */
    private static $_instance;

    /**
     * 计数
     *
     * @var integer
     */
    protected $count = 0;

    /**
     * 构造函数
     * 构造函数设置为 private 属性, 使类不能被 new
     */
    private function __construct() 
    {
    }

    /**
     * 魔术方法
     * 禁止使用 clone() 函数 clone 对象
     *
     * @return void
     */
    public function __clone()
    {
        echo "clone is forbidden \n";
    }

    /**
     * 获取实例
     * 若已有对象实例就直接返回, 单例模式的核心
     *
     * @return object
     */
    public static function getInstance()
    {
        if (! self::$_instance instanceof self) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function test()
    {
        $this->count++;

        echo "这是个测试 -- count = {$this->count} \n";
    }
}

/**
 * 使用
 */

// 获取单例
$instance = Singleton::getInstance();
$instance->test();

// 无法通过 new 实例类
// $instanceNew = new Singleton();

// clone对象试试
$instanceClone = clone $instance;

// 再次获取单例 (注意 count 的值)
$instance = Singleton::getInstance();
$instance->test();
