<?php
/**
 * 基于Redis-List实现的简单消息队列
*/

//实例化
$redis = new Redis();

//连接服务端
$redis->connect('127.0.0.1', 6379);

//入列
$redis->lPush('TestQueue', '51ask');
$redis->lPush('TestQueue', 'www.51ask.org');

