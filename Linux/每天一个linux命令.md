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


### 10. cat
* cat 是 catenate 的缩写
* 格式: `cat [OPTION]... [FILE]...`
* cat主要有三大功能：
    1. 一次显示整个文件: `cat filename`
    2. 从键盘创建一个文件: `cat > filename` 只能创建新文件,不能编辑已有文件
    3. 将几个文件合并为一个文件: `cat file1 file2 > file`
* 参数:
    * -b, --number-nonblank    对非空输出行编号
    * -E, --show-ends          在每行结束处显示 $
    * -n, --number     对输出的所有行编号,由1开始对所有输出的行数编号
    * -s, --squeeze-blank  有连续两行以上的空白行，就代换为一行的空白行 


### 11. nl
* nl 是 Number of Lines 的缩写
* 将每个文件写入标准输出，并添加行号
* 格式: `nl [选项]... [文件]...`
* 常用参数:
    * -b  ：指定行号指定的方式，主要有两种:
        * -b a ：表示不论是否为空行，也同样列出行号(类似 cat -n)
        * -b t ：如果有空行，空的那一行不要列出行号(默认值)


### 12. more
* 功能: more命令和cat的功能一样都是查看文件里的内容，但有所不同的是more可以按页来查看文件的内容，还支持直接跳转行等功能
* 命令: `more [options] <file>...`
* 常用参数:
    * +n      从笫 n 行开始显示
    * -n       定义屏幕大小为 n 行
    * -s       把连续的多个空行显示为一行
    * -u       把文件内容中的下画线去掉
* 常用操作:
    * Enter    向下n行，需要定义。默认为1行
    * Ctrl+F   向下滚动一屏
    * 空格键  向下滚动一屏
    * Ctrl+B  返回上一屏
    * =       输出当前行的行号
    * :f     输出文件名和当前行的行号
    * V      调用vi编辑器
    * !命令   调用Shell，并执行命令 
    * q       退出more


### 13. less
* 功能: less 工具也是对文件或其它输出进行分页显示的工具，应该说是linux正统查看文件内容的工具，功能极其强大。less 的用法比起 more 更加的有弹性。
    > 在 more 的时候，我们并没有办法向前面翻， 只能往后面看，但若使用了 less 时，就可以使用 [pageup] [pagedown] 等按键的功能来往前往后翻看文件，更容易用来查看一个文件的内容！除此之外，在 less 里头可以拥有更多的搜索功能，不止可以向下搜，也可以向上搜。
* TODO: 所以抛弃 more 记住 less 即可
* 命令: `less [参数]  文件`
* 常用参数:
    * -e  当文件显示结束后，自动离开
    * -f  强迫打开特殊文件，例如外围设备代号、目录和二进制文件
    * -m  显示类似more命令的百分比
    * -N  显示每行的行号
    * -o <文件名> 将less 输出的内容在指定文件中保存起来
    * -s  显示连续空行为一行
    * /字符串：向下搜索“字符串”的功能
    * ?字符串：向上搜索“字符串”的功能
    * n：重复前一个搜索（与 / 或 ? 有关）
    * N：反向重复前一个搜索（与 / 或 ? 有关）
    * h  显示帮助界面
    * Q  退出less 命令
    * u  向前滚动半页
    * y  向前滚动一行
    * 空格键 滚动一行
    * 回车键 滚动一页
    * [pagedown]： 向下翻动一页
    * [pageup]：   向上翻动一页
* 常用实例:
    * `history | less`


### 14. head
* 功能: head 与 tail 就像它的名字一样的浅显易懂，它是用来显示开头或结尾某个数量的文字区块，head 用来显示档案的开头至标准输出中，而 tail 想当然尔就是看档案的结尾。
* 格式: `head [选项]... [文件]...`
* 参数:
    * -n<行数> 显示的行数
    * -c<字节> 显示字节数
* 常用实例:
    * 输出文件除了最后n行的全部内容: `head -n -6 log2014.log`


### 15. tail
* 功能: tail 命令从指定点开始将文件写到标准输出.使用tail命令的-f选项可以方便的查阅正在改变的日志文件,`tail -f filename` 会把 filename 里最尾部的内容显示在屏幕上,并且不但刷新,使你 _看到最新的文件内容_. 
* 格式: `tail [选项]... [文件]...`
* 参数:
    * -f 循环读取
    * -s, --sleep-interval=S 与-f合用,表示在每次反复的间隔休眠S秒 
    * -n<行数> 显示行数
    * -c<数目> 显示的字节数


### 16. which
* 功能: 查看可执行文件的位置; which指令会在PATH变量指定的路径中，搜索某个系统命令的位置，并且返回第一个搜索结果
* 格式: `which 可执行文件名称`
* 示例:
    * `which php`
    * `which cd`


### 17. whereis
* 功能: whereis 命令是定位可执行文件、源代码文件、帮助文件在文件系统中的位置。这些文件的属性应属于原始代码，二进制文件，或是帮助文件。whereis 程序还具有搜索源代码、指定备用搜索路径和搜索不寻常项的能力。
    * 和 find 相比，whereis 查找的速度非常快，这是因为 linux 系统会将 系统内的所有文件都记录在一个数据库文件中，当使用 whereis 和下面即将介绍的 locate 时，会从数据库中查找数据，而不是像 find 命令那样，通过遍历硬盘来查找，效率自然会很高

    * 但是该数据库文件并不是实时更新，默认情况下时一星期更新一次，因此，我们在用 whereis 和 locate 查找文件时，有时会找到已经被删除的数据，或者刚刚建立文件，却无法查找到，原因就是因为数据库文件没有被更新
