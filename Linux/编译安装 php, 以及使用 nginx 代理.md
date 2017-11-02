## 编译安装 php, 以及使用 nginx 代理:
* 编译 php 没那么复杂

* 了解 php-fpm 与 nginx 是什么关系， 怎么结合的


### 编译 php
```
./configure --prefix=/usr/local/php-7.0.22 --with-config-file-path=/usr/local/php-7.0.22/etc/ --enable-fpm --with-fpm-user=www-data --with-fpm-group=www-data --with-mysql-sock --with-mysqli --with-pdo-mysql --with-iconv-dir --with-freetype-dir --with-jpeg-dir --with-png-dir --with-libxml-dir=/usr --disable-rpath --enable-bcmath --enable-shmop --enable-inline-optimization --with-curl --enable-mbregex --enable-mbstring --enable-ftp --with-gd --enable-gd-native-ttf --enable-soap --without-pear --with-gettext --disable-fileinfo --enable-maintainer-zts --disable-debug --enable-shared --enable-opcache --enable-pdo --with-iconv --with-mcrypt --with-mhash --with-openssl --enable-xml --with-xmlrpc --with-libxml-dir --enable-pcntl --enable-sysvmsg --enable-sysvsem --enable-sysvshm --with-zlib --enable-zip  --without-sqlite3 --without-pdo-sqlite --with-libdir=/lib/x86_64-linux-gnu --with-jpeg-dir=/usr/lib --with-apxs2=/usr/bin/apxs2 --enable-cgi  --enable-wddx --with-zlib-dir --with-bz2 --enable-session --enable-exif
```


### make:
* Php 7.0.1 cannot find OpenSSL's <evp.h> 问题:
    * `sudo apt-get install pkg-config libssl-dev`

    * https://github.com/mongodb/mongo-php-driver/issues/138


#### sudo make install:
lazyou@u ~/php-7.0.22> `sudo make install`
* 安装完能看到配置信息， 也就是编译后的生成了什么，配置在哪/ 扩展在哪之类的
```
Installing PHP SAPI module:       apache2handler
/usr/share/apache2/build/instdso.sh SH_LIBTOOL='/usr/share/apr-1.0/build/libtool' libphp7.la /usr/lib/apache2/modules
/usr/share/apr-1.0/build/libtool --mode=install install libphp7.la /usr/lib/apache2/modules/
libtool: install: install .libs/libphp7.so /usr/lib/apache2/modules/libphp7.so
libtool: install: install .libs/libphp7.lai /usr/lib/apache2/modules/libphp7.la
libtool: install: warning: remember to run `libtool --finish /home/lazyou/php-7.0.22/libs'
chmod 644 /usr/lib/apache2/modules/libphp7.so
[preparing module `php7' in /etc/apache2/mods-available/php7.load]
Module php7 already enabled
Installing shared extensions:     /usr/local/php-7.0.22/lib/php/extensions/no-debug-zts-20151012/
Installing PHP CLI binary:        /usr/local/php-7.0.22/bin/
Installing PHP CLI man page:      /usr/local/php-7.0.22/php/man/man1/
Installing PHP FPM binary:        /usr/local/php-7.0.22/sbin/
Installing PHP FPM defconfig:     /usr/local/php-7.0.22/etc/
Installing PHP FPM man page:      /usr/local/php-7.0.22/php/man/man8/
Installing PHP FPM status page:   /usr/local/php-7.0.22/php/php/fpm/
Installing phpdbg binary:         /usr/local/php-7.0.22/bin/
Installing phpdbg man page:       /usr/local/php-7.0.22/php/man/man1/
Installing PHP CGI binary:        /usr/local/php-7.0.22/bin/
Installing PHP CGI man page:      /usr/local/php-7.0.22/php/man/man1/
Installing build environment:     /usr/local/php-7.0.22/lib/php/build/
Installing header files:          /usr/local/php-7.0.22/include/php/
Installing helper programs:       /usr/local/php-7.0.22/bin/
  program: phpize
  program: php-config
Installing man pages:             /usr/local/php-7.0.22/php/man/man1/
  page: phpize.1
  page: php-config.1
/home/lazyou/php-7.0.22/build/shtool install -c ext/phar/phar.phar /usr/local/php-7.0.22/bin
ln -s -f phar.phar /usr/local/php-7.0.22/bin/phar
Installing PDO headers:           /usr/local/php-7.0.22/include/php/ext/pdo/
```


### php --ini
lazyou@u ~/php-7.0.22> php --ini
* 辅助命令查看 ini 配置信息
```
Configuration File (php.ini) Path: /etc/php/7.0/cli
Loaded Configuration File:         /etc/php/7.0/cli/php.ini
Scan for additional .ini files in: /etc/php/7.0/cli/conf.d
Additional .ini files parsed:      /etc/php/7.0/cli/conf.d/10-mysqlnd.ini,
/etc/php/7.0/cli/conf.d/10-opcache.ini,
/etc/php/7.0/cli/conf.d/10-pdo.ini,
...
/etc/php/7.0/cli/conf.d/20-xsl.ini,
/etc/php/7.0/cli/conf.d/30-libphp_mf.ini
```


### 设置环境变量
*  vim ~/.bashrc 把 'export PATH=$PATH:/usr/local/php-7.0.22/bin' 加到最后面

* 本次操作添加环境变量: `export PATH=$PATH:/usr/local/php-7.0.22/bin`

### php-fpm 配置
```
cd /usr/local/php-7.0.22/etc
mv php-fpm.conf.default php-fpm.conf
mv php-fpm.d/www.conf.defualt php-fpm.d/www.conf
```

```
在编译后的目录下复制 php-fpm.service 到 /lib/systemd/system/
cd ~/php-7.0.22/sapi/fpm
sudo cp php-fpm.service /lib/systemd/system/
```

* 就可以使用 `sudo service php-fpm start|stop|status|restart`


### nginx 代理 php 实现访问
* nginx 安装: `sudo apt install nginx`

* php-fpm 走的是127.0.0.1:9000，外网是无法访问的，而且我们也不可能直接通过 php-fpm给 外网提供服务，我们用 nginx 去代理 9000 端口执行 php

* sudo vim /etc/nginx/nginx.conf 加入下配置:
```
upstream php7 {
    server 127.0.0.1:9000 weight=1;
}
```

* sudo vim /etc/nginx/nginx.conf 配置虚拟主机的时候就可以使用
```
location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass php7; # 这个 php7 就是上面配置的
    # fastcgi_pass unix:/run/php/php7.0-fpm.sock;
}

// 或者如下, 直接使用 fastcgi_pass   127.0.0.1:9000;, 不需要定义上面的 php7
location ~ \.php$ {
    root           html;
    fastcgi_pass   127.0.0.1:9000;
    fastcgi_index  index.php;
    fastcgi_param  SCRIPT_FILENAME  /$document_root$fastcgi_script_name;
    include        fastcgi_params;
}
```
