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
