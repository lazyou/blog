## mysql执行日志开启 general_log
* `show variables like '%general%';`

* `sudo vim /etc/mysql/mysql.conf.d/mysqld.cnf`
```conf
# Both location gets rotated by the cronjob.
# Be aware that this log type is a performance killer.
# As of 5.1 you can enable the log at runtime!
general_log_file        = /var/log/mysql/mysql.log                                               
general_log             = 1
```
