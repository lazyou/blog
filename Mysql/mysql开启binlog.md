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