## 每天一个linux命令
* http://mp.weixin.qq.com/s?__biz=MzAxODI5ODMwOA==&mid=2666540459&idx=1&sn=301fc43baaea80e1512b4972d45677b2&chksm=80dce900b7ab60163db2f04e96a9f56ee1ab19e4c56c0d9189c89b9544c4e7eea7cef4bdac8c&mpshare=1&scene=23&srcid=0221T90FXpx9lTiIoig46tKQ#rd

## 目录
```
每天一个 Linux 命令（1）：ls 命令
每天一个 Linux 命令（2）：cd 命令
每天一个 Linux 命令（3）：pwd 命令
每天一个 Linux 命令（4）：mkdir 命令
每天一个 Linux 命令（5）：rm 命令
每天一个 Linux 命令（6）：rmdir 命令
每天一个 Linux 命令（7）：mv 命令
每天一个 Linux 命令（8）：cp 命令
每天一个 Linux 命令（9）：touch 命令
每天一个 Linux 命令（10）：cat 命令 
每天一个 Linux 命令（11）：nl 命令
每天一个 Linux 命令（12）：more 命令
每天一个 Linux 命令（13）：less 命令
每天一个 Linux 命令（14）：head 命令
每天一个 Linux 命令（15）：tail 命令
每天一个 Linux 命令（16）：which 命令
每天一个 Linux 命令（17）：whereis 命令
每天一个 Linux 命令（18）：locate 命令
每天一个 Linux 命令（19）：find 命令概览
每天一个 Linux 命令（20）：find 命令之 exec
每天一个 Linux 命令（21）：find 命令之 xargs
每天一个 Linux 命令（22）：find 命令的参数详解
每天一个 Linux 命令（23）：Linux 目录结构
每天一个 Linux 命令（24）：Linux 文件类型与扩展名
每天一个 Linux 命令（25）：Linux 文件属性详解
每天一个 Linux 命令（26）：用 SecureCRT 来上传和下载文件
每天一个 Linux 命令（27）：chmod 命令
每天一个 Linux 命令（28）：tar 命令
每天一个 Linux 命令（29）：chgrp 命令
每天一个 Linux 命令（30）：chown 命令
每天一个 Linux 命令（31）：/etc/group 文件详解
每天一个 Linux 命令（32）：gzip 命令
每天一个 Linux 命令（33）：df 命令
每天一个 Linux 命令（34）：du 命令
每天一个 Linux 命令（35）：ln 命令
每天一个 Linux 命令（36）：diff 命令
每天一个 Linux 命令（37）：date 命令
每天一个 Linux 命令（38）：cal 命令
每天一个 Linux 命令（39）：grep 命令
每天一个 Linux 命令（40）：wc 命令
每天一个 Linux 命令（41）：ps 命令
每天一个 Linux 命令（42）：kill 命令
每天一个 Linux 命令（43）：killall 命令
每天一个 Linux 命令（44）：top 命令
每天一个 Linux 命令（45）：free 命令
每天一个 Linux 命令（46）：vmstat 命令
每天一个 Linux 命令（47）：iostat 命令
每天一个 Linux 命令（48）：watch 命令
每天一个 Linux 命令（49）：at 命令
每天一个 Linux 命令（50）：crontab 命令
每天一个 Linux 命令（51）：lsof 命令
每天一个 Linux 命令（52）：ifconfig 命令
每天一个 Linux 命令（53）：route 命令
每天一个 Linux 命令（54）：ping 命令
每天一个 Linux 命令（55）：traceroute 命令
每天一个 Linux 命令（56）：netstat 命令
每天一个 Linux 命令（57）：ss 命令
每天一个 Linux 命令（58）：telnet 命令
每天一个 Linux 命令（59）：rcp 命令
每天一个 Linux 命令（60）：scp 命令
每天一个 Linux 命令（61）：wget 命令
```

### 1. ls
* ls 是 list 的缩写
* 格式: `ls [选项] [目录名]`
* 常用参数:
    * -a, –all 列出目录下的所有文件，包括以 . 开头的隐含文件
    * -A 同-a，但不列出“.”(表示当前目录)和“..”(表示当前目录的父目录)
    * -h, –human-readable 以容易理解的格式列出文件大小 (例如 1K 234M 2G)
    * -l 除了文件名之外，还将文件的权限、所有者、文件大小等信息详细列出来
    * -m 所有项目以逗号分隔，并填满整行行宽
    * -R, –recursive 同时列出所有子目录层
    * -r, –reverse 依相反次序排列
    * -t 以文件修改时间排序
    * -S 根据文件大小排序
    * -1 每行只列出一个文件
* 更多请通过 `ls --help` 查看
* 常用范例:
    * 例一：列出 /home/peidachang 文件夹下的所有文件和目录的详细资料: `ls -l -R /home/peidachang`
    * 例二：列出当前目录中所有以“t”开头的目录的详细内容，可以使用如下命令: `ls -l t*`
    * 例三：只列出文件下的子目录: `ls -F /opt/soft | grep /$`
    * 例四：列出目前工作目录下所有名称是s 开头的档案，愈新的排愈后面，可以使用如下命令: `ls -ltr s*`
    * 例六：计算当前目录下的文件数和目录数:
        * `ls -l * |grep "^-" | wc -l` -- 文件个数
        * `ls -l * |grep "^d" | wc -l` -- 目录个数
    * 例七: 在ls中列出文件的绝对路径: `ls | sed "s:^:$PWD/:"`
    * 例九：列出当前目录下的所有文件（包括隐藏文件）的绝对路径， 对目录不做递归: `find $PWD -maxdepth 1 | xargs ls -ld`


### 2. cd
* cd 是 Change Directory 的缩写
* 格式: `cd [目录名]`
* 常用范例:
    * 进入系统根目录: `cd /`
    * 进入当前目录的上级目录: `cd ..`
    * 进入当前用户主目录: `cd ~`
    * 返回进入此目录之前所在的目录: `cd -`
    * 把上个命令的参数作为cd参数使用: `cd !$`


### 3. pwd
* wpd 是 Print Working Directory 的缩写
* 格式: `pwd [选项]`
    * `pwd -P`: 显示出实际路径，而非使用连接（link）路径
* 功能: 查看 "当前工作目录" 的完整路径
