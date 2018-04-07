## Ubuntu环境下SSH的安装及使用
* https://blog.csdn.net/netwalk/article/details/12952051

* SSH是指Secure Shell,是一种安全的传输协议，Ubuntu客户端可以通过SSH访问远程服务器 。

* SSH分客户端 openssh-client 和 openssh-server

### 一、安装客户端
* Ubuntu缺省已经安装了ssh client。
```sh
sudo apt-get install ssh  或者 sudo apt-get installopenssh-client

ssh-keygen # (按回车设置默认值)

# 按缺省生成id_rsa和id_rsa.pub文件，分别是私钥和公钥。
```

* 说明：如果 `sudo apt-get insall ssh` 出错，无法安装可使用 `sudo apt-get install openssh-client` 进行安装。

* 假定服务器ip为 192.168.1.1，ss h服务的端口号为 22，服务器上有个用户为root, 用ssh登录服务器的命令为：
```sh
>ssh –p 22 root@192.168.1.1
>输入root用户的密码
``


### 二、安装服务端
* Ubuntu缺省没有安装SSH Server，使用以下命令安装：
`sudo apt-get install openssh-server`

* 然后确认sshserver是否启动了：
`ps aux | grep ssh`

* 如果没有则可以这样启动：
`sudo /etc/init.d/ssh start` 或者 `sudo service ssh start`

* 事实上如果没什么特别需求，到这里 OpenSSH Server 就算安装好了。但是进一步设置一下，可以让 OpenSSH 登录时间更短，并且更加安全。这一切都是通过修改 openssh 的配置文件 `sshd_config` 实现的。


### 更多
* 使用请查看其他
