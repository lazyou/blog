## php-fpm 配置文件
* `/etc/php/7.0/fpm/php-fpm.conf` 主配置加载 pool.d 目录下的配置

* `/etc/php/7.0/fpm/pool.d/www.conf`

### 慢查询配置
* `/etc/php/7.0/fpm/pool.d/www.conf`
    ```
    slowlog = /var/log/$pool.log.slow
    request_slowlog_timeout = 2
    ```

* 在代码中使用 `sleep(3)` 即可看到日志：
    ```
    $ sudo tail -n 200 -f /var/log/www.log.slow     

    [02-Sep-2018 15:04:51]  [pool www] pid 9304
    script_filename = /var/www/html/index.php
    [0x00007fda73c120a0] sleep() /var/www/html/index.php:3
    ```
