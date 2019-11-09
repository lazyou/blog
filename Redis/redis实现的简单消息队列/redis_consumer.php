<?php
/**
 * 基于Redis-List实现的简单消息队列
*/

//实例化
$redis = new Redis();

//连接服务端
$redis->connect('127.0.0.1', 6379);

//出列
while (true) {
    $result = $redis->rPop('TestQueue');

    if ($result) {
        var_dump($result);
    } else {
        sleep(1); // 休息一秒, 不然会 cpu 会被占满
    }
}

