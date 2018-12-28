## grep
* Linux系统中 `grep` 命令是一种强大的文本搜索工具，它能使用正则表达式搜索文本，并把匹 配的行打印出来。

* 首先谈一下grep命令的常用格式为：`grep [选项] "模式" [文件]`

* grep 家族总共有三个：grep，egrep，fgrep。

## grep 常用选项
`* `: 表示当前目录所有文件，也可以是某个文件名;
`-r`: 是递归查找;
`-n`: 是显示行号;
`-R`: 查找所有文件包含子目录;
`-i`: 忽略大小写;

## 有意思的命令行参数：
`grep -i pattern files` ：不区分大小写地搜索。默认情况区分大小写
`grep -l pattern files` ：只列出匹配的文件名,不列出路径
`grep -L pattern files` ：列出不匹配的文件名
`grep -w pattern files` ：只匹配整个单词，而不是字符串的一部分（如匹配‘magic’，而不是‘magical’）
`grep -C number pattern files` ：匹配的上下文分别显示[number]行
`grep pattern1 | pattern2 files` ：显示匹配 pattern1 或 pattern2 的行
`grep pattern1 files | grep pattern2` ：显示既匹配 pattern1 又匹配 pattern2 的行

## 有些用于搜索的特殊符号：
\< 和 \> 分别标注单词的开始与结尾。
例如：
`grep man *` 会匹配 ‘Batman’、‘manic’、‘man’等
`grep '\<man' *` 匹配‘manic’和‘man’，但不是‘Batman’
`grep '\<man\>'` 只匹配‘man’，而不是‘Batman’或‘manic’等其他的字符串。
`'^'`：指匹配的字符串在行首
`'$'`：指匹配的字符串在行尾

--------------------- 
作者：BabyFish13 
来源：CSDN 
原文：https://blog.csdn.net/BabyFish13/article/details/79709028 
版权声明：本文为博主原创文章，转载请附上博文链接！
