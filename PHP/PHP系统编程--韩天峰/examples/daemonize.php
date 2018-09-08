<?php

function daemonize()
{
    $pid = pcntl_fork();

    if ($pid == -1) {
        die("fork(1) failed!\n");
    } elseif ($pid > 0) {
        // 让由用户启动的进程退出
        exit(0);
    }

    // TODO: 一下的代码注释掉也没问题 (这是一个关于为什么要 fork 两次的问题)
    // 建立一个有别于终端的新 session 以脱离终端
    posix_setsid();

    $pid = pcntl_fork();

    if ($pid == -1) {
        die("fork(2) failed!\n");
    } elseif ($pid > 0) {
        // 父进程退出, 剩下子进程成为最终的独立进程
        exit(0);
    }
}

function counter()
{
    $number = 0;

    while (1) {
        sleep(1);

        $number++;

        file_put_contents('nohup_test_log.log', "{$number}\n", FILE_APPEND);
    }

}

daemonize();

// 五秒后终端执行 `ps -ef` 看不到 `linxl      445     1  0 12:24 ?        00:00:00 php daemonize.php`
//sleep(5);

counter();
