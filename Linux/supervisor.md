## 参考
* http://liyangliang.me/posts/2015/06/using-supervisor/

* https://github.com/lisijie/lab/issues/11  

* https://blog.tanteng.me/2017/01/supervisor-laravel-queue/


## 介绍
* Supervisor ,是一个进程控制系统，是一个客户端/服务器端系统允许用户在UNIX-LIKE 操作系统中去监控，控制一些进程。Supervisor 作为主进程，Supervisor 下管理的时一些子进程，当某一个子进程异常退出时，Supervisor 会立马对此做处理，通常会 _守护进程_，重启该进程。

* Supervisor 有两个主要的组成部分：
    * `supervisord`，运行 Supervisor 时会启动一个 _进程 supervisord_，它负责启动所管理的进程，并将所管理的进程作为自己的子进程来启动，而且可以在所管理的进程出现崩溃时自动重启。
    
    * `supervisorctl`，是 _命令行管理工具_，可以用来执行 `stop、start、restart` 等命令，来对这些子进程进行管理。


## 安装
```
$ sudo apt-get install supervisor # 推荐
$ sudo pip install supervisor
```

* 通过 `pip` 的方式安装后不会安装为默认服务，还需要自己将 supervisor 程序设置为后台服务。而通过 `apt-get` 的方式安装后就默认创建为了后台服务，可以直接通过 `service supervisor restart` 的方式来管理。


## 配置
* 我们把配置分成两部分：
    * `supervisord`（supervisor 是一个 C/S 模型的程序，这是 server 端，对应的有 client 端：`supervisorctl`）和应用程序（即我们要管理的程序）。

### supervisord 的配置
* 默认生成配置文件： `/etc/supervisor/supervisord.conf`

* 所有配置项执行命令 `echo_supervisord_conf` 查看

* 部分配置参考:
```ini
[unix_http_server]
file=/tmp/supervisor.sock   ; UNIX socket 文件，supervisorctl 会使用
;chmod=0700                 ; socket 文件的 mode，默认是 0700
;chown=nobody:nogroup       ; socket 文件的 owner，格式： uid:gid

;[inet_http_server]         ; HTTP 服务器，提供 web 管理界面
;port=127.0.0.1:9001        ; Web 管理后台运行的 IP 和端口，如果开放到公网，需要注意安全性
;username=user              ; 登录管理后台的用户名
;password=123               ; 登录管理后台的密码

[supervisord]
logfile=/tmp/supervisord.log ; 日志文件，默认是 $CWD/supervisord.log
logfile_maxbytes=50MB        ; 日志文件大小，超出会 rotate，默认 50MB
logfile_backups=10           ; 日志文件保留备份数量默认 10
loglevel=info                ; 日志级别，默认 info，其它: debug,warn,trace
pidfile=/tmp/supervisord.pid ; pid 文件
nodaemon=false               ; 是否在前台启动，默认是 false，即以 daemon 的方式启动
minfds=1024                  ; 可以打开的文件描述符的最小值，默认 1024
minprocs=200                 ; 可以打开的进程数的最小值，默认 200

; the below section must remain in the config file for RPC
; (supervisorctl/web interface) to work, additional interfaces may be
; added by defining them in separate rpcinterface: sections
[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

[supervisorctl]
serverurl=unix:///tmp/supervisor.sock ; 通过 UNIX socket 连接 supervisord，路径与 unix_http_server 部分的 file 一致
;serverurl=http://127.0.0.1:9001 ; 通过 HTTP 的方式连接 supervisord

; 包含其他的配置文件
[include]
files = relative/directory/*.ini    ; 可以是 *.conf 或 *.ini
```

* 启动：
```
sudo service supervisor start # 推荐

# 通过 -c 选项指定配置文件路径
# 如果不指定会按照这个顺序查找配置文件：
# $CWD/supervisord.conf, $CWD/etc/supervisord.conf, /etc/supervisord.conf：
sudo supervisord -c /etc/supervisor/supervisord.conf # 不推荐

ps aux | grep supervisord #查看 supervisord 是否在运行
```

### supervisorctl 配置
* 默认放在： `/etc/supervisor/conf.d/*.conf` (/etc/supervisor/supervisord.conf 里可看到这行配置项 [include])

* 【不推荐】`sudo supervisorctl reload`

* 【推荐】`sudo supervisorctl 或者 sudo supervisorctl -c /etc/supervisor/supervisord.conf` 进入 supervisorctl 的 shell 界面
```shell
> help
> reload name # 重载某个队列
> reload name:*
> status    # 查看程序状态
> stop hello   # 关闭 hello 程序
> start hello  # 启动 hello 程序
> restart hello    # 重启 hello 程序
> reread    ＃ 读取有更新（增加）的配置文件，不会启动新添加的程序
> update    ＃ 重启配置文件修改过的程序
```

* 也可以直接在 bash 终端运行：
```shell
sudo supervisorctl status
sudo supervisorctl stop hello
sudo supervisorctl start hello
sudo supervisorctl restart hello
sudo supervisorctl reread
sudo supervisorctl update
```

* 一个案例
    * `sudo su - root -c "echo_supervisord_conf > /etc/supervisor/conf.d/hello.conf"` 生成配置, 只保留 `[program:theprogramname]` 部分

    * php 脚本 /home/lin/Codes/hello.php：
        ```php
        <?php
        // supervisord 案例脚本
        // 这个脚本每个3秒输出当前时间到日志文件 app.out
        while (true) {
            sleep(3);
            file_put_contents(__DIR__.'/app.out', date("Y-m-d H:i:s")."\n", FILE_APPEND);
        }
        ```    

    * hello 主要配置： `/etc/supervisor/conf.d/hello.conf `
        ```ini
        [program:hello]
        command=/usr/bin/php /home/lin/Codes/hello.php              ; the program (relative uses PATH, can take args)
        process_name=%(program_name)s ; process_name expr (default %(program_name)s)
        ;numprocs=1                    ; number of processes copies to start (def 1)
        autostart=true                ; start at supervisord start (default: true)
        autorestart=true        ; when to restart if exited after running (def: unexpected)
        ```

    * 启动： `sudo supervisorctl start hello`

    * 查看： `ps aux | grep hello` (可以 sudo kill 这个进程发现会立即自动再开启此进程)


### 常见问题
* 解决 supevisor 提示 socket error 错误: http://pycode.cc/supervisor-socket-error/
```shell
今天给自己的一个新服务配置使用 supervisor，apt 或者 setuptools 均可安装，过程不表。

安装完成后，将配置文件拷贝到 /etc/supervisor/conf.d 中，然后使用 supervisorctl reload 却得到报错提示：

error: <class 'socket.error'>, [Errno 2] No such file or directory: file: /usr/lib/python2.7/socket.py line: 228  
经过搜索，在 stackOverFlow 上找到了解决办法：

在运行 reload 命令前，先运行如下两个命令

sudo supervisord -c /etc/supervisor/supervisord.conf  
sudo supervisorctl -c /etc/supervisor/supervisord.conf  
即可解决 socket error，然后再使用 reload 命令，就可以正常的启动 supervisor 了。
````
