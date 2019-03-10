## MySQL错误日志、查询日志、慢查询日志、事务日志、二进制日志详细解析
* http://www.3mu.me/mysql%e9%94%99%e8%af%af%e6%97%a5%e5%bf%97%e3%80%81%e6%9f%a5%e8%af%a2%e6%97%a5%e5%bf%97%e3%80%81%e6%85%a2%e6%9f%a5%e8%af%a2%e6%97%a5%e5%bf%97%e3%80%81%e4%ba%8b%e5%8a%a1%e6%97%a5%e5%bf%97%e3%80%81/

## 概要
* `SHOW  GLOBAL VARIABLES LIKE '%log%';` 查看各种 log 的配置情况

* ubuntu 下默认配置文件: `/etc/mysql/mysql.conf.d/mysqld.cnf`


## 错误日志
* `SHOW  GLOBAL VARIABLES LIKE '%log_error%';`


## 查询日志
* `SHOW  GLOBAL VARIABLES LIKE '%general_log%';`


## 慢查询日志
* `SHOW  GLOBAL VARIABLES LIKE '%slow_query_log%';`

* 慢日志的时常设置 `SHOW  GLOBAL VARIABLES LIKE '%long_query_time%';`


## 事务日志
* `SHOW  GLOBAL VARIABLES LIKE '%innodb_log%';`


## 二进制日志
* `SHOW  GLOBAL VARIABLES LIKE '%log_bin%';`
