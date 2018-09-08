<?php
/**
Tick（时钟周期）是一个在 declare 代码段中解释器每执行 N 条可计时的低级语句就会发生的事件。N 的值是在 declare 中的 directive 部分用 ticks=N 来指定的。

不是所有语句都可计时。通常条件表达式和参数表达式都不可计时。

在每个 tick 中出现的事件是由 register_tick_function() 来指定的。更多细节见下面的例子。注意每个 tick 中可以出现多个事件。
 */
// http://php.net/manual/zh/control-structures.declare.php
declare(ticks=1);

// A function called on each tick event
function tick_handler()
{
    echo "tick_handler() called \n";
}

register_tick_function('tick_handler');

$a = 1;

if ($a > 0) {
    $a += 2;
    var_dump($a);
}
