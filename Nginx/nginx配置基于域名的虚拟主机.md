## nginx配置基于域名的虚拟主机
* 在 hosts 里映射到本地的127.0.0.1上：
```
127.0.0.1 www.test.test
```

* 默认放在 `/etc/nginx/conf.d` 目录下命名例如 `test.conf` 配置
```conf
server {
    listen 80;
    root /var/www/;
    index index.php index.html;
    server_name www.test.test;

    access_log /var/log/nginx/test.access.log main;
    error_log /var/log/nginx/test.error.log error;

    # 测试 php-cgi 和 php-fpm 的效率区别
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    }
}
```
