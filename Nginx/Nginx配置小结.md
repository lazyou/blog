## Nginx 配置小结
* https://laravel-china.org/articles/4166/nginx-configuration-summary


### 全局变量
* $args ： 这个变量等于请求行中的参数，同 `$query_string`

* $content_length ： 请求头中的 `Content-length` 字段

* $content_type ： 请求头中的 `Content-Type` 字段

* $document_root ： 当前请求在 `root` 指令中指定的值

* $host ： 请求主机头字段，否则为服务器名称

* $http_user_agent ： 客户端 `agent` 信息

* $http_cookie ： 客户端 `cookie` 信息

* $limit_rate ： 这个变量可以限制连接速率

* $request_method ： 客户端请求的动作，通常为 `GET` 或 `POST`

* $remote_addr ： 客户端的 `IP` 地址

* $remote_port ： 客户端的端口

* $remote_user ： 已经经过Auth Basic Module验证的用户名

* $request_filename ： 当前请求的文件路径，由 `root` 或 `alias` 指令与 `URI` 请求生成

* $scheme ： HTTP方法（如 `http`，`https`）

* $server_protocol ： 请求使用的协议，通常是 `HTTP/1.0` 或 `HTTP/1.1`

* $server_addr ： 服务器地址，在完成一次系统调用后可以确定这个值

* $server_name ： 服务器名称

* $server_port ： 请求到达服务器的端口号

* $request_uri ： 包含请求参数的原始 `URI`，不包含主机名，如 `/foo/bar.php?arg=baz`

* $uri ： 不带请求参数的当前 `URI`， `$uri` 不包含主机名，如 `/foo/bar.html`

* $document_uri ： 与 `$uri` 相同

* 假设请求为 `http://www.qq.com:8080/a/b/c.php`，则
    * $host： `www.qq.com`
    * $server_port： `8080`
    * $request_uri： `http://www.qq.com:8080/a/b/c.php`
    * $document_uri： `/a/b/c.php`
    * $document_root： `/var/www/html`
    * $request_filename： `/var/www/html/a/b/c.php`


### 主机名（server_name）匹配
* 从上到下的优先级为从高到低:
    1. 明确的 `server_name` 名称，如 `www.qq.com`
    2. 前缀通配符，如 `*.qq.com` 或 `. qq.com`
    3. 后缀通配符，如 `www.qq.*`
    4. 正则表达式，如 `~[a-z]+\.qq\.com`


### Location查找规则
* 从上到下的优先级为从高到低:
    1. 等号类型，精确匹配，如 `location = / {}`
    2. `^~` 类型，前缀匹配，不支持正则，如 `location ^~ /user {}`
    3. `~` 和 `~*` 类型，正则匹配， `~` 区分大小写， `~*` 不区分大小写，如 `location ~ ^/user {}`
    4. 常规字符串匹配类型，如 `location / {}` 或 `location /user {}`


### Try_files规则
* `try_files $uri $uri/ /index.php`

* 假设请求为 `http://www.qq.com/test`，则 `$uri` 为 `test`
    1. 查找 `/$root/test` 文件
    2. 查找 `/$root/test/` 目录
    3. 发起 `/index.php` 的内部 “子请求”


### Rewrite规则
* `rewrite ^/images/(.*).(png|jpg|gif)$ /images?name=$1.$4 last;`

* 上面的 `rewrite` 规则会将文件名改写到参数中

* last : 相当于 Apache 的 `[L]` 标记，表示完成 `rewrite`

* break : 停止执行当前虚拟主机的后续 `rewrite` 指令集

* redirect : 返回302临时重定向，地址栏会显示跳转后的地址

* permanent : 返回301永久重定向，地址栏会显示跳转后的地址


### 负载均衡
* 例子如下:
```s
upstream backend1 {
    server backend1.qq.com weight=5;
    server 127.0.0.1:8080 max_fails=3 fail_timeout=30s;
    server unix:/tmp/backend3 backup;
}

upstream backend2 {
    ip_hash;
    server backend1.qq.com;
    server backend2.qq.com;
    server backend3.qq.com down;
    server backend4.qq.com;
}

server {
    location / {
        proxy_pass http://backend1;
    }

    location /api {
        proxy_pass http://backend2;
    }
}
```


### 查看一个实例
* 下面是一个 laravel 框架 Nginx 配置的例子，听过这堂课终于了解了下面的原理:
```s
server {
    listen 80 default_server;
    listen [::]:80 default_server ipv6only=on;

    # 设定网站根目录
    root /var/www/laravel/public;

    # 网站默认首页
    index index.php index.html index.htm;

    # 服务器名称，server_domain_or_IP 请替换为自己设置的名称或者 IP 地址
    server_name server_domain_or_IP;

    # 修改为 Laravel 转发规则，否则 PHP 无法获取 $_GET 信息，提示 404 错误
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP 支持
    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

* 主要分析
    * 我们主要关注两个 `location`，假设地址是 `http://www.qq.com/user/info`，会匹配到如下 `location`:
    ```s
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
    ```

    * 由于 `$uri` 和 `$uri/` 是不存在的，所以会走 `/index.php?$query_string`，这时候会发起一个内部“子请求”，“子请求”会重新匹配 `location`，然后匹配到如下 `location`:
    ```s
        location ~ \.php$ {
            try_files $uri /index.php =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass unix:/var/run/php5-fpm.sock;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include fastcgi_params;
        }
    ```
    * 这样请求就会发送到 `fastcgi` 去做处理
