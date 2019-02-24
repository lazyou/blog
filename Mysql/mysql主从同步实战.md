## Mysql主从同步实战
* https://segmentfault.com/a/1190000008663587

### 1、Introduction
* 之前写过一篇文章：Mysql主从同步的原理(https://segmentfault.com/a/1190000008663001)。
* 相信看过这篇文章的童鞋，都摩拳擦掌，跃跃一试了吧？
* 今天我们就来一次mysql主从同步实战！

### 2、环境说明
* os:ubuntu16.04
* mysql:5.7.17
* 下面的实战演练，都是基于上面的环境。当然，其他环境也大同小异。

### 3、进入实战

#### 工具
* 2台机器：
    * master IP:192.168.33.22
    * slave  IP:192.168.33.33

#### master机器上的操作
* 1、更改配置文件
    * 我们找到文件 `/etc/mysql/mysql.conf.d/mysqld.cnf` 配置如下：
    ```
    bind-address = 192.168.33.22 #your master ip
    server-id = 1 #在master-slave架构中，每台机器节点都需要有唯一的server-id
    log_bin = /var/log/mysql/mysql-bin.log #开启binlog
    ```

* 2、重启mysql，以使配置文件生效:
    * `sudo systemctl restart mysql`

* 3、创建主从同步的mysql user:
    ```
    $ mysql -u root -p
    Password:

    ## 创建 slave1 用户，并指定该用户只能在主机(slave) 192.168.33.33上登录
    mysql> CREATE USER 'slave1'@'192.168.33.33' IDENTIFIED BY 'slavepass';
    Query OK, 0 rows affected (0.00 sec)

    ## 为 slave1 赋予 REPLICATION SLAVE 权限
    mysql> GRANT REPLICATION SLAVE ON *.* TO 'slave1'@'192.168.33.33';
    Query OK, 0 rows affected (0.00 sec)
    ```

* 4、为MYSQL加读锁
    * 为了主库与从库的数据保持一致，我们先为mysql加入读锁，使其变为只读。
    ```
    mysql> FLUSH TABLES WITH READ LOCK;
    Query OK, 0 rows affected (0.00 sec)
    ```

* 5、记录下来MASTER REPLICATION LOG 的位置
    * 该信息稍后会用到。
    ```
    mysql> SHOW MASTER STATUS;
    +------------------+----------+--------------+------------------+-------------------+
    | File             | Position | Binlog_Do_DB | Binlog_Ignore_DB | Executed_Gtid_Set |
    +------------------+----------+--------------+------------------+-------------------+
    | mysql-bin.000001 |      613 |              |                  |                   |
    +------------------+----------+--------------+------------------+-------------------+
    1 row in set (0.00 sec)
    ```

* 6、将master DB中现有的数据信息导出
    * `$ mysqldump -u root -p --all-databases --master-data > dbdump.sql`

* 7、接触master DB的读锁
    * `mysql> UNLOCK TABLES;`

* 8、将步骤 6 中的 dbdump.sql 文件 copy 到 slave
    * `scp dbdump.sql ubuntu@192.168.33.33:/home/ubuntu`


#### slave机器上的操作
* 1、更改配置文件
    * 我们找到文件 `/etc/mysql/mysql.conf.d/mysqld.cnf` 更改配置如下：
    ```
    bind-address = 192.168.33.33 #your slave ip
    server-id = 2 #master-slave结构中，唯一的server-id
    log_bin = /var/log/mysql/mysql-bin.log #开启binlog
    ``

* 2、重启mysql，以使配置文件生效
    * `sudo systemctl restart mysql`

* 3、导入从master DB。 导出的 dbdump.sql 文件，以使 master-slave 数据一致
    * `$ mysql -u root -p < /home/ubuntu/dbdump.sql`

* 4、使 slave 与 master 建立连接，从而同步
    ```
    $ mysql -u root -p
    Password:
    mysql> STOP SLAVE;
    Query OK, 0 rows affected, 1 warning (0.00 sec)

    mysql> CHANGE MASTER TO
        -> MASTER_HOST='192.168.33.22',
        -> MASTER_USER='slave1',
        -> MASTER_PASSWORD='slavepass',
        -> MASTER_LOG_FILE='mysql-bin.000001',
        -> MASTER_LOG_POS=613;
    Query OK, 0 rows affected, 2 warnings (0.01 sec)

    mysql> START SLAVE;
    Query OK, 0 rows affected (0.00 sec)
    ```

* `MASTER_LOG_FILE='mysql-bin.000001'` 与 `MASTER_LOG_POS=613` 的值，是从上面的 `SHOW MASTER STATUS` 得到的.

* 经过如此设置之后，就可以进行master-slave同步了~

### 4、参考文章
* HOW TO SETUP MYSQL 5.7 REPLICATION WITH MONITORING ON UBUNTU 16.04 (https://www.opsdash.com/blog/mysql-replication-howto.html)


### 5. 亲测踩到的坑
* Fatal error: The slave I/O thread stops because master and slave have equal MySQL server UUIDs; these UUIDs must be different for replication to work
    * 解决参考 https://www.jianshu.com/p/db4d7cea3d00
    * 主要是在 master 虚拟机上 clone 了 slave 服务器, 导致 mysql 的 UUID 重复了, 只要删除 slave 的 /var/lib/mysql/auto.cnf 文件, 重启它的 mysql 服务即可(会重新生成一个新的 auto.cnf).


### 6. 只复制指定的数据库或表
* https://blog.csdn.net/qq_35772366/article/details/79949115
