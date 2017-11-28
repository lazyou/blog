### PHP-FPM, Nginx, FastCGI 之间的关系
* https://laravel-china.org/articles/6689/the-relationship-among-php-fpm-nginx-and-fastcgi


#### PHP-FPM, Nginx, FastCGI 之间的关系
* FastCGI 是一个协议，它是应用程序和 WEB 服务器连接的桥梁。Nginx 并不能直接与 PHP-FPM 通信，而是将请求通过 FastCGI 交给 PHP-FPM 处理:
```
location ~ \.php$ {
    try_files $uri /index.php =404;
    fastcgi_pass 127.0.0.1:9000;
    fastcgi_index index.php;
    fastcgi_buffers 16 16k;
    fastcgi_buffer_size 32k;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}
```

* 这里 fastcgi_pass 就是把所有 php 请求转发给 php-fpm 进行处理。通过 netstat 命令可以看到，127.0.0.1:9000 这个端口上运行的进程就是 php-fpm.