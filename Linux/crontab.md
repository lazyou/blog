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


### 其它
* `crontab -l`
* `crontab -e`


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
 