## ssh 别名登录
* https://blog.csdn.net/zhanlanmg/article/details/48708255

## 在客户端设置
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