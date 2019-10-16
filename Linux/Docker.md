## 官网
* https://www.docker.com/
* 镜像查询: https://hub.docker.com/
* https://www.runoob.com/docker/docker-tutorial.html
* Docker 从 17.03 版本之后分为 CE（Community Edition: 社区版） 和 EE（Enterprise Edition: 企业版）

* 阿里云:
	* https://cr.console.aliyun.com
	* 镜像加速器: https://cr.console.aliyun.com/cn-shenzhen/instances/mirrors
	* docker login --username=帐号 registry.cn-hangzhou.aliyuncs.com

### Docker 架构
* Docker 使用客户端-服务器 (C/S) 架构模式，使用远程API来管理和创建Docker容器。
* Docker 容器通过 Docker 镜像来创建。
* 容器与镜像的关系类似于面向对象编程中的对象与类。

## dockerToolbox 和 docker for windows 的区别
* https://blog.csdn.net/JENREY/article/details/84493812
* win10以下推荐 dockerToolbox, win10 及以上推荐 docker for windows
	* docker-for-windows是为win10专业版提供的安装包(安装需要hyper-v)

### Docker 安装
* Ubuntu Docker 安装:
```sh
wget -qO- https://get.docker.com/ | sh
sudo service docker start
docker run hello-world
```

* Windows Docker 安装:
	* win10 以下: http://mirrors.aliyun.com/docker-toolbox/windows/docker-toolbox/

	* docker toolbox 是一个工具集，它主要包含以下一些内容：
		```
		Docker CLI 客户端，用来运行 docker 引擎创建镜像和容器
		Docker Machine. 可以让你在 windows 的命令行中运行 docker 引擎命令
		Docker Compose. 用来运行 docker-compose 命令
		Kitematic. 这是Docker的GUI版本
		Docker QuickStart shell. 这是一个已经配置好Docker的命令行环境
		Oracle VM Virtualbox. 虚拟机
		```

	* win10 下docker默认内网ip: 192.168.99.100

	* cmder 下运行 docker 相关命令报错可参考 tip1


### docker-toolbox 使用 tip
* 使用 docker-machine 操作运行 docker 的虚拟机
	* 设置环境变量: `MACHINE_STORAGE_PATH` 为 `D:\VirtualBox VMs\docker`. (让docker相关的文件都跑这里, 避免占用系统盘)

	* 创建一个 docker 的虚拟机: `docker-machine create --engine-registry-mirror=https://xxx.mirror.aliyuncs.com -d virtualbox default`
		* 参考: https://cr.console.aliyun.com/cn-hangzhou/instances/mirrors



### 镜像加速
* 新版的 Docker 使用 `/etc/docker/daemon.json`（Linux） 或者 `%programdata%\docker\config\daemon.json`（Windows） 来配置 Daemon。 请在该配置文件中加入（没有该文件的话，请先建一个）：
```json
{
  "registry-mirrors": ["http://hub-mirror.c.163.com"]
}
```

* TODO: 然而 `docker info` 并没看到设置成功


### Docker 使用
* `docker run -i -t ubuntu:15.10 /bin/bash`

* 参数选项:
	* -t: 在新容器内指定一个伪终端或终端;
	* -i: 允许你对容器内的标准输入 (STDIN) 进行交互;
	* -d: 后台模式启动容器;
	* -P: 将容器内部使用的网络端口 __随机__ 映射到我们使用的主机上;
	* -p [xx:xx]: 将容器内部端口绑定到 __指定__ 的主机端口;
 	* --name xxx: 命名容器;
	* -v: 挂载(映射)目录或文件到容器内部 (win10 下需要做虚拟机的共享目录才能挂载).
	* --link:

* docker:
	* run
	* start
	* stop
	* rm
	* images

	* ps [-f] 	// -f: 让 docker logs 像使用 tail -f 一样来输出容器内部的标准输出
	* top 		// 查看容器内部运行的进程
	* logs

	* build 	// 构建镜像
	* tag		// 为镜像添加一个新的标签
	* pull
	* search
	* commit [-m="描述"] [-a="作者"]
	* port 		// 查看端口的绑定情况
	* cp 		// 从容器中拷贝东西. docker cp runoob-nginx-test:/etc/nginx/nginx.conf ./conf/

* __构建镜像__
	* docker build

	* 创建一个 Dockerfile 文件
		```
		FROM    centos:6.7
		MAINTAINER      Fisher "fisher@sudops.com"

		RUN     /bin/echo 'root:123456' |chpasswd
		RUN     useradd runoob
		RUN     /bin/echo 'runoob:123456' |chpasswd
		RUN     /bin/echo -e "LANG=\"en_US.UTF-8\"" >/etc/default/local
		EXPOSE  22
		EXPOSE  80
		CMD     /usr/sbin/sshd -D
		```

	* 使用 Dockerfile 文件，通过 docker build 命令来构建一个镜像:
		* `docker build -t runoob/centos:6.7 .`
			* -t ：指定要创建的目标镜像名;
			* . ：Dockerfile 文件所在目录，可以指定Dockerfile 的绝对路径.


