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
* 功能: 查看 "当前工作目录" 的完整路径
* 格式: `pwd [选项]`
    * `pwd -P`: 显示出实际路径，而非使用连接（link）路径


### 4. mkdir
* mkdir 是 Make Directory 的缩写
* 功能: 用来创建指定的名称的目录，要求创建目录的用户在当前目录中具有写权限
    * 同一个目录下不能有同名的(区分大小写)
* 格式: `mkdir [选项] 目录…`
* 常用参数:
    * -m, --mode=模式，设定权限<模式> (类似 chmod)，而不是 rwxrwxrwx 减 umask
    * -p, --parents  可以是一个路径名称。此时若路径中的某些目录尚不存在,加上此选项后,系统将自动建立好那些尚不存在的目录,即一次可以建立多个目录
    * -v, --verbose  每次创建新目录都显示信息
* 常用范例:
    * 递归创建多个目录: `mkdir -p test2/test22`
    * 创建权限为777的目录: `mkdir -m 777 test3`


### 5. rm
* rm 是 remove 的缩写
* 功能: 删除一个目录中的一个或多个文件或目录，如果没有使用 `-r` 选项，则 rm 不会删除目录。如果使用 rm 来删除文件，通常仍可以将该 __文件恢复__ 原状
* 格式: `rm [OPTION]... [FILE]...`
* 常用参数:
    * -f, --force    忽略不存在的文件，从不给出提示
    * -i, --interactive 进行交互式删除
    * -r, -R, --recursive   指示rm将参数中列出的全部目录和子目录均递归地删除
* 常用范例:
    * 删除任何.log文件；删除前逐一询问确认: `rm -i *.log`
    * 将 test1子目录及子目录中所有档案删除: `rm -r test1`
    * 自定义 __回收站__ 功能: 
        ```sh
        myrm(){ D=/tmp/$(date +%Y%m%d%H%M%S); mkdir -p $D;  mv "$@" $D && echo "moved to $D ok"; }
        alias rm='myrm'
        touch 1.log 2.log 3.log
        rm [123].log # 会有提醒
        ```


### 6. rmdir
* rmdir 是  Remove Directory 的缩写
* 功能: 该命令的功能是删除空目录，一个目录被删除之前必须是空的。（注意，`rm –r dir` 命令可代替 rmdir，但是有很大危险性。）
* 格式: `rmdir [OPTION]... DIRECTORY...`
* 参数:
    * -p 递归删除目录 dirname，当子目录删除后其父目录为空时，也一同被删除。如果整个路径被删除或者由于某种原因保留部分路径，则系统在标准输出上显示相应的信息。
    * -v, --verbose  显示指令执行过程


### 7. mv
* mv 命令是 move 的缩写，可以用来移动文件或者将文件 __改名__（move (rename) files）
* 格式:
    ```sh
    mv [OPTION]... [-T] SOURCE DEST
    mv [OPTION]... SOURCE... DIRECTORY
    mv [OPTION]... -t DIRECTORY SOURCE...
    ```
* 常用参数:
    * -b ：若需覆盖文件，则覆盖前先行备份
    * -f ：force 强制的意思，如果目标文件已经存在，不会询问而直接覆盖
    * -i ：若目标文件 (destination) 已经存在时，就会询问是否覆盖
    * -u ：若目标文件已经存在，且 source 比较新，才会更新(update)
    * -t ： –target-directory=DIRECTORY move all SOURCE arguments into DIRECTORY，即指定 mv 的目标目录，该选项适用于移动多个源文件到一个目录的情况，此时目标目录在前，源文件在后
* 常用范例:
    * 文件改名: `mv test.log test1.txt`
    * 移动多个文件: 
        * `mv log1.txt log2.txt log3.txt test3` 
        * `mv -t /opt/soft/test/test4/ log1.txt log2.txt  log3.txt`
    * 目录的移动: `mv dir1 dir2` 并没有要求目录为空才能执行
    * 将文件file1改名为file2，如果file2已经存在，则询问是否覆盖: `mv -i log1.txt log2.txt`
    * 将文件file1改名为file2，即使file2存在，也是直接覆盖掉: `mv -f log3.txt log2.txt`
    * 移动当前文件夹下的所有文件到上一级目录: `mv * ../`


### 8. cp
* cp 是 copy 是缩写, 用来复制文件或者目录
    * shell会设置一个别名，在命令行下复制文件时，如果目标文件已经存在，就会询问是否覆盖，不管你是否使用-i参数
    * 但是如果是在shell脚本中执行cp时，没有-i参数时不会询问是否覆盖
* 格式:
    ```
    Usage: cp [OPTION]... [-T] SOURCE DEST
    or:  cp [OPTION]... SOURCE... DIRECTORY
    or:  cp [OPTION]... -t DIRECTORY SOURCE...
    Copy SOURCE to DEST, or multiple SOURCE(s) to DIRECTORY.
    ```
* 常用参数:
    * –backup[=CONTROL    为每个已存在的目标文件创建备份
    * -b                类似–backup 但不接受参数
    * –copy-contents        在递归处理是复制特殊文件内容
    * -f, –force        如果目标文件无法打开则将其移除并重试(当 -n 选项存在时则不需再选此项)
    * -i, –interactive        覆盖前询问(使前面的 -n 选项失效)
    * -H                跟随源文件中的命令行符号链接
    * -l, –link            链接文件而不复制


### 9. touch
* 功能: 一般在使用 make 的时候可能会用到，用来 __修改文件时间戳__，或者新建一个不存在的文件
* 常用参数:
    * -a   或--time=atime或--time=access或--time=use 　只更改存取时间
    * -d 　使用指定的日期时间，而非现在的时间。 
    * -m   或--time=mtime或--time=modify 　只更改变动时间。
    * -t 　使用指定的日期时间，而非现在的时间。
