## gogs 部署
* 官网: https://gogs.io/docs/installation/install_from_binary
* 参考:
    * https://blog.mynook.info/post/host-your-own-git-server-using-gogs/
    * http://static.markbest.site/blog/95.html

### 步骤:
    * 新建用户；
    * 下载源码编译 / 下载预编译二进制打包；
    * 运行安装；
    * 配置调整；
    * 配置 nginx 反向代理；
    * 保持服务运行；


### 1.新建用户
* Gogs 默认以 `git` 用户运行（你应该也不会想一个能修改 ssh 配置的程序以 root 用户运行吧？）。 运行 `sudo adduser git` 新建好 `git` 用户。 `su git` 以 git 用户登录，到 git 用户的主目录中新建好 `.ssh` 文件夹

* 接下来都是用 `git` 用户操作


### 2. 下载解包
* https://gogs.io/docs/installation/install_from_binary


### 3. gogs 运行安装
* 首先建立好数据库。在 gogs 目录的 `scripts/mysql.sql` 文件是数据库初始化文件。执行 `mysql -u root -p < scripts/mysql.sql` （需要输入密码）即可初始化好数据库。

* 然后登录 MySQL 创建一个新用户 `gogs`，并将数据库 `gogs` 的所有权限都赋予该用户。
```sh
$ mysql -u root -p
> # （输入密码）
> create user 'gogs'@'localhost' identified by '密码';
> grant all privileges on gogs.* to 'gogs'@'localhost';
> flush privileges;
> exit;
```

* 运行 `./gogs web` 把 gogs 运行起来，然后访问 `http://服务器IP:3000/` 来进行安装，填写好表单之后提交就可以了。  (勾选访问限制, 登录后才可以查看项目)


### 4. 配置调整
* 配置文件位于 gogs 目录的 `custom/conf/app`.ini，是 INI 格式的文本文件。详细的配置解释和默认值请参考官方文档，其中关键的配置大概是下面这些。
    * RUN_USER 默认是 `git`，指定 Gogs 以哪个用户运行
    * ROOT 所有仓库的存储根路径
    * PROTOCOL 如果你使用 nginx 反代的话请使用 `http`，如果直接裸跑对外服务的话随意
    * DOMAIN 域名。会影响 SSH clone 地址
    * ROOT_URL 完整的根路径，会影响访问时页面上链接的指向，以及 HTTP clone 的地址
    * HTTP_ADDR 监听地址，使用 nginx 的话建议 `127.0.0.1`，否则 0.0.0.0 也可以
    * HTTP_PORT 监听端口，默认 `3000`
    * INSTALL_LOCK 锁定安装页面
    * Mailer 相关的选项

* 其中，Mailer 可以使用 Mailgun 的免费邮件发送服务，将 Mailgun 的 SMTP 配置填入到配置中就好。


### 5. nginx 反代
* 在 `/etc/nginx/sites-available` 中新建一个文件，把以下内容写入文件中。
```sh
server {
    listen 80; # 或者 443，如果你使用 HTTPS 的话    
    server_name 域名或IP;
    # ssl on; 是否启用加密连接
    # 如果你使用 HTTPS，还需要填写 ssl_certificate 和 ssl_certificate_key

    location / { # 如果你希望通过子路径访问，此处修改为子路径，注意以 / 开头并以 / 结束
        proxy_pass http://127.0.0.1:3000/;
    }
}
```

* 然后进入 `/etc/nginx/sites-enabled` 中，执行 `ln -s ../sites-available/配置文件名` 启用这个配置文件。 最后重启 `nginx` 就好了，Ubuntu 下是 `sudo service nginx restart`。
