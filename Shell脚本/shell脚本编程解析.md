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


