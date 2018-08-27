## SSH简介及工作机制
* https://blog.csdn.net/netwalk/article/details/12951031


### 1.SSH简介
* 传统的网络服务程序，如：ftp、POP 和 telnet 在 **本质上都是不安全的**，因为它们在网络上用明文传送口令和数据，别有用心的人非常容易就可以截获这些口令和数据。而且，这些服务程序的安全验证方式也是有其弱点的，就是很容易受到“中间人”（man-in-the-middle）这种方式的攻击。**所谓“中间人”** 的攻击方式，就是“中间人”冒充真正的服务器接收你传给服务器的数据，然后再冒充你把数据传给真正的服务器。服务器和你之间的数据传送被“中间人”一转手做了手脚之后，就会出现很严重的问题。

* 从前，一个名为Tatu Yl?nen的芬兰程序员开发了一种网络协议和服务软件，称为 **SSH**（Secure SHell的缩写）。__通过使用SSH，你可以把所有传输的数据进行加密__，这样“中间人”这种攻击方式就不可能实现了，而且也能够防止DNS和IP欺骗。__还有一个额外的好处就是传输的数据是经过压缩的，所以可以加快传输的速度__。SSH有很多功能，虽然许多人把Secure Shell仅当作Telnet的替代物，但你可以使用它来保护你的网络连接的安全。你可以通过本地或远程系统上的Secure Shell转发其他网络通信，如POP、X、PPP和FTP。你还可以转发其他类型的网络通信，包括CVS和任意其他的TCP通信。另外，你可以使用带 TCP包装的Secure Shell，以加强连接的安全性。除此之外，Secure Shell还有一些其他的方便的功能，可用于诸如Oracle之类的应用，也可以将它用于远程备份和像SecurID卡一样的附加认证。


### 2.SSH的工作机制
* SSH分为两部分：客户端部分和服务端部分。

* **服务端** 是一个守护进程(demon)，他在后台运行并响应来自客户端的连接请求。服务端一般是 `sshd` 进程，提供了对远程连接的处理，一般包括公共密钥认证、密钥交换、对称密钥加密和非安全连接。

* 客户端包含 `ssh` 程序以及像 scp（远程拷贝）、slogin（远程登陆）、sftp（安全文件传输）等其他的应用程序。

* 他们的工作机制大致是本地的客户端发送一个连接请求到远程的服务端，服务端检查申请的包和IP地址再发送密钥给SSH的客户端，本地再将密钥发回给服务端，自此连接建立。刚才所讲的只是SSH连接的大致过程，SSH 1.x 和 SSH 2.x 在连接协议上还有着一些差异。

* SSH被设计成为工作于自己的基础之上而不利用超级服务器(inetd)，虽然可以通过 inetd 上的 tcpd 来运行SSH进程，但是这完全没有必要。启动 SSH 服务器后，`sshd` 运行起来并在默认的 **22端口** 进行监听（你可以用 `ps -waux | grep sshd` 来查看sshd是否已经被正确的运行了）如果不是通过inetd启动的SSH，那么SSH就将一直等待连接请求。 **当请求到来的时候 SSH 守护进程会产生一个子进程，该子进程进行这次的连接处理。**

* 但是因为受版权和加密算法的限制，现在很多人都转而使用 **OpenSSH***。OpenSSH 是 SSH 的替代软件，而且是免费的，

* SSH 是由客户端和服务端的软件组成的，有两个不兼容的版本分别是：1.x和2.x。用 SSH 2.x 的客户程序是不能连接到 SSH 1.x 的服务程序上去的。OpenSSH 2.x 同时支持SSH 1.x和2.x。


## Installation
```shell
sudo apt install openssh-client (配置： /etc/ssh/ssh_config)
sudo apt install openssh-server (配置： /etc/ssh/sshd_config)
```


## 借助 sshpass 保存 ssh 中的密码
* sudo apt-get install sshpass

* 编写 ssh_to_dev.sh 脚本并赋予执行权限 (前提是要先手动 ssh 登录)
```ssh_to_dev.sh
#!/bin/bash
sshpass -p '服务器密码' ssh 服务器用户名@服务器ip
```


## ssh 别名登录
* https://blog.csdn.net/zhanlanmg/article/details/48708255


* 在客户端设置
    * `sudo vim /etc/ssh/ssh_config` 尾部添加内容
    ```sh
    Host ubuntu_master
        HostName 192.168.43.163
        Port 22
        User lxl
        IdentityFile ~/.ssh/id_rsa
        IdentitiesOnly yes
    ```

    * 使用别名登陆:
    `ssh ubuntu_master`

    * 选项注释： 
    ```sh
    HostName        指定登录的主机名或IP地址
    Port            指定登录的端口号
    User            登录用户名
    IdentityFile    登录的公钥文件
    IdentitiesOnly  只接受SSH key 登录
    PubkeyAuthentication
    ```


## ssh 无操作自动断开设置
* https://blog.csdn.net/slldxmm/article/details/80894037

### 客户端设置 ssh_config (通常客户端设置)
```
sudo vim /etc/ssh/ssh_config

* 添加配置项如下：
TCPKeepAlive yes
ServerAliveInterval 30
ServerAliveCountMax 86400
```


### 服务端配置 sshd_config
```
TCPKeepAlive yes
ClientAliveInterval 86400
ClientAliveCountMax 8640
```

## ssh 保持会话活跃
* https://stackoverflow.com/questions/25084288/keep-ssh-session-alive

