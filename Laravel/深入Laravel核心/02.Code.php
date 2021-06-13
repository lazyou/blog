<?php

class Ioc
{
    public $binding = [];

    // 返回的是闭包，方便按需加载
    public function bind($abstract, $concrete) {
        if (!$concrete instanceof Closure) {
            $concrete = function ($ioc) use ($concrete) {
                return $ioc->build($concrete);
            };

            // TODO: 为什么 $concrete 的结构是 Closure Object{ 'static' => , 'this' => , 'parameter' => }
            // print_r($concrete); exit;
        }

        $this->binding[$abstract]['concrete'] = $concrete;

        // TODO: 结构还挺复杂
        // print_r($this->binding);
    }

    public function make($abstract) {
        $concrete = $this->binding[$abstract]['concrete'];

        return $concrete($this);
    }

    public function build($concrete) {
        $reflector = new ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();

        if(is_null($constructor)) {
            return $reflector->newInstance();
        }else {
            $dependencies = $constructor->getParameters();
            $instances = $this->getDependencies($dependencies);
            return $reflector->newInstanceArgs($instances);
        }
    }

    protected function getDependencies($paramters) {
        $dependencies = [];
        foreach ($paramters as $paramter) {
            // TODO: 接口 Log 是怎么解析为具体实现类的呢？ 请看 make 的调用，得到容器 bind 时的闭包
            $dependencies[] = $this->make($paramter->getClass()->name);
        }

        return $dependencies;
    }
}

interface Log
{
    public function write();
}

// 文件记录日志
class FileLog implements Log
{
    public function write() {
        echo 'file log write...';
    }
}

// 数据库记录日志
class DatabaseLog implements Log
{
    public function write() {
        echo 'database log write...';
    }
}

class User
{
    protected $log;

    public function __construct(Log $log) {
        $this->log = $log;
    }

    public function login() {
        // 登录成功，记录登录日志
        echo 'login success...';
        $this->log->write();
    }
}

// 实例化IoC容器
$ioc = new Ioc();

// TODO: 彻底解耦
// $ioc->bind('Log','FileLog');
$ioc->bind('Log', 'DatabaseLog');
$ioc->bind('User', 'User');

$user = $ioc->make('User');
$user->login();
exit;
