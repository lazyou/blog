## nginx 配置 HTTP认证
* https://segmentfault.com/a/1190000003793613

* 配置流程
```shell
# 需要htpassword来创建和生成加密的用户用于基础认证（Basic Authentication）
sudo apt-get install apache2-utils

sudo htpasswd -c /etc/nginx/.httpsite admin
[sudo] password for lin: 
New password: 
Re-type new password: 
Adding password for user admin

# 查看配置内容
cat /etc/nginx/.httpsite
admin:$apr1$wN3NemOh$ne5a3AvQjyGICaR7TTdLo1

# nginx 配置，新建配置文件 `/etc/nginx/conf.d/httpsite.conf`
server {
    listen 80;
    root /var/www/httpsite;
    index index.php index.html;
    server_name www.httpsite.test;
                                                                                                   
    location / {
        auth_basic "Restricted";                    #For Basic Auth
        auth_basic_user_file /etc/nginx/.httpsite;  #For Basic Auth
    }   
} 

sudo service nginx reload
```
