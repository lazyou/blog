<?php
interface Milldeware {
    public static function handle(Closure $next);
}

class VerfiyCsrfToekn implements Milldeware {

    public static function handle(Closure $next)
    {
        echo '验证csrf Token <br>';
        $next();
    }
}

class VerfiyAuth implements Milldeware {

    public static function handle(Closure $next)
    {
        echo '验证是否登录 <br>';
        $next();
    }
}

class SetCookie implements Milldeware {
    public static function handle(Closure $next)
    {
        $next();
        echo '设置cookie信息！';
    }
}

$handle = function() {
    echo '当前要执行的程序!';
};

$pipe_arr = [
    'VerfiyCsrfToekn',
    'VerfiyAuth',
    'SetCookie',
];

$callback = array_reduce($pipe_arr, function($stack, $pipe) {
    // var_dump($stack);
    // var_dump($pipe);
    return function() use($stack, $pipe){
        return $pipe::handle($stack);
    };
},$handle);

// $callback();
call_user_func($callback);
