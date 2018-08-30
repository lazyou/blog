## nginx配置反向代理
* nginx 使用反向代理，主要是使用 location 模块下的 `proxy_pass` 选项。

* `/etc/nginx/conf.d/test.conf` 配置
```conf
server {
    listen 80;
    root /var/www/;
    index index.php index.html;
    server_name www.test.test;

    # 测试 php-cgi 和 php-fpm 的效率区别
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        # fastcgi_pass 127.0.0.1:9000;
    }

    # 反向代理: 当访问 http://www.test.test/baidu 反向代理到 http://www.baidu.com
    location /baidu {
        proxy_pass http://www.baidu.com;
    }
}
```