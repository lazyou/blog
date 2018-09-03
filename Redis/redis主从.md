## redis 主从
* http://static.markbest.site/blog/61.html

* https://segmentfault.com/a/1190000008645186


## 作用
* https://blog.csdn.net/a909301740/article/details/81531528

1. 保证了数据的 __高可用__。因为数据在多台服务器上存储了多份，即使一台机器宕掉了，其余的机器还可以顶上。

2. 实现了 __读写分离__。什么叫读写分离？写数据在 Master 上，读数据是在 Slave 上，这就叫读写分离。它缓解了以往 Master 既要处理读数据又要处理写数据的压力，Master 上负责写，Slave 上负责读，大大 _提升了数据库服务器的性能_。

3. __容灾恢复__。当主机宕掉了之后，就没有办法向数据库中写数据了，怎么办？其余的 Salve 根据配置的策略，选出一台晋升为 Master，其余的 Slave 成为新 Master 的从机，当原来宕掉的 Master 恢复后，自动成为 Slave，实现了容灾恢复。


## 原理
* https://blog.csdn.net/a909301740/article/details/81531528

* 一. master 复制数据给 slave 的原理如下：
    1. slave 启动成功之后连接到 master 后会发送一个 `sync` 命令。

    2. master 接收到这个同步命令之后启动后台的存盘进程，即将内存的数据持久化到 rdb 或 aof。

    3. 持久化完毕之后，master 将 _整个数据文件_ 传送给 slave。


* 二、slave 接收 master 复制过来的数据方式有两种：
    1. __全量复制__： slave 刚与 master 建立连接的时候，会将接收到的 master 发来的整个数据库文件存盘并加载到内存。

    2. __增量复制__： slave 已经与 master 建立好连接关系的时候，master 会将收集到的修改数据的命令传送给 slave，slave 执行这些命令，完成同步。而不是再一次重新加载整个数据文件到内存。

    * 当然，__如果 slave 与 master 断开连接，再次重连的时候还是要加载整个数据文件的__。


## 缺点
* 当 master 需要同步发送到 slave 上的数据量非常大的时候，会存在一定的 _时延_。 

* 当系统很繁忙或者 slave 机器数量非常多的时候也会使这个问题更加严重。


## 配置
* 从服务器 redis 配置：
    ```
    sudo vim /etc/redis/redis.conf

    # 主服务器地址，一定要保持主服务器允许连接
    slaveof 192.168.8.176 6379

    # 主服务器密码
    masterauth redis112233

    # 从服务器只读
    slave-read-only yes
    ```

* 重启 reids。然后在主服务器上写入数据到 redis，此时可以在从服务器上看到同步结果 

* redis 操作 log 查看： `cat /var/log/redis/redis-server.log`
    ```
    19031:S 03 Sep 09:45:15.590 * DB loaded from disk: 0.000 seconds
    19031:S 03 Sep 09:45:15.590 * The server is now ready to accept connections on port 6379
    19031:S 03 Sep 09:45:15.595 * Connecting to MASTER 192.168.8.176:6379
    19031:S 03 Sep 09:45:15.595 * MASTER <-> SLAVE sync started
    19031:S 03 Sep 09:45:15.595 * Non blocking connect for SYNC fired the event.
    19031:S 03 Sep 09:45:15.596 * Master replied to PING, replication can continue...
    19031:S 03 Sep 09:45:15.597 * Partial resynchronization not possible (no cached master)
    19031:S 03 Sep 09:45:15.598 * Full resync from master: 7737ca67a91554c2750706cf631f46e2c11d29ce:1
    19031:S 03 Sep 09:45:15.633 * MASTER <-> SLAVE sync: receiving 153 bytes from master
    19031:S 03 Sep 09:45:15.633 * MASTER <-> SLAVE sync: Flushing old data NOTE:清空从服务器的数据吗？
    19031:S 03 Sep 09:45:15.633 * MASTER <-> SLAVE sync: Loading DB in memory
    19031:S 03 Sep 09:45:15.633 * MASTER <-> SLAVE sync: Finished with success
    ````

* redis 状态查看： `info` 命令, 其中 `# Replication` 部分的信息就是关于主从的
    * `info replication` 命令可直接查看
    ```
    redis-cli
    auth password
    info
    ```
