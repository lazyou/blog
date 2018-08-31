## 实现消息队列的方式
* 生产消费者模式

* 发布订阅模式

* TODO: 然而, 貌似网上的说法都是不推荐使用 redis 实现消息队列, 很费解


## php实现消息队列--配合redis使用生产消费模式
* 参考: http://www.51ask.org/article/387

* 当然, 这是一个很简单的案例, 它与实际的消息队列差很远的

* 生产者 redis_produce.php 
```php
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
```

* 消费者 redis_consumer.php
```php
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
        sleep(1); // 很重要, 休息一秒, 不然会 cpu 会被占满
    }
}
```

* 说明：以上按照先进先出的原则，分别出列了所有的数据。如果列表内数据为空，则 Redis::rPop() 返回 false。

* 配合 crontab 定时器 或者 supervisor 进程守护工具可以作为简单的消息队列处理
