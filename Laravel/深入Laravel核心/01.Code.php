<?php

interface log
{
    public function write();
}

// 文件记录日志
class FileLog implements Log
{
    public function write(){
        echo 'file log write...';
    }
}

// 数据库记录日志
class DatabaseLog implements Log
{
    public function write(){
        echo 'database log write...';
    }
}

class User
{
    protected $log;
    public function __construct(FileLog $log)
    {
        $this->log = $log;
    }
    public function login()
    {
        // 登录成功，记录登录日志
        echo 'login success...';
        $this->log->write();
    }
}

function make($concrete){
    var_dump($concrete);

    $reflector = new ReflectionClass($concrete);
    $constructor = $reflector->getConstructor();
    // 如果没有构造函数，则直接创建对象
    if(is_null($constructor)) {
        return $reflector->newInstance();
    }else {
        // 构造函数依赖的参数
        $dependencies = $constructor->getParameters();
        // 根据参数返回实例 -- TODO: 这里发生递归
        $instances = getDependencies($dependencies);
        return $reflector->newInstanceArgs($instances);
    }
}

function getDependencies($paramters) {
    var_dump($paramters);

    $dependencies = [];
    foreach ($paramters as $paramter) {
        $dependencies[] = make($paramter->getClass()->name);
    }

    return $dependencies;
}

$user = make('User');
$user->login();
exit;
