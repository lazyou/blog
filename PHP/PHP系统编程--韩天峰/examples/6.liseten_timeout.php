<?php
declare(ticks = 1);

function a() {
    sleep(3);
    echo "a finishi\n";
}

function b() {
    echo "Stop\n";
}

function c() {
    // 0.1 毫秒
    usleep(100000);
}

function sig() {
    throw new Exception;
}

// MARK: 原理是使用 pcntl_alarm 在指定秒数后发送信号的原理, 与 php 的 max_execution_time 配置无关

try {
    // 创建一个计时器，在指定的秒数后向进程发送一个 SIGALRM 信号。每次对 pcntl_alarm() 的调用都会取消之前设置的 alarm 信号
    pcntl_alarm(1); // 1 秒后触发信号
    pcntl_signal(SIGALRM, "sig");
    a();
    pcntl_alarm(0);
} catch (Exception $e) {
    echo "timeout\n";
}

b();
a();
b();
