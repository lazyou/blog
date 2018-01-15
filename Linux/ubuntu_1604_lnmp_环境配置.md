* https://laravel-china.org/articles/4912/start-from-scratch-to-build-a-complete-and-comprehensive-lnmp-laravel-online-operating-environment

### 服务器语言设置
* 一般不做这个设置

* 解决中文乱码, 使服务器中文化
    1. `$ locale -a` 查看所有的语言没有发现zh开头的语言

    2. `$ sudo apt-get install language-pack-zh-hant language-pack-zh-hans` 再次使用 `locale -a` 查看

    3. `$ sudo vim /etc/default/locale` 设置 LANGE 和 LANGUAGE:
        ```
        LANG="zh_CN.UTF-8″
        LANGUAGE="zh_CN.UTF-8"
        ```
    4. 使用 `$ sudo dpkg-reconfigure locales` 进行区域语言设置(全都选择 zh_CN.UTF-8)。


#### 为服务器添加普通用户
* 防止类似 删服务器 跑路的事件

* `$adduser xxx` 添加普通用户, 并给新用户 root 权限 (使普通用户可以使用如 `sudo service ... ` 之类的命令)
    * TODO: 不太明白普通用户拥有 root 权限和 root 用户本身的区别?

    * TODO: 还有现在新装的服务器也没有给出 root 超级用户的密码, 这又是为什么?


### 使用 root 继续进行环境搭建
* 不知道 root 密码可以使用 `sudo passwd root` 来设置新的 root 密码
    * TODO: root 权限的普通用户可以使用 `sudo passwd root` 乱改root的密码, 这波操作什么意思?


### 相关软件安装

#### 安装PHP
* `apt install php-common php7.0 php7.0-cli php7.0-fpm php7.0-common php7.0-opcache php7.0-readline php7.0-curl php7.0-xml php7.0-mcrypt php7.0-json php7.0-gd php7.0-mbstring php7.0-mysql`
    * 如果你尝试使用 `apt install php` 该命令会自动为你安装 Apache，因此采用上面的细化安装


* 配置 php.ini:
    * `vim /etc/php/7.0/fpm/php.ini`

    * 定位到 `;cgi.fix_pathinfo=0` 这行, 去掉其前面的 `;` 注释，并将  `cgi.fix_pathinfo=1` 改为 `cgi.fix_pathinfo=0`


* 重启 php:
    * `service php7.0-fpm restart`



#### 安装 MYSQL

* 安装命令 `apt install mysql-server` 默认安装的版本是5.7

* 配置 mysql 远程连接:
    * 注释掉在 `vim /etc/mysql/mysql.conf.d/mysqld.cnf` 里面的`bind-address = 127.0.0.1`

    * `mysql mysql -uroot -p`:
    ```
    > use mysql;
    > Grant all on *.* to 'root'@'%' identified by 'root用户的密码' with grant option;
    > flush privileges;刷新权限
    ```

* TODO: mysql 如何添加新用户, 赋予某个数据库的操作权限?



##### 安装nginx
* `apt install nginx`

* 配置 nginx 支持 php （并配置了 laravel 优雅连接的支持）
    * `vim /etc/nginx/sites-available/default`

    * 配置如下: (多站点)
    ```
    server {
        listen 80 default_server;
        listen [::]:80 default_server;
        root /home/lazyou/www/blog/public;
        index index.php index.html;
        server_name www.blog.dev;
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        }
    }

    server {
        listen 80;
        root /home/lazyou/www/blog_backup/public;
        index index.php index.html;
        server_name www.blog_backup.dev;
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        }
    }
    ```

* **gzip** 开启: sudo vim /etc/nginx/nginx.conf, `Gzip Settings` 下面相关注释全部移除就是.

* 修改 nginx 限制 post 表单上传大小:
    * `vim /etc/nginx/nginx.conf`

    * 在 `http{}` 中添加 `client_max_body_size 8M`;

    * `service nginx restart` 重启 nginx


* TODO: 更多 nginx 配置需要了解:
    * 多站点, 如何配置各自的 log,?

    * 怎么理解 php 和 nginx 这种运行机制?

    * 不同 php 版本配合 nginx?

* TODO: 在 ubuntu server 16.04 上安装出现如下错误, ubuntu 16.04 却没这个问题, 跟磁盘加密有关系?
    ```
    2017/08/19 21:08:25 [crit] 29251#29251: *6 stat() "/home/lxl/www/blog/public/" failed (13: Permission denied), client: 192.168.111.214, server: www.blog.dev, request: "GET / HTTP/1.1", host: "192.168.111.120"

    2017/08/19 21:08:25 [crit] 29251#29251: *6 stat() "/home/lxl/www/blog/public/" failed (13: Permission denied), client: 192.168.111.214, server: www.blog.dev, request: "GET / HTTP/1.1", host: "192.168.111.120"

    2017/08/19 21:08:25 [crit] 29251#29251: *6 stat() "/home/lxl/www/blog/public/index.php" failed (13: Permission denied), client: 192.168.111.214, server: www.blog.dev, request: "GET / HTTP/1.1", host: "192.168.111.120"
    ```



