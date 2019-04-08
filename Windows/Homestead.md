## Homestead 开发环境搭建
* https://laravelacademy.org/post/7658.html

### 准备软件
* Git
* Virtual Box
* Vagrant: https://www.vagrantup.com/downloads.html
* Vagrant Box: 
	* 最好是下载现成的 box 镜像（网盘）
	* TODO: 地址补充

### Virtual Box 重要设置:
* 全局设定 -> 常规 -> 默认虚拟电脑位置 (放到盘大的地方)

### 常规操作
* 安装软件： Git，Virtual Box， Vagrant

* `vagrant box add laravel/homestead` 或者 `vagrant box add laravel/homestead ~/Downloads/virtualbox.box`

* 密钥生成：
```
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
eval "$(ssh-agent -s)"
ssh-add -K ~/.ssh/id_rsa
```

* 安装 Homestead： `git clone https://github.com/laravel/homestead.git Homestead`
```
cd Homestead

// Mac/Linux...
bash init.sh

// Windows...
init.bat
```
# 分配 vagrant 内存小一点，默认 2048
memory: 1024

* 配置 Homestead: Homestead.yaml 文件
```

# 代码目录从本机 D:/Codes 映射到 vagrant 的 /home/vagrant/Code 下
folders:
    - map: D:/Codes
      to: /home/vagrant/Code
```


### 扩展配置
* 关于下载的 box 文件版本， 在 Homestead 项目也要切换到对应的 tag (`git checkout -b v6.1.0`)。

* metadata.json 的使用： https://segmentfault.com/q/1010000004674663/a-1020000005971805
```
# metadata.json 内容如下
{
    "name": "laravel/homestead",
    "versions": 
    [
        {
            "version": "0.5.0",
            "providers": [
                {
                  "name": "virtualbox",
                  "url": "virtualbox.box"
                }
            ]
        }
    ]
}

# 将 virtualbox.box 放在 metadata.json 一起，然后执行 `vagrant box add metadata.json`
```

* __把 `.vagrant.d` 移出系统盘__: https://blog.csdn.net/MisshqZzz/article/details/79468637
```
使用vagrant up启动虚拟机的时候，打包的虚拟机会保存在.vagrant.d/boxes目录下，这个文件夹默认是存放在系统盘上的 C:/Users/Admin 目录下的，如果box文件非常多的话，会给系统盘造成很大的压力，所以我们可以把 .vagrant.d 文件夹移到别的盘。

1、将 .vagrant.d 文件夹剪切到别的盘，比如 d:/software/vagrant/.vagrant.d

2、设置环境变量 VAGRANT_HOME 为 d:/software/vagrant/.vagrant.d

3、在 path 环境变量下添加 %VAGRANT_HOME%

这样，我们以后vagrant up的时候，box文件就生成在D盘了

* TODO: 环境变量设置完重启 cmd.exe 进行 “常规操作”，环境变量的设置并不在 Git Shell 内生效 
```

* 错误消息: The box 'laravel/homestead' is not a versioned box...
    * 进入 `C:\Users\Administrator\.vagrant.d\boxes\laravel-VAGRANTSLASH-homestead` 创建文件 `metadata_url`，写入以下内容： `https://vagrantcloud.com/laravel/boxes/homestead/`

* 解决 Windows 系统使用 Homestead 运行 Laravel 本地项目响应缓慢问题
    * https://learnku.com/articles/9009/solve-the-slow-response-problem-of-windows-system-using-homestead-to-run-laravel-local-project

    * 配置
    ```
    cd ~/Homestead
    vagrant plugin install vagrant-winnfsd

    # 配置修改: homestead/scripts/homestead.rb
    # Register All Of The Configured Shared Folders
    if settings.include? 'folders'
        settings["folders"].sort! { |a,b| a["map"].length <=> b["map"].length }

        settings["folders"].each do |folder|
            config.vm.synced_folder folder["map"], folder["to"], 
            id: folder["map"],
            :nfs => true,
            :mount_options => ['nolock,vers=3,udp,noatime']
        end
    end    
    ```

### 使用 redis
```
# redis 配置修改
vagrant ssh
sudo vim /etc/redis/redis.conf
修改 bind 地址为 0.0.0.0 // 仅仅注释掉是无效的

# 修改 Homestead.yaml 进行端口映射
ports:
    - send: 63790
      to: 6379

# 重启 vagrant
```

### Vagrant 常用命令
```
vargrant up
vargrant halt
vargrant ssh
vargrant box list
```
