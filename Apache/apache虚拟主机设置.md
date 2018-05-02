
理解配置虚拟主机的两种方式。

#### 1.基于域名的虚拟主机【推荐】
先配置 hosts 【c:\windows\system32\drivers\etc】文件 ： 手动dns解析
```
127.0.0.1  localhost
127.0.0.1  www.localhostjscookie.com
127.0.0.1  www.localhost.com
```
 
再配置 httf.conf【D:\ApacheGroup\Apache2\conf】 文件 
一定要开启这个（可以手动关闭就知道为什么了）
```
# Use name-based virtual hosting.
 NameVirtualHost *:80
```

以及配置:
```
<VirtualHost *:80>
DocumentRoot D:/Website/jscookie/
ServerName www.localhostjscookie.com
ServerAlias alias.localhostjscookie.com
</VirtualHost> 

<VirtualHost  *:80>
DocumentRoot D:/Website/quickpay/
ServerName www.localhost.com
ServerAlias alias.localhost.com
</VirtualHost> 

<VirtualHost  *:80>
DocumentRoot D:/Website/
ServerName localhost
</VirtualHost> 
```



#### 2.基于ip地址的虚拟主机
先配置 hosts 【c:\windows\system32\drivers\etc】文件 ： 手动dns解析    
【但是每个域名对应的ip地址要唯一】
```
127.0.0.3  localhost
127.0.0.2  www.localhostjscookie.com
127.0.0.1  www.localhost.com 
```

 再配置 httf.conf【D:\ApacheGroup\Apache2\conf】 文件  
关闭 #NameVirtualHost *:80 这个，可以打开看看那里出错

以及配置 
```
<VirtualHost  127.0.0.1:80>    #注意这里写的是ip
DocumentRoot D:/Website/quickpay/
ServerName www.localhost.com
ServerAlias alias.localhost.com
</VirtualHost> 

<VirtualHost 127.0.0.2:80>
DocumentRoot D:/Website/jscookie/
ServerName www.localhostjscookie.com
ServerAlias alias.localhostjscookie.com
</VirtualHost> 

<VirtualHost  127.0.0.3:80>
DocumentRoot D:/Website/
```
ServerName localhost
</VirtualHost> 