### 配置解决
* sshd (the server) closes the connection if it doesn't hear anything from the client for a while. You can tell your client to send a sign-of-life signal to the server once in a while.

* The configuration for this is in the file "~/.ssh/config", create it if the configuration file does not exist. To send the signal every four minutes (240 seconds) to the remote host, put the following in your "~/.ssh/config" file.
```sh
Host remotehost:
    HostName remotehost.com
    ServerAliveInterval 240
```

* This is what I have in my "~/.ssh/config":

* To enable it for all hosts use:
```sh
Host *
ServerAliveInterval 240
```

Also make sure to run:
`chmod 600 ~/.ssh/config`

* because the config file must not be world-readable.


## 临时解决
* I wanted a one-time solution:
`ssh -o ServerAliveInterval=60 myname@myhost.com`

* Stored it in an alias:
`alias sshprod='ssh -v -o ServerAliveInterval=60 myname@myhost.com'`

* Now can connect like this:
`me@MyMachine:~$ sshprod`


## ssh证书登录
* https://www.jianshu.com/p/7da1163e353f

### 前言
* ssh 有密码登录和证书登录. 密码登录, 特别是外网的机器, 很容易遭到攻击. 真正的生产环境中, ssh 登录还是证书登录. 目前在使用 ansible 配置管理其他机器时, 推荐要求机器间采用证书登录, 实现无密码跳转. 

### 证书登录步骤
1. 生成证书：私钥和公钥, 私钥存放在客户端, 必要时为私钥加密;

2. 服务器添加信用公钥：把生产的公钥, 上传到 ssh 服务器, 添加到指定的文件中;

3. 配置开启允许证书登录, 客户端就能通过私钥登录 ssh 服务器了. 

### 实例配置
1. 生成私钥和公钥 (建议在客户端生成)
```sh
# rsa 或者 dsa 加密算法, 这里采用 rsa
# 如果一路回车默认生成 id_rsa 和 id_rsa.pub, 前者是私钥, 放在客户端, 后者是公钥, 需要放在ssh服务器
username@ling:~$ ssh-keygen -t rsa                                
Generating public/private rsa key pair.                     
Enter file in which to save the key (/home/username/.ssh/id_rsa):
Created directory '/home/username/.ssh'.                         
Enter passphrase (empty for no passphrase):                 
Enter same passphrase again:                                
Your identification has been saved in /home/username/.ssh/id_rsa.
Your public key has been saved in /home/username/.ssh/id_rsa.pub.
The key fingerprint is:                                     
SHA256:md8NFUnpb0xLQuoCDKg6NPQni//7mu7HYiix0/0tiL4 username@ling  
The key's randomart image is:                               
+---[RSA 2048]----+                                         
|    .        .oo |                                         
| . . .       .o. |                                         
|. o   o     o..  |                                         
| + o . o o . o...|                                         
|o o +   S . . o+.|                                         
|oo .     o o o .+|                                         
| .= + o   o . .. |                                         
| + = =.+.        |                                         
|  +E*BBo..       |                                         
+----[SHA256]-----+                                         
```


2. 例如在客户端生成的公钥, 需要将公钥拷贝到服务器上
```sh
# 拷贝公钥到ssh服务器
# scp <本地私钥path> username@ip:<path>
# 还没配置完成, 交互方式还是传统的用户名和密码吧

# 建议这步
scp id_rsa.pub vagrant@10.45.47.54:~

# 这步比较跳跃 (复制到服务器上并且把公钥写入制定位置)
scp id_rsa.pub vagrant@10.45.47.55:~ && ssh vagrant@10.45.47.55 "cat ~/id_rsa.pub >> ~/.ssh/authorized_keys"
```


3. 服务端将公钥添加到 authorized_keys
```sh
# authorized_key s一般在 ~/.ssh/ 目录下, 没有可以新建, 也可以后面改 sshd_confi g配置文件, 指向其他路径
# 追加公钥到文件末尾
cat  id_rsa.pub >> ~/.ssh/authorized_keys
```


4. **重要配置项**, 注意 __服务端__ 配置的是 `sshd_config`, __客户端__ 配置的是 `ssh_config`
* 服务端 sshd_config 配置: 公钥目录指定
```sh
sudo vim /etc/ssh/sshd_config

# 这里指定公钥的目录
RSAAuthentication yes
PubkeyAuthentication yes
# 公钥目录指定
AuthorizedKeysFile      %h/.ssh/authorized_keys
```

* 客户端 sh_config 配置: 添加私钥路径
```sh
sudo vim /etc/ssh/ssh_config

# 添加私钥路径
# 如果存在多个可以再次添加
IdentityFile ~/.ssh/id_rsa
IdentityFile ~/.ssh/rat_rsa
```


5. 执行登录: 此时能直接登上服务器, 不需要输入密码
```sh
# 客户端如果没有配置私钥路径, 可以在ssh后-i参数跟上私钥路径
# ssh user@ip 完成登录
ssh vagrant@10.45.47.54
```


6. 其他注意
* ssh 登录时可以添加 -v 参数打印登录的详细信息；

* 服务端的 ~/.ssh 下面只能自己有读写权限, 其他用户和用户组不能有写权限, 至少要600, 这个问题遇到过, 配置了公钥和私钥, 但是客户端就是不能登录, 最后排查发现服务端的用户主目录曾被改过目录, 但是用户的主目录有用户组的写权限导致客户端怎么都不能以证书方式登录, 最后 `chmod g-w ~` 搞定
