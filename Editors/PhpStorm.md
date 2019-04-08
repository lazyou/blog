## 更多 tips
* https://phpstorm.tips/tips/

* tip 分享： https://laravel-china.org/topics/5279/lets-share-the-odd-tricks-of-phpstorm-to-improve-efficiency

* https://segmentfault.com/a/1190000015716373


## 常见问题:
* 不能选择php版本:
    * Settings -> Composer -> 取消勾选 Synchronize IDE Settings with composer.json

## 插件
* Translation

* PHP Advanced AutoComplete php 的高级自动补全

* PHP Toolbox php工具增强

* PHP Annotations php 注释增强工具

* Laravel Plugin laravel 框架支持


## phpstorm 快捷键
* 文件跳转: `Shift + Shift` (或者自定义 Search everywhere)


* 多光标选择器:
    * 选中关键词 + `Alt + J`
    * 撤销最后一个选中 `Shift + Alt + J`
    * Alt + 鼠标左击


* 快速定位当前文件项目所在 tree 位置:
    * http://phpstorm.tips/tips/3-scroll-to-file-in-project-panel
    * 在左侧的 Project 面板点中一个圈的图标('Scroll from Source')
    * 设置永久打开文件所在的 tree 位置 http://phpstorm.tips/tips/15-autoscroll-from-source


* 跳转到指定方法:
    * `Ctrl + F12`, 支持搜索


* 跳转到方法的声明处:
    * 在方法的引用处, `Ctrl + 点击该方法` 或者 `Ctrl + B`
    * 再次 `Ctrl + 声明方法` 跳回引用处
    * 在方法的声明处, `Ctrl + 点击该方法` 或者 `Ctrl + B` 可以选择被引用的地方并跳转过去


* 查看文档:
    * 光标在方法上, `Ctrl + Q` 弹出方法的文档 (多次 `Ctrl + Q` 会看到不同范围效果 `ESC` 关闭)
    * php 内置方法, `Shift + F1` 可快速跳转到官网


* 参数信息查看:
    * 光标在括号内, `Ctrl + P` 可查看此方法接收的参数信息


* 成对符号快速跳转:
    * 光标在某个符号边, `Ctrl + Shift + M` 可使光标快速跳转到与之匹配的另个符号边上
    * 支持 `{}`, `[]`, `()` and HTML tags


* 添加 / 删除 / 复制 行:
    * 向下添加一行 `Shift + Enter`
    * 向上添加一行 `Shift + Alt + Enter`
    * 复制当前行并粘贴 `Ctrl + D`
    * 删除当前行 `Ctrl + Y`


* 大小写转换:
    * 选中关键词, `Ctrl + Shift + U`


* 粘贴板历史:
    * `Cmd + Shift + V`


* 跳转到某个类:
    * `Ctrl + N` 输入类名, 支持完整的命名空间
    * 类名后面加上 `:11` 冒号行数就是跳转到指定类的指定行


* 神奇的 `Alt + Enter`:
    * 引号替换 / 转义
    * 数组声明转为短语法
    * 修正输入(拼写)错误
    * 方法 / 类生成注释 Docblock
    * 运算符两边快速调换位置


* 神奇的 `Alt + F1`
    * 文件管理器打开当前文件所在的位置


* 支持 Emmet 功能


* 重构 (重命名) 并快速替换引用处:
    * `Ctrl + Shift + Alt + T`
    * `Shift + F6`


* 选择扩展与收缩:
    * `Ctrl + W`
    * `Ctrl + Shift + W`


## IntelliJ IDEA 注册码
* http://idea.lanyus.com/

* 1. 搭建自己的IntelliJ IDEA授权服务器，教程在 http://blog.lanyus.com/archives/174.html

* 2. 注册码有效期为2017年10月15日至2018年10月14日, 使用前请将 `0.0.0.0 account.jetbrains.com` 添加到 hosts 文件中
