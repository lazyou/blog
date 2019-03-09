## ubuntu 下 PHP 多版本共存
* https://www.mf8.biz/ubuntu-install-php-fpm/


### 操作记录
```
sudo add-apt-repository ppa:ondrej/php  

# 安装 PHP7.1
sudo apt install php7.1-fpm php7.1-mysql php7.1-curl php7.1-gd php7.1-mbstring php7.1-mcrypt php7.1-xml php7.1-xmlrpc php7.1-zip php7.1-opcache -y

# 安装 PHP7.0
sudo apt install php7.0-fpm php7.0-mysql php7.0-curl php7.0-gd php7.0-mbstring php7.0-mcrypt php7.0-xml php7.0-xmlrpc php7.0-zip php7.0-opcache -y

# 安装 PHP5.6
sudo apt install php5.6-fpm php5.6-mysql php5.6-curl php5.6-gd php5.6-mbstring php5.6-mcrypt php5.6-xml php5.6-xmlrpc php5.6-zip php5.6-opcache -y
```

* nginx 代理使用不同版本的 php-fpm 即可

* 更多 PHP 扩展: `sudo apt-cache search php7.1`


### Ubuntu彻底删除 PHP7.0
* 一、删除php的相关包及配置: `sudo apt-get autoremove php7*`

* 二、删除关联 (谨慎, 这个有问题, 一不小心会删除 其它含 php 的文件): 
    * 建议先运行 `sudo find /etc -name "*php*"` 查看涉及的文件
    * `sudo find /etc -name "*php*" | xargs  rm -rf`

* 三、清除dept列表 (谨慎)
    * sudo apt purge `dpkg -l | grep php| awk '{print $2}' |tr "\n" " "`

* 四、检查是否卸载干净（无返回就是卸载完成）: `dpkg -l | grep php7.0`

* Tip: `dpkg -l` 列出所有已安装文件包