* 格式: `whereis [options] [-BMS <dir>... -f] <name>`
* 参数:
    * -m   定位帮助文件。
    * -b   定位可执行文件。
    * -S   指定搜索源代码文件的路径。


### 18. locate
* 功能: locate命令可以在搜寻数据库时快速找到档案，数据库由updatedb程序来更新，updatedb是由cron daemon周期性建立的，locate命令在搜寻数据库时比由整个由硬盘资料来搜寻资料来得快，但较差劲的是locate所找到的档案若是最近才建立或 刚更名的，可能会找不到，在内定值中，updatedb每天会跑一次，可以由修改crontab来更新设定值。
* 格式: `locate [OPTION]... [PATTERN]...`
* 参数:
    * -e   将排除在寻找的范围之外
    * -n 至多显示 n个输出
    * -o 指定资料库存的名称
    * -d 指定资料库的路径
* 范例:
    * 查找和pwd相关的所有文件: `locate pwd`
    * 搜索etc目录下所有以sh开头的文件: `locate /etc/sh`


### 19. find
* 功能: 用于在文件树种查找文件，并作出相应的处理
* 格式: 
    * `find pathname -options [-print -exec -ok ...]`
    * `find [-H] [-L] [-P] [-Olevel] [-D help|tree|search|stat|rates|opt|exec|time] [path...] [expression]`
* 命令参数：
    * pathname: find命令所查找的目录路径。例如用.来表示当前目录，用/来表示系统根目录。
    * -print： find命令将匹配的文件输出到标准输出。
    * -exec： find命令对匹配的文件执行该参数所给出的shell命令。相应命令的形式为'command' {  } ;，注意{   }和；之间的空格。
    * -ok： 和-exec的作用相同，只不过以一种更为安全的模式来执行该参数所给出的shell命令，在执行每一个命令之前，都会给出提示，让用户来确定是否执行。
* 命令选项：
    * -name   按照文件名查找文件。
    * -perm   按照文件权限来查找文件。
    * -prune  使用这一选项可以使find命令不在当前指定的目录中查找，如果同时使用-depth选项，那么-prune将被find命令忽略。
    * -user   按照文件属主来查找文件。
    * -group  按照文件所属的组来查找文件。
    * -mtime -n +n  按照文件的更改时间来查找文件， - n表示文件更改时间距现在n天以内，+ n表示文件更改时间距现在n天以前。find命令还有-atime和-ctime 选项，但它们都和-m time选项。
    * -type  查找某一类型的文件，诸如：
        * b - 块设备文件。
        * d - 目录。
        * c - 字符设备文件。
        * p - 管道文件。
        * l - 符号链接文件。
        * f - 普通文件。
    * -size n：[c] 查找文件长度为n块的文件，带有c时表示文件长度以字节计。-depth：在查找文件时，首先查找当前目录中的文件，然后再在其子目录中查找。
* 范例:
    * 查找指定时间内修改过的文件: `find -atime -2`
    * 根据关键字查找: `find . -name "*.log"`
    * 按照目录或文件的权限来查找文件: `find /opt/soft/test/ -perm 777`
    * 按类型查找: `find . -type f -name "*.log"`
    * 查找当前所有目录并排序: `find . -type d | sort`
    * 按大小查找文件: `find . -size +1000c -print`


### 20. find命令之exec
* TODO: 略, 貌似没啥用, 先知道一下

* 在目录中查找更改时间在n日以前的文件并删除它们，在删除之前先给出提示: 
    * `find . -name "*.log" -mtime +5 -ok rm {} \;`

* -exec中使用grep命令:
    * `find /etc -name "passwd*" -exec grep "root" {} \;`

* 查找文件移动到指定目录:
    * `find . -name "*.log" -exec mv {} .. \;`

* 用exec选项执行cp命令:
    * `find . -name "*.log" -exec cp {} test3 \;`


### 21. find命令之xargs
* TODO: 略, 貌似没啥用, 先知道一下


### 22. find 命令的参数详解
* 1．使用name选项: 文件名字模式
    * find ~ -name "*.log" -print 
    * find . -name "[A-Z]*" -print  
    * find . -name "[a-z]*[4-9].log" -print

* 2．用perm选项: 文件权限模式
    * `find . -perm 755 -print`

* 3．用prune选项: 忽略某个目录
    * `find test -path "test/test3" -prune -o -print`

* 5．使用user和nouser选项：
    * `find ~ -user peida -print`
    * `find /home -nouser -print`

* 6．使用group和nogroup选项:

* 7．按照更改时间或访问时间等查找文件：mtime, atime, ctime 选项
    * 查找更改时间在5日以内的文件: `find / -mtime -5 -print`

* 9．使用type选项：
    * 查找目录类型: `find /etc -type d -print `
    * 目录以外的类型: `find . ! -type d -print`

* 10．使用size选项：
    * 查找文件大于1 M字节的: `find . -size +1000000c -print`
