### 资源目录
* 《LINUX与UNIX_SHELL编程指南》读书笔记.pdf
* Shell脚本学习指南.pdf
* 《LINUX与UNIX_SHELL编程指南》读书笔记.pdf
* Shell脚本学习指南.pdf
* 第01讲 走近SHELL脚本.wmv
* 第02讲 查找与替换.wmv
* 第03讲 文本处理.wmv
* 第04讲 SED与AWK.wmv
* 第05讲 使用管道 .wmv
* 第06讲 变量、判断与循环.wmv
* 第07讲 输入输出及命令执行.wmv
* 第08讲 文件处理 .wmv
* 第09讲 进程.wmv
* 第10讲 Bash陷阱.wmv
* 第11讲 脚本应用案例1.wmv
* 第12讲 脚本应用案例2.wmv


#### 第01讲 走近SHELL脚本
* Hello World
```sh
#!/bin/bash
echo Hello,World!
```

* 等差数列求和（TODO:代码有错，待fix）
```sh
#!/bin/bash
# do done 是 for 循环的作用域
sum=0

for((i=1; i<=100; i++))
do
    sum=$(expr $sum+$i);
done

echo $sum
```

* 脚本参数 0, 1, #
```sh
#!/bin/bash
# 执行 `sh run.sh` / `sh run.sh a` / `sh run.sh a b c`
echo $0
echo $1
echo $#
```

* shell 的组成
    * 命令与参数
        * shell能识别的命令有*内部命令 / Shell函数 / 外部命令(安装得来)*
        * 参数 `echo $0`代表脚本名， `echo $1`代表第一个脚本参数，`echo $#`代表脚本参数数量， `./test.sh abc xyz `
    * 变量
        * `a=1; echo $a` (等号两边没有空格，否则出错)
        * 数组： `arr[0]=1; arr[1]=abc; echo ${arr[0]};echo ${arr[@]};` (@符号打印数组所有的值)
        * 环境变量： `echo $PATH`, `env`查看所有环境变量
    * 输出（echo / printf）
        * echo 配合 `-e`参数表示对`\n \t \v`进行输出: `echo -e "\n$a"`(有变量使用双引号)
        * printf <格式化字符串> 变量值： `a=lin; printf "%s\tabc\n" $a`
        * printf 可定制各种格式（左对齐 / 右对齐等等）
    * 重定向（输出重定向 / 输入重定向 / 相关的特殊文件）
        * 覆盖写入 `echo abc > test.log`
        * 追加写入 `echo DEF >> test.log`
        * 输入重定向 `cat < test.log`
        * 管道 `cat test.log | wc -l` （统计文件行数）
        * 特殊文件 `/dev/null` 黑洞文件，重定向到这里不会打印内容 `cat test.log > /dev/null`
        * 特殊文件 `/dev/tty` 代表终端， `read a < /dev/tty`（从终端输入值到 a 变量， `echo $a` 查看输入内容）

* 脚本跟踪
    * 跟踪打印逻辑错误
    * 打开跟踪： 在脚本代码里加入 `set -x`
    * 关闭跟踪： 在脚本代码里加入 `set +x`


#### 第02讲 查找与替换
* 接收参数计算乘法（TODO: expr 什么意思？ $符号放在括号外面什么意思？）
```sh
#!/bin/bash
# 接收两个参数计算乘法 `./run.sh 2 3`
result=$(expr $1 \* $2)
echo "$1 x $2 = $result"
```

* grep 命令介绍
    * grep(使用Basic Regular Expression)
    * egrep(使用Extended Basic Regular Expression)
    * fregp(Fast, 不使用正则表达式，匹配固定字符串)

* POSIX 标准和 grep
    * POSIX 标准将上面的三个grep合成一个程序 **grep**

* grep 命令参数
    * -E        使用ERE
    * -F        使用固定字符串进行匹配
    * -i        忽略大小写差异
    * -l        列出匹配的文件名称
    * -v        显示不匹配的行

* grep 实例
```shell
lazyou@u:~$ cat /etc/passwd | grep root
root:x:0:0:root:/root:/usr/bin/zsh

lazyou@u:~$ grep root /etc/passwd 
root:x:0:0:root:/root:/usr/bin/zsh
```

