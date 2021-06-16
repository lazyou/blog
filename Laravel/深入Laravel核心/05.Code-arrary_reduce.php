<?php
/**
 * array_reduce() 将回调函数 callback 迭代地作用到 array 数组中的每一个单元中，从而将数组简化为单一的值。
 * 
 * array: 输入的 array。
 * 
 * callback: callback(mixed $carry, mixed $item): mixed
 *      carry: 携带上次迭代的返回值； 如果本次迭代是第一次，那么这个值是 initial。
 *      item: 携带了本次迭代的值。
 *
 * initial: 如果指定了可选参数 initial，该参数将用作处理开始时的初始值，如果数组为空，则会作为最终结果返回。
 */
$arr = ['a', 'b', 'c', 'd'];

// 函数没有 return，所以每次 $carry 都为 NULL
function dump($carry, $item) {
    print_r('$carry == ');
    var_dump($carry);

    print_r('$item == ');
    var_dump($item);

    echo PHP_EOL;
}

$res1 = array_reduce($arr, "dump");
print_r('$res1:');
print_r($carry);


function dumpSum($carry, $item) {
    print_r('$carry == ');
    var_dump($carry);

    print_r('$item == ');
    var_dump($item);

    echo PHP_EOL;
    return "{$carry}{$item}";
}

var_dump("============================");echo PHP_EOL;
$res2 = array_reduce($arr, "dumpSum");
print_r('$res2:');
print_r($carry);