* Docker 容器连接
	* 网络端口映射: -P 和 -p (默认都是绑定 tcp 端口)
		* 随机映射: `docker run -d -P training/webapp python app.py`
		* 指定映射: `docker run -d -p 5000:5000 training/webapp python app.py`
		* 绑定网络地址: `docker run -d -p 127.0.0.1:5001:5000 training/webapp python app.py`
		* 绑定UDP端口: docker run -d -p 127.0.0.1:5000:5000/udp training/webapp python app.py
		* 查看端口绑定情况: `docker port`

	* 其他:
		* 端口映射并不是唯一把 docker 连接到另一个容器的方法;
		* docker 有一个连接系统允许将多个容器连接在一起，共享连接信息;
		* docker 连接会创建一个父子关系，其中父容器可以看到子容器的信息.


### Docker 实例
#### 1. Docker 安装 Nginx
* 简单案例:
```sh
docker search nginx
docker pull nginx
docker images nginx # 查看
docker run --name runoob-nginx-test -p 8081:80 -d nginx
# win10 下访问: http://192.168.99.100:8081/
```

* nginx 部署:
```sh
# 从上面简单案例的nginx容器中拷贝出 nginx 配置文件, 以便下面使用
docker runoob-nginx-test 6dd4380ba708:/etc/nginx/nginx.conf /c/Users/nginx/nginx/conf

# 为什么只能设置 c/Users 目录下? 因为 c/Users 目录被加入虚拟机的共享目录!
docker run -d -p 8082:80 --name runoob-nginx-test-web -v /c/Users/nginx/www:/usr/share/nginx/html -v /c/Users/nginx/conf/nginx.conf:/etc/nginx/nginx.conf -v /c/Users/nginx/logs:/var/log/nginx nginx

# 记得在 /c/Users/nginx/www 目录下创建 index.html 文件, 写入您要显示的内容
```


#### 2. Docker 安装 PHP
```sh
# PHP容器 (后续会用到这个容器)
docker pull php:7.2-fpm
docker run --name myphp-fpm -v /c/Users/nginx/www:/www -d php:7.2-fpm

# Nginx + PHP 部署
## 本地 /c/Users/nginx/conf/conf.d 目录下创建 nginx 配置文件 runoob-test-php.conf
server {
    listen       80;
    server_name  localhost;

    location / {
        root   /usr/share/nginx/html;
        index  index.html index.htm index.php;
    }

    error_page   500 502 503 504  /50x.html;
    location = /50x.html {
        root   /usr/share/nginx/html;
    }

    location ~ \.php$ {
        fastcgi_pass   php:9000;
        fastcgi_index  index.php;
        # /www/: 是 myphp-fpm 中 php 文件的存储路径，映射到本地的 /c/Users/nginx/www 目录
        fastcgi_param  SCRIPT_FILENAME  /www/$fastcgi_script_name;
        include        fastcgi_params;
    }
}

# 运行 Nginx + PHP 部署.
## `--link myphp-fpm:php`: 把 myphp-fpm 的网络并入 nginx
docker run --name runoob-php-nginx -p 8083:80 -d -v /c/Users/nginx/www:/usr/share/nginx/html:ro -v /c/Users/nginx//conf/conf.d:/etc/nginx/conf.d:ro --link myphp-fpm:php nginx

## /c/Users/nginx/www 目录下创建 index.php, 内容为 `echo phpinfo();`
```

#### 3. Docker 安装 MySQL
* TODO: 如何挂载 data 目录以及外置配置有待补充
```sh
# docker 中下载 mysql
docker pull mysql:5.7

# 启动
docker run --name mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=Lzslov123! -d mysql

# 进入容器
docker exec -it mysql bash

# 登录mysql
mysql -u root -p
ALTER USER 'root'@'localhost' IDENTIFIED BY 'Lzslov123!';

# 添加远程登录用户
CREATE USER 'liaozesong'@'%' IDENTIFIED WITH mysql_native_password BY 'Lzslov123!';
GRANT ALL PRIVILEGES ON *.* TO 'liaozesong'@'%';
```

### tip
* 0. 使用命令
	* `docker info` 查看配置信息
	* `docker command --help` 查看具体命令的帮助信息

* 1. cmder 运行 docker 相关命令报 `error during connect` 解决:
	* `@FOR /f "tokens=*" %i IN ('docker-machine env --shell cmd default') DO @%i`
