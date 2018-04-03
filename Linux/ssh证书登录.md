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
