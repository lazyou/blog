### certbot
* 进入官网 https://certbot.eff.org/ 后选择软件和系统就有对应使用方法 （选择框不明显）

* https://certbot.eff.org/lets-encrypt/ubuntufocal-nginx


### 2021年5月12日 -- 操作记录
```sh
# 必须基于 snap
sudo snap install core; sudo snap refresh core
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot

# 自动生成证书，修改nginx配置：
sudo certbot --nginx

# 仅仅生成证书
sudo certbot certonly --nginx

# 证书更新： 【配合定时器，每过几个月一次更新】
sudo certbot renew --dry-run
```


### 以前的操作记录
```
sudo apt-get install certbot python3-certbot-nginx
sudo add-apt-repository ppa:certbot/certbot
sudo certbot --nginx
sudo certbot -h
sudo certbot certificates
sudo certbot certonly
```
