## redis 持久化
* https://segmentfault.com/a/1190000008645186

* http://static.markbest.site/blog/56.html

* 默认持久化保存在 `/var/lib/redis/dump.rdb`

* Redis持久化的方式有两种：__RDB__ 和 __AOF__。

* Redis 为了内部数据的安全考虑，会把本身的数据以 `文件形式` 保存到硬盘中一份，在服务器重启之后会自动把硬 盘的数据恢复到内存(redis)的里边。 数据保存到硬盘的过程就称为 __持久化__ 效果


## RDB 和 AOF 
* RDB
    * Redis 的 RDB 文件不会坏掉，因为其写操作是在一个新进程中进行的。当生成一个新的 RDB 文件时，Redis 生成的子进程会先将数据写到一个临时文件中，然后通过原子性 rename 系统调用将临时文件重命名为 RDB 文件。这样在任何时候出现故障，Redis 的 RDB 文件都总是可用的。
    
    * 同时，Redis 的 RDB 文件也是 Redis _主从同步_ 内部实现中的一环。

    * RDB有它的 _不足_，就是一旦数据库出现问题，那么我们的RDB文件中保存的数据并不是全新的。

* AOF
    * AOF(Append-Only File) 比 RDB 方式有更好的持久化性。
    
    * 由于在使用 AOF 持久化方式时，Redis 会将每一个收到的写命令都通过 Write 函数追加到文件中，类似于 MySQL 的 binlog。当 Redis 重启是会通过重新执行文件中保存的写命令来在内存中重建整个数据库的内容。

    * AOF 的完全持久化方式同时也带来了另一个问题，持久化文件会变得越来越大。 比如我们调用 `INCR test` 命令 100 次，文件中就必须保存全部的 100 条命令，但其实 99 条都是多余的。


## 指令
```
redis-cli -a password bgsave        // 异步保存数据到磁盘(快照保存)
redis-cli -a password 1h 127.0.0.1 -p 6379 bgsave
redis-cli -a password lastsave      // 返回上次成功保存到磁盘的unix时间戳
redis-cli -a password shutdown      // 同步保存到服务器并关闭redis服务器
redis-cli -a password bgrewriteaof  // 当日志文件过长时优化AOF日志文件存储
```

## 1. snap shotting 快照持久化
* 该持久化默认开启，一次性把 redis 中全部的数据保存一份存储在硬盘中，如果数据非常多(10-20G)就不适合频繁进行该持久化操作。

* 快照文件 `/var/lib/redis/dump.rdb`

* `sudo vim /etc/redis/redis.conf`:
    ```conf
    # The filename where to dump the DB -- 快照文件名
    dbfilename dump.rdb

    # The Append Only File will also be created inside this director -- 快照目录
    dir /var/lib/redis

    save 900 1      # 900 秒内如果超过 1 个 key 被修改，则发起快照保存 
    save 300 10     # 300 秒超过10 个key被修改，发起快照 
    save 60 10000   # 60  秒超过10000 个key被修改，发起快照 
    ```

* 手动发起快照持久化
    ```
    ./redis-cli -h 192.168.10.138 -p 6379 bgsave //给定ip地址发起快照持久化

    ./redis-cli bgsave   //本机发起快照持久化
    ```


## 2. append only file （AOF持久化)
* 本质：把用户执行的每个“写”指令(`添加、修改、删除`)都备份到文件中，还原数据的时候就是执行具体写指令而已。

* 缺点， 文件会越来越大

* 开启AOF持久化(会清空redis内部的数据)： `sudo vim /etc/redis/redis.conf`
    ```conf
    appendonly no # 默认关闭

    appendfilename "appendonly.aof"  # 快照文件名

    # aof追加持久化的备份频率：
    # appendfsync always # 每次收到写命令就强制写入磁盘，慢慢的，但保证完全持久化，不推荐
    appendfsync everysec # 每秒强制写入一次，在性能和持久化方面做了折中，推荐
    # appendfsync no     # 完全依赖OS的写入，一般为30秒左右一次，性能最好但是持久化最没有保证，不被推荐

    # 压缩 AOF 持久化文件
        # AOF的完全持久化方式同时也带来了另一个问题，持久化文件会变得越来越大。 比如我们调用 `INCR test` 命令100次，文件中就必须保存全部的100条命令，但其实99条都是多余的。

        # 因为要恢复数据库的状态其实文件中保存一条 `SET test 100` 就够了

        # 为了压缩AOF的持久化文件，Redis提供了 `bgrewriteaof` 命令, 收到此命令后Redis将使用与快照类似的方式将内存中的数据以命令的方式保存到临时文件中，最后替换原来的文件，以此来实现控制AOF文件的增长。

    # 在日志重写时，不进行命令追加操作，而只是将其放在缓冲区里，避免与命令的追加造成DISK IO上的冲突。    
    no-appendfsync-on-rewrite yes

    # 当前AOF文件启动新的日志重写过程的最小值，避免刚刚启动Reids时由于文件尺寸较小导致频繁的重写。
    auto-aof-rewrite-min-size 64mb
    ```

* 重启redis后， 执行某些操作以后查看日志 `cat /var/lib/redis/appendonly.aof`
    ```aof
    *2
    $6
    SELECT
    $1
    0
    *1
    $5
    MULTI
    *3
    $3
    SET
    $6
    tran_a
    $14
    tran content a
    *3
    $3
    SET
    $6
    tran_b
    $14
    tran content b
    *3
    $3
    SET
    $6
    tran_c
    $14
    tran content c
    *1
    $4
    EXEC
    `````

* 持久化相关指令，参考前面


## 总结
* 到底选择什么呢？下面是来自官方的建议：
    * 通常，如果你要想提供很高的数据保障性，那么建议你同时使用两种持久化方式。
    * 如果你可以接受灾难带来的 _几分钟的数据丢失_，那么你可以仅使用 RDB。

* 很多用户仅使用了 AOF，但是我们建议，既然 RDB 可以时不时的给数据做个完整的快照，并且提供更快的重启，所以最好还是也使用 RDB。
