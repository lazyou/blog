## Ubuntu 14.04下搭建SVN服务器（SVN Server）
* https://www.linuxidc.com/Linux/2016-08/133961.htm

### 安装 svn
* `sudo apt-get install subversion`

* `svn help`            //--svn帮助
* `svn --version`       //--svn版本
* `svnserve --version`  //--svn server版本


### 创建SVN版本库
```shell
sudo mkdir /home/svn
sudo mkdir /home/svn/repository
sudo chmod -R 777 /home/svn/repository
sudo svnadmin create /home/svn/repository
sudo chmod -R 777 db /home/svn/repository/conf
```


### 设置访问权限
* 修改配置:
    ```sh
    sudo vim /home/svn/repository/conf/svnserve.conf

    移除注释:
    anon-access = read
    auth-access = write

    password-db = passwd
    ```

* 添加用户, 设置用户组和用户组权限:
    * 添加用户: `sudo vim /home/svn/repository/conf/passwd `

    * 设置用户组和权限: `sudo vim /home/svn/repository/conf/authz`

* example:
    ```
    admin = wang //用户王属于admin权限组
    @admin = rw //admin权限组的权限是读和写
    * = r 所有的组都具有读权限
    ```


### SVN 服务器启动关闭
* 启动: `svnserve -d -r /home/svn/`

* 停止: `killall svnserve`

* 查看: `ps aux | grep svnserve`


### 客户端访问SVN服务器
* 下载 TortoiseSVN 客户端


## 扩展知识

### 客户端svn上传后，原始文件在服务器的什么位置
* https://blog.csdn.net/qq_29945729/article/details/52936900
```
SVN服务器端不是简单将上传的文件一个一个存放起来的；

SVN服务器端默认采用的 `FSFS` 格式是将每次 commit 的内容增量方式存放的，每个增量包存成1个文件，这个增量包中包括了这次 commit 的 __全部数据__。

也就是说你不可能在服务器端存放该版本库的文件夹下找到你上传的某个文件。

SVN服务器版本库有两种格式,
    一种为 `FSFS`,
    一种为 `BDB`

把文件上传到 SVN 版本库后, 上传的文件不再以文件原来的格式存储, 而是被 svn 以它自定义的格式压缩成版本库数据,存放在版本库中。

如果是 FSFS 格式，这些数据存放在版本库的db目录中，里面的 revs 和 revprops 分别存放着每次提交的差异数据和日志等信息。


怎把指定文件夹上传到SVN服务器？
    一般来说新建项目是在服务器端操作的，每个项目作为一个独立的版本库进行管理。
    
    当然你可以可以把这个项目当作服务器上某个版本库下面的一个文件夹进行管理，但是会导致这个项目的版本号看起来是不连续的，因为SVN是用版本号标注整个版本库的状态。

    你如果确定想把这个项目当成某个版本库的一个文件夹进行管理的话，那么就这么做：
        首先，用 TSVN 检出那个版本库到本地；
        然后，将这个项目复制到本地这个版本库的某个文件夹下面；
        最后，用 TSVN 增加并提交这个文件夹。

SVN 在服务器端的存储方式和客户端是不一样的，所以在服务器端是看不到源文件的。服务器端有两种存储方式 FSFS 和 BDB，目前默认都是 FSFS。

要导入文件有两种做法：
1、用 import 指令，将客户端文件夹导入到服务器端
2、先 checkout 空库到客户端，然后将要导入的文件夹放入客户端 checkout 产生的空文件夹，然后执行 add 将这些文件夹纳入 SVN 控制，最后执行 commit 上传到服务器
```
