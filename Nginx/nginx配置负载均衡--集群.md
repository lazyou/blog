## nginx配置负载均衡 -- 集群
* 参考： https://www.zybuluo.com/phper/note/90310

* __负载均衡__ 的好处是可以 __集群__ 多台机器一起工作，并且对外的IP 和 域名是一样的，外界看起来就好像一台机器一样。

* 开启三个虚拟机配置如下：
    * `/var/www/html/index.php`:
    ```php
    <?php

    echo "virtual 1"; # 分别 1 ，2 ， 3
    ```

    * `/etc/nginx/sites-available/default`:
    ```conf
    server {
        listen 80 default_server;
        listen [::]:80 default_server;
        root /var/www/html;

        index index.php index.html index.htm index.nginx-debian.html;

        server_name _;

        location / {
            try_files $uri $uri/ =404;
        }

        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        }
    }
    ```


### 负载均衡分发服务器配置
#### 基于 weight 权重的负载

* `/etc/nginx/conf.d/test.conf`
```conf
# 基于 weight 权重的负载
upstream webservers{
    server 192.168.8.120 weight=10 max_fails=2 fail_timeout=30s;
    server 192.168.8.85 weight=10 max_fails=2 fail_timeout=30s;
    server 192.168.8.101 backup;
    server 192.168.8.100 down;
}

server {
    listen 80;
    root /var/www/html;
    index index.php index.html;
    server_name www.test.test;

    access_log /var/log/nginx/test.access.log main;
    error_log /var/log/nginx/test.error.log error;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    }

    # 负载使用
    location / {
        proxy_pass http://webservers;
        proxy_set_header  X-Real-IP  $remote_addr;
    }
}
``` 

* `nginx -s reload` 通过浏览器访问刷新 `www.test.test` 依次会看到 "virtual 1" "virtual 2" "virtual 3" 的内容， 说明负载均衡已经生效
    * 且通过查看 access log 看到的访问日志 ip 都是来自 www.test.test 所在服务器的 ip

* 参数说明：
    * `max_fails` : 允许请求失败的次数，默认为1。当超过最大次数时，返回 `proxy_next_upstream` 模块定义的错误。

    * `fail_timeout` : 在经历了 `max_fails` 次失败后，暂停服务的时间。`max_fails` 可以和 `fail_timeout` 一起使用，进行健康状态检查。

    * `server 192.168.33.11 weight=1 max_fails=2 fail_timeout=30s;` 所以这2个一起搭配使用，表示：当失败2次的时候，就停止使30秒

    * `down` 表示这台机器暂时不参与负载均衡。相当于注释掉了。

    * `backup` 表示这台机器是 __备用机器__，是其他的机器不能用的时候，这台机器才会被使用


* TODO: ab 测试负载均衡一台和多台虽然有效率上的差别，但是还是没有在虚拟机理ab本地来得效率高。
    * 所以还是需要看实际的应用场景，到底是什么情况加使用负载均衡能带来性能上的提升？


* ab 测试数据： `ab -n 10000 -c 100`
```
负载均衡一台的情况 qps 为 2800 左右
负载均衡两台的情况 qps 为 4000 左右
负载均衡三台的情况 qps 为 4000 左右 (没啥提升)
在虚拟机里直接 ab 时 qps 为 5600 左右 (负载均衡还不如单机)
```

* TIPS:
    * session 共享问题可以使用 redis 作为统一的存放地址来解决


#### 基于 ip_hash 权重的负载
* 这种分配方式，每个请求按访问IP的 hash 结果分配，这样来自同一个IP的访客固定访问一个后端服务器，有效解决了动态网页存在的 _session共享问题_。

* 配置：
```conf
upstream webservers{
    ip_hash;
    server 192.168.8.120 weight=10 max_fails=2 fail_timeout=30s;
    server 192.168.8.85 weight=10 max_fails=2 fail_timeout=30s;
}
```

* __注意__: 
    * ip_hash 模式下，最好不要设置 weight 参数，因为你设置了，就相当于手动设置了，将会导致很多的流量分配不均匀。

    * ip_hash 模式下, __backup 参数不可用__，加了会报错，为啥呢？因为，本身我们的访问就是固定的了，其实，备用已经不管什么作用了。
