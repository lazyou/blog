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
