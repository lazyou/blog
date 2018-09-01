## php中使用redis事务
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
