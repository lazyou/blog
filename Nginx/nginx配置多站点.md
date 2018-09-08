### Nginx 配置多站点
* https://www.codecasts.com/blog/post/set-up-nginx-multiple-server-sites-virtual-hosts-on-ubuntu

* 在维护 codecasts 期间，遇到很多次“一个 nginx 如何配置多个站点” 的问题，我通常的回复就是：多添加一个 server 的 block 配置就好了，然而很多同学还是没能配置成功，今天我们仔细来看看在 一台 Ubuntu 的服务器中，如何在 nginx 在配置多个站点。

### 1. 安装 Nginx
在 Ubuntu 中，你可以直接通过 apt-get 命令来安装 Nginx:

`sudo apt-get install nginx`

### 2.创建新的文件路径
* 在安装完新的 Nginx 之后，针对多个站点的配置，其实我们可以设置不同的 root 来返回不同的内容：
```
sudo mkdir -p /var/www/domain-one.com/html
sudo mkdir -p /var/www/domain-two.com/html
```

* 以上的命令就会创建两个对应的目录：主要将 domain-one.com 和 domain-two.com 换成你自己的域名。然后再将这两个文件夹给定权限和所有权：
```
sudo chown -R www-data:www-data /var/www/domain-one.com/html
sudo chown -R www-data:www-data /var/www/domain-two.com/html
```
* 上面的 www-data:www-data 就是 Nginx 默认的用户组合用户名。

### 3.创建不同的入口文件
* 在这里为了演示方便，我们可以直接在第二步的两个目录中分别创建 index.html 文件：`sudo vim /var/www/domain-one.com/html/index.html`

* 然后添加下面的内容：
```html
<html>
    <head>
        <title>Welcome to Domain-one.com!</title>
    </head>
    <body>
        <h1>Success!  The Domain-one.com server block is working!</h1>
    </body>
</html>
```

* 对应的 domain-two.com 我们可以这样： `sudo vim /var/www/domain-two.com/html/index.html`

* 在 domain-two.com 这里添加下面的内容：
```html
<html>
    <head>
        <title>Welcome to Domain-two.com!</title>
    </head>
    <body>
        <h1>Success!  The Domain-two.com server block is working!</h1>
    </body>
</html>
```

* 主要上面的内容主要是用 domain-one 和 domain-two 来区分，在你照着文章实践的时候，记得替换成你自己的域名，如何你仅仅是学习目的的话: 推荐你去买腾讯云的香港主机（香港主机不用备案），趁着双十一活动便宜！

### 4.创建不同的配置文件
* 在安装完 Nginx 之后，其实 Nginx 的 **默认配置文件** 实在 `/etc/nginx/sites-available/default` 的，但是我们要配置多站点的话，可以这样：
    * `sudo cp /etc/nginx/sites-available/default /etc/nginx/sites-available/domain-one.com`

* 然后编辑 `/etc/nginx/sites-available/domain-one.com` 配置文件：
    * `sudo vi /etc/nginx/sites-available/domain-one.com`

* 删除原来所有的配置内容，添加下面的配置：
```
server {
        listen 80;
        listen [::]:80;

        root /var/www/domain-one.com/html;
        index index.html index.htm index.nginx-debian.html;

        server_name domain-one.com www.domain-one.com;

        location / {
                try_files $uri $uri/ =404;
        }
}
```

* 这样就配置完 domain-one.com 了，如果你需要配置 SSL 的话，一样是在 `/etc/nginx/sites-available/domain-one.com` 这个文件配置就好。接下来就照葫芦画瓢，我们创建 domain-two.com 的配置文件：
    * `sudo cp /etc/nginx/sites-available/domain-one.com /etc/nginx/sites-available/domain-two.com`

* 以上命令就会复制出 domain-two.com 的配置文件，然后编辑该文件：
    * `sudo vi /etc/nginx/sites-available/domain-two.com`

* 主要在这个文件里面主要是将 domain-one.com 改为 domain-two.com; 然后，root 也注意一下：
```
server {
        listen 80;
        listen [::]:80;

        root /var/www/domain-two.com/html;
        index index.html index.htm index.nginx-debian.html;

        server_name domain-two.com www.domain-two.com;

        location / {
                try_files $uri $uri/ =404;
        }
}
```

* 这样我们的两个域名配置文件就设置好了，最后我们需要将原来 Nginx 的 default 配置删除：
    * `sudo rm etc/nginx/sites-available/default`

* 注意这里是要删除的！

* 5.建立软链接
* 有了 domain-one.com 和 domain-two.com 的配置之后，我们需要把这两个配置告知 Nginx ：
```
sudo ln -s /etc/nginx/sites-available/domain-one.com /etc/nginx/sites-enabled/

sudo ln -s /etc/nginx/sites-available/domain-two.com /etc/nginx/sites-enabled/
```

* 执行上面的命令之后，我们再使用 nginx -t 检测 Nginx 的配置文件是否有错：
    * `sudo nginx -t`

* 如果你没有看到报错，就可以直接重启 Nginx 服务了：
    * `sudo service nginx restart`

* 这样就大功告成啦！访问你的域名试试！！！
