## MySQL 5.7 开启 binary log
* 二进制日志语句Binary Log ，我们俗称 binlog，记录数据库更改的数据，常用于主从复制环境和恢复备份。

* `sudo vim /etc/mysql/mysql.conf.d/mysqld.cnf`
```conf
server-id       = 1
log_bin         = /var/log/mysql/mysql-bin.log
expire_logs_days= 10
max_binlog_size = 100M                  
# binlog_do_db       = include_database_name
# binlog_ignore_db   = include_database_name
```

* 重启 mysql

* 相关查看
```sql
SHOW VARIABLES LIKE 'log_bin%'

show binary logs;

show binlog events;
```


### MySQL 5.7 开启 binlog
* https://my.oschina.net/colben/blog/1925264

* 修改 my.cnf 文件
    ```ini
    [mysqld]
    log-bin=[/存放目录/]mysql-bin #注意 mysql 可读写“存放目录”，默认数据存放目录
    expire_logs_days=7 #保留7天内修改过的 binglog 文件
    max_binlog_size=512M #单个 binlog 文件大小上限，默认1G
    #指定或忽略要复制的数据库，存在跨库问题
    binlog_do_db=db1
    binlog_db_db=db2
    #binlog_ignore_db=db1
    #binlog_ignore_db=db2
    ```


* 常用操作
    * 查看所有 binlog 文件列表: `show master logs;`

    * 查看 master 状态，包含最新 binlog 文件名和 position: `show master status;`

    * 清除过期 binlog 文件，并使用新编号的 binlog 文件开始记录日志: `flush logs;`
    
    * 删除 binlog 文件
        * 删除旧的 binlog 文件:
        ```
        purge master logs to 'mysql-bin.000573';
        purge master logs before '2018-04-18 06:00:00';
        purge master logs before DATE_SUB(NOW(), INTERVAL 2 DAY);
        ```
    
    * 清空所有 binlog 文件: `reset master`


* 使用 `mysqlbinlog` 命令查看 binlog 文件的内容
    * 查看
        ```
        # 查看日志
        mysqlbinlog [选项] binlog文件名
        # 恢复数据
        mysqlbinlog [选项] binlog文件名 | mysql -u用户名 -p密码 -D数据库 [-v]
        ```

    * 常用选项
        * --start-position=128 起始 pos
        * --stop-position=256 结束 pos
        * --start-datetime="2018-08-08 00:00:00" 起始时间
        * --stop-datetime="2018-08-09 12:00:00" 结束时间
        * --database=db_name 只恢复 db_name 数据库


* 使用 `sql` 查看 binlog 文件的内容
    * 查询语句: `SHOW BINLOG EVENTS [IN 'log_name'] [FROM pos] [LIMIT [offset,] row_count];`

* 选项
    * log_name binlog文件名，默认第一个 binlog 文件
    * pos 查询起始 pos，默认 log_name 中的第一个 pos
    * offset 偏移 pos 个数
    * row_count 查询数量

* 调整 binlog_cache_size
    * 查看当前 binlog_cache_size 大小(byte)，默认 32k
        * `show variables like 'binlog_cache_size';`

    * 查看当前 binlog_cache_use 和 binlog_cache_disk_use 次数
        ```sql
        show status like 'binlog_cache%';
        -- binlog_cache_disk_use 使用临时文件写 binlog 文件的次数
        -- binlog_cache_use 使用缓存写 binlog 文件的次数
        ```
