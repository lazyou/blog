## git submodule 介绍
* https://git-scm.com/book/zh/v2/Git-%E5%B7%A5%E5%85%B7-%E5%AD%90%E6%A8%A1%E5%9D%97

* 某个工作中的项目需要包含并使用另一个项目。 也许是第三方库，或者你独立开发的，用于多个父项目的库。 现在问题来了：你想要把它们当做两个独立的项目，同时又想在一个项目中使用另一个。

* 常用命令:
```
// 会生成新文件 .gitmodules
git submodule add https://github.com/chaconinc/DbConnector

git submodule update [submodule-path]
```
