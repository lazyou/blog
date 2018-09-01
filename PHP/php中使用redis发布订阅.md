## php 中使用 redis 发布订阅
* https://www.jianshu.com/p/cec941a228a6

* redis_sub.php
```php
<?php
// 订阅端代码 -- 开启多个订阅脚本，一旦有发布则都会收到
$redis = new Redis();
$redis->connect('localhost', 6379);
$redis->auth('redis112233');
$redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
$redis->subscribe(['order'], function ($redis, $chan, $msg) {
    var_dump($redis);
    var_dump($chan);
    var_dump($msg);
    echo "\n";
});
```

* redis_pub.php
```php
<?php
// 发布端代码
$redis = new Redis();
$redis->connect('localhost', 6379);
$redis->auth('redis112233');
$order = [
    'id' => 1,
    'name' => '小米6',
    'price' => 2499,
    'created_at' => '2017-07-14'
];
$redis->publish("order", json_encode($order));

/*
object(Redis)#1 (1) {
  ["socket"]=>
  resource(5) of type (Redis Socket Buffer)
}
string(5) "order"
string(70) "{"id":1,"name":"\u5c0f\u7c736","price":2499,"created_at":"2017-07-14"}"
*/
```


### phpredis subscribe超时问题及解决
* https://blog.csdn.net/qmhball/article/details/52575133

* 原因解析： `strace php redis_sub.php` ... 然后看不懂

* 解决
    * 方法1： `ini_set('default_socket_timeout', -1);` (不推荐，会影响到 `file_get_contents 等)

    * 方法2: `redis->setOption(Redis::OPT_READ_TIMEOUT, -1);` 【推荐】
