### 问题
* laravel 项目在wsl环境下上传文件报错: PHP chmod(): Operation not permitted

### 解决
* 参考: https://hughsite.com/post/chmod-chown-wsl-improvements.html

* `sudo vim /etc/wsl.conf` 添加如下配置
```sh
[automount]
enabled = true
options = "metadata,umask=22,fmask=11"
mountFsTab = false
```

* 然后更改项目权限: `sudo chown -R www-data:www-data laravel-mp/`
