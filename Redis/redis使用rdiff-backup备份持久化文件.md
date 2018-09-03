## 使用 rdiff-backup 备份 redis 持久化文件
* https://www.howtoing.com/how-to-back-up-and-restore-your-redis-data-on-ubuntu-14-04

* `sudo apt install rdiff-backup` 

* `sudo rdiff-backup --preserve-numerical-ids /var/lib/redis /home/lin/Documents/redis_backup`
    * 与 `--preserve-数值的IDS`，源和目的地文件夹的所有权将是相同的

* `sudo crontab -e`
```conf
0 0 * * * rdiff-backup --preserve-numerical-ids --no-file-statistics /var/lib/redis /home/lin/Documents/redis_backup

# 按天备份 -- redis_backup 目录要先创建
0 0 * * * rrdiff-backup --preserve-numerical-ids --no-file-statistics /var/lib/redis /home/lin/Documents/redis_backup/`date +\%Y\%m\%d`
```

* 恢复备份：
    * `cp /home/lin/Documents/redis_backup/dump.rdb /var/lib/redis/dump.rdb`

    * `sudo rdiff-backup -r now /home/lin/Documents/redis_backup/dump.rdb /var/lib/redis/dump.rdb`