#### 安装 redis
* `apt install redis-server`



#### 安装 composer
* 切换回普通用户安装
    * 用普通用户安装 composer 得到的 composer 文件的用户和用户组也是普通用户，省去了更改文件权限的麻烦。因为后面我们执行的 composer 命令都是在普通用户下执行的 (TODO:蒙)

* `sudo apt install composer`

* 或者如下:
```
$ php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
$ php composer-setup.php
$ php -r "unlink('composer-setup.php');"
$ sudo mv composer.phar /usr/local/bin/composer
$ composer 查看composer安装是否成功
```

* 国内镜像设置: `composer config -g repo.packagist composer https://packagist.phpcomposer.com`


#### 安装 git
* 还是在普通用户下

* `sudo apt install git`

* ssh 协议连接 git 项目:
    * 创建 ssh-key, 方便后面使用 git 拉取代码 `ssh-keygen -t rsa -C "你的邮箱@qq.com"` 然后一路回车即可

    * `cat ~/.ssh/id_rsa.pub` 复制公钥到你的 github 或者 coding 等 git 服务器上



#### 项目权限相关设置
* `sudo chown -R :www-data blog/` 在www目录下执行这一步
    * 这一步是将 blog 文件的用户更改为 www-data，www-data 为 ubuntu 下nginx, php 的默认用户。 因为在服务器运行期间读取项目文件的并不是你，而是 nginx 和 php（这样说好矛盾，我也不是十分的理解~）

    * TODO: 没明白程序在执行的时候拥有它自己的用户是什么概念? 怎么查看每个程序所属的用户呢?

* 项目目录读写权限设置 `sudo chmod -R 774 storage/ bootstrap/`

* 其他 laravel 相关的初始化命令:
    * `.env` 文件配置

    * `composer install`

    * `php artisan migrate`

    * ...



#### 安装 php redis 扩展
* 更推荐 `sudo apt install php-redis`

* https://github.com/phpredis/phpredis.git
    ```
    git clone https://github.com/phpredis/phpredis.git
    cd phpredis

    phpize
    ./configure
    make
    make test
    sudo make install # 这一步注意观察 redis.so 生成的目录. 一般来说会自动分配好
    sudo vim /etc/php/7.0/cli/conf.d/30-redis.ini # 写入内容 extension=redis.so

    echo "extension = redis.so" | sudo tee -a /etc/php/7.0/mods-available/redis.ini
    sudo ln -s /etc/php/7.0/mods-available/redis.ini /etc/php/7.0/fpm/conf.d/30-redis.ini
    sudo ln -s /etc/php/7.0/mods-available/redis.ini /etc/php/7.0/cli/conf.d/30-redis.ini

    sudo service php7.0-fpm restart
    ```

* 验证扩展:
    * `php -m`

    * redis_test.php, `php redis_test.php` 执行脚本
        ```
        <?php

        //连接本地Redis服务
        $redis=new Redis();
        $redis->connect('localhost', '6379'); //$redis->auth('admin123');//如果设置了密码，添加此行
        //查看服务是否运行
        $redis->ping();

        //选择数据库
        $redis->select(5);

        //设置数据
        $redis->set('school', 'WuRuan');
        //设置多个数据
        $redis->mset(array('name'=>'jack','age'=>24,'height'=>'1.78'));

        //存储数据到列表中
        $redis->lpush("tutorial-list", "Redis");
        $redis->lpush("tutorial-list", "Mongodb");
        $redis->lpush("tutorial-list", "Mysql");

        //获取存储数据并输出
        echo $redis->get('school');

        echo '<br/>';

        $gets=$redis->mget(array('name','age','height'));
        var_dump($gets);

        echo '<br/>';

        $tl=$redis->lrange("tutorial-list", 0, 5);
        var_dump($tl);
        ```

### 安装 event 扩展
```
wget http://pecl.php.net/get/event-2.3.0.tgz
tar -zxvf event-2.3.0.tgz
cd event-2.3.0/

sudo apt install libevent-dev
sudo apt install pkg-config # 如果出现需要 Openssl 模块时

phpize
./configure
make
sudo make install

echo "extension = event.so" | sudo tee -a /etc/php/7.0/mods-available/event.ini
sudo ln -s /etc/php/7.0/mods-available/event.ini /etc/php/7.0/fpm/conf.d/30-event.ini
sudo ln -s /etc/php/7.0/mods-available/event.ini /etc/php/7.0/cli/conf.d/30-event.ini
sudo service php7.0-fpm restart
```

### MORE
* php 手册下载： http://php.net/download-docs.php

* 更多扩展，以及错误显示开启
```
sudo apt install php7.0-zip
sudo apt install php7.0-bcmath
sudo apt install php-bz2
 
sudo vim /etc/php/7.0/fpm/php.ini
display_errors = On
```

* nginx 日志位置
```
access_log /var/log/nginx/access.log;
error_log /var/log/nginx/error.log;
```
