<?php
// 定义一个处理器，接收到SIGINT信号后只输出一行信息
function signalHandler($signal)
{
    if ($signal == SIGINT) {
        echo 'signal received' . PHP_EOL;
    }
}

// 信号注册：当接收到SIGINT信号时，调用signalHandler()函数
pcntl_signal(SIGINT, 'signalHandler');

while (true) {
    sleep(1);
    // do something
    pcntl_signal_dispatch(); // 接收到信号时，调用注册的signalHandler()
}
