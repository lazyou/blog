## ftp 服务器安装配置
* https://www.shellhacks.com/install-vsftpd-ftp-server-centos-rhel/

* https://segmentfault.com/a/1190000008578734

* __VSftpd__ is an FTP server for Linux.

### linux 查看vsftp是否启动状态: 
```
ps -ef | grep ftp
service vsftpd status
```

### 遇到的问题: VSFTPD 530 Login incorrect
* https://serverfault.com/questions/180778/vsftpd-530-login-incorrect
```
vim /etc/pam.d/vsftpd
注释掉 auth required pam_shells.so
service vsftpd restart
```


### Install the VSftpd Server
* ftp 服务端: `yum install vsftpd`

* vsftpd 配置备份: `cp /etc/vsftpd/vsftpd.conf /etc/vsftpd/vsftpd.conf.back`

* 如果你想要安装 ftp 客户端: `yum install ftp`

### Configure the VSftpd Server
* `vim /etc/vsftpd/vsftpd.conf`:
```
Option	                    Description
anonymous_enable=NO	        Disable anonymous login
local_enable=YES	        Enable local users
write_enable=YES	        Give FTP users permissions to write data
connect_from_port_20=NO	    Port 20 need to be turned off. It makes VSftpd run less privileged
chroot_local_user=YES	    Chroot everyone
local_umask=022	            Set umask to 022, to make sure that all the files (644) and folders (755) you upload, get the proper permissions
allow_writeable_chroot=YES
```

* Check vsftpd.conf man pages, for all configuration options.
    * `man vsftpd.conf`

### Add New FTP User
* 创建 ftp 用户: `useradd -d '/var/www/path/to/your/dir' -s /sbin/nologin ftpuser`

* 设置 ftp 用户密码: `passwd ftpuser`

* ftp 目录设置:
```sh
mkdir -p /var/www/path/to/your/dir
chown -R ftpuser '/var/www/path/to/your/dir'
chmod 775 '/var/www/path/to/your/dir'
```

* 用户组设置:
```sh
groupadd ftpusers
usermod -G ftpusers ftpuser
```

### Configure the Firewall for VSftpd
```
vi /etc/sysconfig/iptables
-A INPUT -m state --state NEW -m tcp -p tcp --dport 21 -j ACCEPT
service iptables restart
```

### Set the VSftpd service to Start At Boot
```
chkconfig --levels 235 vsftpd on
service vsftpd start
```

### Test the VSftpd Server
* Test the FTP Server locally: `ftp localhost`
* Output:
```
Trying 127.0.0.1...
Connected to localhost (127.0.0.1).
220 (vsFTPd 2.2.2)
Name (localhost:root): ftpuser
331 Please specify the password.
Password:
230 Login successful.
Remote system type is UNIX.
Using binary mode to transfer files.
***
```

* Test it remotely: `ftp your.ftp.server.com`
* Output:
```
Connected to your.ftp.server.com.
220 (vsFTPd 2.2.2)
Name (your.ftp.server.com:yourname):
Name (localhost:root): ftpuser
331 Please specify the password.
Password:
230 Login successful.
Remote system type is UNIX.
Using binary mode to transfer files.
***
```