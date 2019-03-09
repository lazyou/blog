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
