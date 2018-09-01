## redis 事务
* https://www.runoob.com/redis/redis-transactions.html

* redis事务是乐观锁, 所以 redis 的事务并不具备原子性 -- 也就是不支持回滚

* 一个事务从开始到执行会经历以下三个阶段：
    * 开始事务 (MULTI);
    * 命令入队;
    * 执行事务 (EXEC);

* 单个 Redis 命令的执行是原子性的，但 __Redis 没有在事务上增加任何维持原子性的机制，所以 Redis 事务的执行并不是原子性的__。

* 事务可以理解为一个打包的批量执行脚本，但批量指令并非原子化的操作，中间某条指令的失败不会导致前面已做指令的回滚，也不会造成后续的指令不做。

* 事务成功
```shell
127.0.0.1:6379> multi
OK
127.0.0.1:6379> set a aaa
QUEUED
127.0.0.1:6379> set b bbb
QUEUED
127.0.0.1:6379> set c ccc
QUEUED
127.0.0.1:6379> exec
1) OK
2) OK
3) OK
127.0.0.1:6379> 

NOTE: 如果在 `set b bbb` 处失败，`set a` 已成功不会回滚，`set c` 还会继续执行。
```


* 事务失败 1
```shell
$ redis-cli               
127.0.0.1:6379> multi
OK
127.0.0.1:6379> set a aaa
QUEUED
127.0.0.1:6379> set b bbb
QUEUED
127.0.0.1:6379> sec c ccc
(error) ERR unknown command 'sec'
127.0.0.1:6379> exec
(error) EXECABORT Transaction discarded because of previous errors.
```

* 事务失败 2 -- redis 的事务并没有一致性，所以在这个事务提交当中，就算 `HGETALL a` 报错了 set a b c 还是设置成功
```shell
127.0.0.1:6379> set a aaa
QUEUED
127.0.0.1:6379> set b bbb
QUEUED
127.0.0.1:6379> HGETALL a
QUEUED
127.0.0.1:6379> set c ccc
QUEUED
127.0.0.1:6379> exec
1) OK
2) OK
3) (error) WRONGTYPE Operation against a key holding the wrong kind of value
4) OK
```


### Redis 事务命令
1. `DISCARD`
取消事务，放弃执行事务块内的所有命令。

2. `EXEC`
执行所有事务块内的命令。

3. `MULTI`
标记一个事务块的开始。

4. `UNWATCH`
取消 WATCH 命令对所有 key 的监视。

5. `WATCH key [key ...]`
监视一个(或多个) key ，如果在事务执行之前这个(或这些) key 被其他命令所改动，那么事务将被打断。
