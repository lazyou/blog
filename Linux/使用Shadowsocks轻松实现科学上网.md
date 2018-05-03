## 使用Shadowsocks轻松实现科学上网
* http://www.itfanr.cc/2016/10/02/use-shadowsocks-to-have-better-internet-experience/

* shadowsocks是一个著名的轻量级socket代理，原始版本是基于Python编写，后来又有了Go语言版本。不过该版本在Github上的源代码由于“你懂得”的原因，已经被开发者删除了。

* 这里我推荐安装的是 `shadowsocks-libev` 版本。`shadowsocks-libev` 是一个 shadowsocks 协议的轻量级实现，是 shadowsocks-android, shadowsocks-ios 以及 shadowsocks-openwrt 的上游项目。其特点如下：
    * 体积小巧，静态编译并打包后只有 100 KB
    * 高并发，基于 libev 实现的异步 I/O，以及基于线程池的异步 DNS，同时连接数可上万。
    * 基于C语言实现，内存占用小（600k左右），低 CPU 消耗


### shadowsocks-libev 的安装
* 从源码安装 (Ubuntu/Debian系统下)
```sh
$ sudo apt-get udpate
$ mkdir shadowsocks-libev && cd shadowsocks-libev
$ sudo apt-get install build-essential autoconf libtool libssl-dev gawk debhelper dh-systemd init-system-helpers pkg-config asciidoc xmlto apg libpcre3-dev
```

* 通过Git下载源码
    * `$ git clone https://github.com/shadowsocks/shadowsocks-libev.git`

* 然后生成deb包并安装，依照以下步骤依次执行(如果出错请检查系统或者之前的步骤)：
    ```sh
    $ cd shadowsocks-libev
    $ dpkg-buildpackage -b -us -uc -i
    $ cd ..
    $ sudo dpkg -i shadowsocks-libev*.deb
    ```

* 在上面的第三步 cd .. 后，可以看到目录下编译生成了三个 *.deb 文件，我这里的是：
    * `libshadowsocks-libev-dev_2.5.3-1_amd64.deb`
    * `libshadowsocks-libev2_2.5.3-1_amd64.deb`
    * `shadowsocks-libev_2.5.3-1_amd64.deb`

* 上面的步骤操作完成后，我们就已经安装成功了 `shadowsocks-libev` 。

* 通过如下命令来查看运行状态：
    ```sh
    $ sudo service shadowsocks-libev status
    * shadowsocks-libev is not running
    ```


### 直接从作者提供的软件源安装（Ubuntu/Debian）
* 先添加GPG Key: `$ wget -O- http://shadowsocks.org/debian/1D27208A.gpg | sudo apt-key add -`

* 配置安装源，在/etc/apt/sources.list末尾添加:
    ```sh
    # Ubuntu 14.04 or above
    $ deb http://shadowsocks.org/ubuntu trusty main
    # Debian Wheezy, Ubuntu 12.04 or any distribution with libssl > 1.0.1
    $ deb http://shadowsocks.org/debian wheezy main
    ```

* 执行安装
```sh
$ apt-get update
$ apt-get install shadowsocks-libev
```


### 配置与启动
* 配置文件
    * `shadowsocks-divev` 生成的默认配置文件在目录 `/etc/shadowsocks-libev` 下，找到 `config.json` 文件并编辑：

* 将配置信息设置为：
    ```json
    {
        "server":"0.0.0.0",
        "server_port":8388,
        "local_port":1080,
        "password":"OikIryahoa",
        "timeout":60,
        "method":"aes-256-cfb"
    }
    ```


### 启动
```sh
$ sudo service shadowsocks-libev start
$ sudo service shadowsocks-libev stop
$ sudo service shadowsocks-libev status
$ sudo service shadowsocks-libev restart
```

* 查看 ss-server 的启动信息：
    ```sh
    $ sudo service shadowsocks-libev status
    * shadowsocks-libev is not running
    $ ps ax |grep ss-server
    40160 ?        Ss     0:00 /usr/bin/ss-server -c /etc/shadowsocks-libev/config.json -a root -u -f /var/run/shadowsocks-libev/shadowsocks-libev.pid -u
    40162 ?        S+     0:00 grep --color=auto ss-server
    ```

* 注意其中有 `-u`，表示会通过 `udp` 的方式进行连接。

* 通过 `netstat -lnp` 可以查看 `ss-server` 监听的端口：
    ```sh
    $ netstat -lnp
    (No info could be read for "-p": geteuid()=1000 but you should be root.)
    Active Internet connections (only servers)
    Proto Recv-Q Send-Q Local Address           Foreign Address         State       PID/Program name
    tcp        0      0 0.0.0.0:8388            0.0.0.0:*               LISTEN      -                          
    tcp        0      0 0.0.0.0:80              0.0.0.0:*               LISTEN      -               
    tcp        0      0 0.0.0.0:22              0.0.0.0:*               LISTEN      -               
    tcp6       0      0 :::80                   :::*                    LISTEN      -               
    tcp6       0      0 :::22                   :::*                    LISTEN      -                        
    udp        0      0 0.0.0.0:8388            0.0.0.0:*                           -
    ```

* 可以看到 `ss-server` 通过 `tcp` 和 `udp` 两种方式监听了 `8388` 端口。



### shadowsocks 客户端的设置
* Shadowsocks - Clients 下载对应平台的客户端软件: https://shadowsocks.org/en/download/clients.html

* windows 客户端: https://github.com/shadowsocks/shadowsocks-windows/releases


### Chrome 浏览器 + SwitchyOmega 插件实现科学上网

...