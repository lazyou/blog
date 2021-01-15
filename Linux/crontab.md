## 服务状态查看
```sh
On Linux:
service crond status
service crond stop
service crond start


On Ubuntu:
service cron status
service cron stop
service cron start
```


### 指定用户名运行（例如 www-data）
```sh
# 方法1：crontab 命令中指定用户名
crontab -e
* * * * *  www-data flock /tmp/flock1.lock -c 'timeout 200 /usr/local/bin/php /var/www/html/laravel/artisan command >> /home/log/laravel.log 2>&1'


# 方法2： 指定用户名打开 crontab
crontab -u www-data -e
crontab -u www-data -e


# 方法3： 先切换用户，在执行crontab命令
sudo su - www-data -s /bin/bash
crontab xxx
```


### 其它
* `crontab -l`
* `crontab -e`


### 命令生成工具
* https://tool.lu/crontab/


### 示例：为 crontab 增加日志
`0 6 * * * xxx.php >> $HOME/CrontabLogs/mylog.log 2>&1`


### crontab每10秒执行一次的实现方法
```sh
 * * * * * sleep 10; /usr/bin/curl http://localhost/index.php
 * * * * * sleep 20; /usr/bin/curl http://localhost/index.php
 * * * * * sleep 30; /usr/bin/curl http://localhost/index.php
 * * * * * sleep 40; /usr/bin/curl http://localhost/index.php
 * * * * * sleep 50; /usr/bin/curl http://localhost/index.php
 ```
 