* 什么是正则表达式(TODO:还是问wiki去)
```sh
lazyou@u:~$ grep r..t /etc/passwd
root:x:0:0:root:/root:/usr/bin/zsh
```

* Mate字符（正则表达式组成的基本元素，用以匹配复杂的内容）
```sh
字符      BRE/ERE     作用
\           both        关闭后继字符的特殊含义（转义）
.           both        匹配任意**单个**字符
*           both        匹配**0个**或**多个**字符
^           both        行首
$           both        行尾
[...]       both        匹配括号内任意字符

\{n,m\}     BRE         匹配字符重现次数
\(\)        BRE         将字符串存入“存储空间(括号内)”，可以用来后面的反义引用
\n          BRE         重现\(\)内的子模式（进行反义引用）
{n,m}       ERE         匹配字符重现次数
+           ERE         匹配一个或多个表达式
?           ERE         匹配另个或多个表达式
|           ERE         匹配 | 前或后的表达式
()          ERE         匹配正则表示群
```

```sh
匹配 a 开头的行
lazyou@u:~$ grep ^a /etc/passwd
avahi-autoipd:x:110:119:Avahi autoip daemon,,,:/var/lib/avahi-autoipd:/bin/false
avahi:x:111:120:Avahi mDNS daemon,,,:/var/run/avahi-daemon:/bin/false


`\1` 对括号内的内容**反义引用**（TODO:php里叫作反义引用对吗？）
lazyou@u:~$ grep "\(r..t\)..\1" /etc/passwd
root:x:0:0:root:/root:/usr/bin/zsh


lazyou@u:~$ grep -E "(root|lazyou|lin)" /etc/passwd
root:x:0:0:root:/root:/usr/bin/zsh
list:x:38:38:Mailing List Manager:/var/list:/usr/sbin/nologin
lazyou:x:1000:1000:lazyou,,,:/home/lazyou:/bin/bash
```

* POSIX方括号表达式（在方括号内匹配特殊的内容）
    * 字符集。 使用 [:keyword:] 将关键字组合起来，如 [:alnum:]
    * 排序符号。 使用 [.keyword.] 将关键字组合起来
    * 等价字符串集。 使用 [=keyword=] 将元素包含起来

```sh
[[:digit:]] 匹配含数字的行
lazyou@u:~$ grep [[:digit:]] /etc/passwd
root:x:0:0:root:/root:/usr/bin/zsh
daemon:x:1:1:daemon:/usr/sbin:/usr/sbin/nologin
```

* 正则表达式扩展
\w          匹配任何单词组成的字符串
\W          匹配任何非单词组成的字符串
\<\>        匹配单词
\b          匹配单词起始或结尾处的空白字符串
\B          匹配两个单词之间的空把字符串

```sh
匹配 zsh 这个单词
lazyou@u:~$ grep "\<zsh\>" /etc/passwd
root:x:0:0:root:/root:/usr/bin/zsh
```

* 使用 cut 截取字段
    * cut 参数
    -c <list>       截取范围内字符，例如 1， 3-5, 12
    -d <delimiter>  制定分割符
    -f <field>      指定域

```sh
冒号为分隔符，取分割后的1和3列
lazyou@u:~$ cut -d : -f 1,3 /etc/passwd
root:0
daemon:1
...
```

* 使用 jonin 联合字段
    * join 参数
    -j <field>      制定需要结合的字段
    -o <file.field> 输出文件file的field字段
    -t <separator>  制定分隔符
```sh
# -j 2 第二列作为结合字段（TODO:没说哪个文件的第二列？） 
# -t : 1.txt 2.txt 结合这两个文件
# -o 1.1 -o 1,2 输出第一个文件的第一列， 输出第一个文件的第二列
lazyou@u:~$ join -j 2 -t : 1.txt 2.txt -o 1.2 -o 1.1 -o 2.3
join: 1.txt:2: is not sorted: 19910101: chen: 女
 lin:19901116: 171
```

#### 第03讲 文本处理



#### 第04讲 SED与AWK



#### 第05讲 使用管道 



#### 第06讲 变量、判断与循环



#### 第07讲 输入输出及命令执行



#### 第08讲 文件处理 



#### 第09讲 进程



#### 第10讲 Bash陷阱



#### 第11讲 脚本应用案例1



#### 第12讲 脚本应用案例2


