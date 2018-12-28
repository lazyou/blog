<?php
$parentPid = getmypid(); // 这就是传说中16岁之前的记忆
$pid = pcntl_fork(); // 一旦调用成功，事情就变得有些不同了

if ($pid == -1) {
    die('fork failed');
} else if ($pid == 0) {
    $mypid = getmypid(); // 用getmypid()函数获取当前进程的PID
    echo 'I am child process. My PID is ' . $mypid . ' and my father\'s PID is ' . $parentPid . PHP_EOL;
} else {
    echo 'Oh my god! I am a father now! My child\'s PID is ' . $pid . ' and mine is ' . $parentPid . PHP_EOL;
}
