<?php
// 信号处理需要注册 ticks 才能生效，这里务必注意
// PHP5.4 以上版本就不再依赖ticks了
declare(ticks=1);

function sig_handler($signo)
{
    switch ($signo) {
        case SIGUSR1:
            echo "SIGUSR1\n";
            break;
        case SIGUSR2:
            echo "SIGUSR2\n";
            break;
        default:
            echo "unknow";
            break;
    }

}

// 安装信号处理器
pcntl_signal(SIGUSR1, "sig_handler");
pcntl_signal(SIGUSR2, "sig_handler");

// posix_kill — Send a signal to a process

// 向当前进程发送 SIGUSR1 SIGUSR2 信号
posix_kill(posix_getpid(), SIGUSR1);
posix_kill(posix_getpid(), SIGUSR2);
