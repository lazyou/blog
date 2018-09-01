## 简单事务使用实例
* redis 事务没有一致性，仅仅是针对 redis 命令错误或失败不支持回滚，简单点讲， 在事务开启过程中 redis 命令敲错了是不会自动回滚的。

* __php 处理 redis 事务是支持回滚的 (discard), 只要不是 redis 命令调用错误或失败__，参考案例 tran_exception.php。

* transaction.php
```php
<?php

$redis = new redis();
$redis->connect('localhost', 6379);
$redis->auth('redis112233');

// 重要，必须 watch. 事务中操作什么建议就 watch 什么
$redis->watch('a', 'b', 'c');

// 开启事务
$redis->multi();

$redis->set('tran_a', 'tran content a');
$redis->set('tran_b', 'tran content b');
$redis->set('tran_c', 'tran content c');

// 提交事务
$result = $redis->exec();

var_dump($result);
```


* tran_exception.php -- 结合 Exception 提交 或 回滚事务
```php
<?php

$redis = new redis();
$redis->connect('localhost', 6379);
$redis->auth('redis112233');

// 重要，必须 watch. 事务中操作什么建议就 watch 什么
$redis->watch('tran_num', 'tran_name');

// 开启事务
$redis->multi();

try {
    $redis->setex('tran_name', 3600, 'tran content');
    $redis->get('tran_name');
    // throw new Exception('模拟异常'); // 注释掉事务能正常提交
    $redis->incrBy('tran_num', 5);

    // 提交事务
    $result = $redis->exec();
    var_dump($result);
} catch (Exception $e) {
    $redis->discard(); // redis 事务回滚
    echo $e->getMessage() . "\n";
}
```


* transaction.php
```php
<?php
$redis = new redis();
$redis->connect('localhost', 6379);
$redis->auth('password');

// 重要，必须 watch
$redis->watch('tran_num');

// 用于监视一个(或多个) key ，如果在事务执行之前这个(或这些) key 被其他命令所改动，那么事务将被打断
// $redis->incr('tran_num'); // 注释掉 $redis->exec(); 会执行失败

// 开启事务
$redis->multi();
$redis->incrBy('tran_num', 5);
$redis->setex('tran_name', 3600, 'tran content');
$redis->get('tran_name');

$result = $redis->exec();
var_dump($result);
/**
array(3) {
  [0]=>
  int(5)
  [1]=>
  bool(true)
  [2]=>
  string(12) "tran content"
}
*/
```


## php中使用redis事务 -- 秒杀实现
* https://segmentfault.com/a/1190000007429197

* 使用 ab 测试下面脚本

* redis_transaction.php
```php
$redis = new redis();
$redis->connect('localhost', 6379);
$redis->auth('password');

$productTotal = 100;   // 抢购商品总数量
$productSaleCount = $redis->get("productSaleCount"); // 抢购成功数量

if ($productSaleCount < $productTotal) {
    // 如果在事务执行之前这个(或这些) key 被其他命令所改动，那么事务将被打断
    $redis->watch("productSaleCount");

    // 开启事务
    $redis->multi();

    // 设置延迟，方便测试效果
    // sleep(1);

    // 插入抢购数据
    $nextId = $productSaleCount + 1;

    // 购买的用户列表，以及购买时间
    $redis->hSet("productUserList", "user_sort_{$nextId}", time());

    // 销量统计
    $redis->set("productSaleCount", $productSaleCount + 1);

    // 执行事务
    $tranResult = $redis->exec();

    if ($tranResult) {
        $productUserList = $redis->hGetAll("productUserList");
        echo "抢购成功！<br/>";
        echo "剩余数量：".($productTotal - $productSaleCount - 1)."<br/>";
        echo "用户列表：<pre>";
        var_dump($productUserList);
    } else {
        // 事务失败则意味着抢购失败
        echo "手气不好，再抢购！";
    }
}
```

* 
    * `WATCH` 是一个 __乐观锁__，有利于减少并发中的冲突, 提高吞吐量。

* 乐观锁与悲观锁
    * __乐观锁(Optimistic Lock)又叫共享锁(S锁)__，每次去拿数据的时候都认为别人不会修改，所以不会上锁，但是在更新的时候会判断一下在此期间别人有没有去更新这个数据，可以使用版本号等机制。乐观锁适用于多读的应用类型，这样可以提高吞吐量。

    * __悲观锁(Pessimistic Lock)又叫排他锁(X锁)__，每次去拿数据的时候都认为别人会修改，所以每次在拿数据的时候都会上锁，这样别人想拿这个数据就会 block 直到它拿到锁。传统的关系型数据库里边就用到了很多这种锁机制，比如 _行锁，表锁_ 等，都是在做操作之前先上锁
