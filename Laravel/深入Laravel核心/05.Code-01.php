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

function call_middware() {
    SetCookie::handle(function () {
        VerfiyAuth::handle(function() {
            $handle = function() {
                echo '当前要执行的程序!';
            };
            
            VerfiyCsrfToekn::handle($handle);
        });
    });
}

call_middware();
