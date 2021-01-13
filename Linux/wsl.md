## wsl 安装
* 启用或关闭Windows功能 -> 用于Linux的Windows子系统 （没有的话需要先打开 “开发人员模式”）

* 微软应用商店搜索 Linux

* WSL 文件位置 `C:\Users\用户名\AppData\Local\Packages\CanonicalGroupLimited.Ubuntu18.04onWindows_79rhkp1fndgsc\LocalState\rootfs`



### vscode 的 wsl 插件连接失败: wslServer.sh: Permission denied
* 设置可执行权限即可
```sh
cd /mnt/c/Users/XXX/.vscode/extensions/ms-vscode-remote.remote-wsl-0.42.3/scripts
chmod +x *
```



## wsl 安装 nginx 遇到端口被占用
* 实际是被 window 系统下面的软件给占用了

* `netstat -aon | findstr 80` 根据 __进程编号__ 去 Windows的 "任务管理器 -> 详细信息" 查找占用端口的软件



## wsl 下文件权限问题
* 问题
    * wsl在mount windows系统到linux系统文件列表时候，所以权限都是777, laravel 项目在wsl环境下上传文件报错: `PHP chmod(): Operation not permitted`

* 解决
    * 参考: https://www.liangzl.com/get-article-detail-173911.html

    * `sudo vim /etc/wsl.conf` 添加如下配置
    ```sh
    [automount]
    enabled = true
    options = "metadata,umask=22,fmask=11"
    mountFsTab = false
    [filesystem]
    umask = 022
    ```

    * 然后更改项目权限: `sudo chown -R www-data:www-data laravel-mp`
    ```



### wsl 里Nginx+PHP，反映慢，卡住等问题
* https://www.jiloc.com/46901.html

* 在 `nginx.conf` 的 `http` 节点添加：`fastcgi_buffering off;` 后重启nginx



### 其他
* wsl 可安装桌面软件，然后使用Windows远程桌面连接进去
