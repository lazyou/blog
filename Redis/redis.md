## 安装
* `apt install redis-server`

## 日志
* `cat /var/log/redis/redis-server.log`

## GUI 客户端
* `sudo snap install redis-desktop-manager`

### 开启远程 redis 服务:
* `sudo vim /etc/redis/redis.conf`

* 把 `bind 127.0.0.1` 改成 `bind 0.0.0.0`

* 重启 redis 服务


### 设置 redis 认证密码:
* `sudo vim /etc/redis/redis.conf`

* 去掉注释, `#requirepass foobared` 并把 `foobared` 改成你的密码

* 重启 redis 服务

* 或者 `config set requirepass my_redis`


## 其他:
* PHP 扩展: http://pecl.php.net/package/redis

* 如何利用 Redis 快速实现签到统计功能: https://learnku.com/articles/25181

* Docker 安装单机版 redis5 和集群版 redis5: https://blog.csdn.net/Amor_Leo/article/details/85147086
