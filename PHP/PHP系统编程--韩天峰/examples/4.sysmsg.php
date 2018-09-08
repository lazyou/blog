<?php
$msg_key    = 03000111; // 系统消息队列的key
$worker_num = 2;         // 启动的Worker进程数量
$worker_pid = array();

$queue = msg_get_queue($msg_key, 0666);

if ($queue === false) {
    die("create queue fail\n");
}

for ($i = 0; $i < $worker_num; $i++) {
    $pid = pcntl_fork();

    // 主进程
    if ($pid > 0) {
        $worker_pid[] = $pid;
        echo "create worker $i.pid = $pid\n";
        continue;
    } elseif ($pid == 0) { // 子进程
        proc_worker($i);
        exit;
    } else {
        echo "fork fail\n";
    }
}

proc_main();

/**
 * Proxy主进程
 */
function proc_main()
{
    global $queue;

    $bind = "udp://0.0.0.0:9999";

    // 建立一个 UDP 服务器接收请求
    $socket = stream_socket_server($bind, $errno, $errstr, STREAM_SERVER_BIND);

    if (!$socket) {
        die("$errstr ($errno)");
    }

    stream_set_blocking($socket, 1); // 设置资源流为阻塞模式

    echo "stream_socket_server bind=$bind\n";

    while (1) {
        $errCode = 0;
        $peer    = '';
        $pkt     = stream_socket_recvfrom($socket, 8192, 0, $peer);

        if ($pkt == false) {
            echo "udp error\n";
        }

        $ret = msg_send($queue, 1, $pkt, false, true, $errCode); //如果队列满了，这里会阻塞
        if ($ret) {
            stream_socket_sendto($socket, "OK\n", 0, $peer);
        } else {
            stream_socket_sendto($socket, "ER\n", 0, $peer);
        }
    }
}

/**
 * 多Worker进程
 *
 * @param $id
 */
function proc_worker($id)
{
    global $queue;

    $msg_type = 0;
    $msg_pkt  = '';
    $errCode  = 0;

    while (1) {
        $ret = msg_receive($queue, 0, $msg_type, 8192, $msg_pkt, false, $errCode);
        if ($ret) {
            //TODO 这里处理接收到的数据
            // Code ...
            echo "[Worker $id] " . $msg_pkt;
        } else {
            echo "ERROR: queue errno={$errCode}\n";
        }
    }
}