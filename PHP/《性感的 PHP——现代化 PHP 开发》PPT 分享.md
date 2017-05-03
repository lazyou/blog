### 简述
* 《性感的 PHP——现代化 PHP 开发》PPT 分享
* 重点： 
* https://laravel-china.org/topics/2933/sexy-php-modern-php-development-ppt-sharing
***



### 内容
* 详见文件： 性感的php--现代化高性能的php开发.pdf (https://oddgb63aa.qnssl.com/uploads/2016/08/modern-php.pdf)

#### 命名空间
* 命名空间的声明
* 命名空间的导入和别名
* 命名空间和自动加载的关系


#### PSR 规范
* PSR1      **基础编码规范**
* PSR2      **编程风格规范**
* PSR3      日志接口规范
* PSR4      **自动加载规范**
* PSR6      缓存接口规范
* PSR7      HTTP消息接口规范
注： PSR0 自动加载已废弃， PSR4取代。


#### 闭包和匿名函数
* 在PHP中，闭包和匿名函数是一个概念，**闭包就是匿名函数**
* **闭包**是指在创建时封装周围状态的函数，即使闭包所在的环境不存在了，闭包中封装的状态依旧存在。
* **匿名函数**其实就是没有名称的函数，匿名函数可以赋值给变量，还能像其他任何PHP函数对象那样传递。不过匿名函数仍是函数，因此可以调用，还可以传入参数，作为函数或方法测回调。之所以能调用变量是闭包函数实现了 `__invoke`魔术函数。


#### Trait
* `Trait`是 PHP5.4引入的新概念
* `Trait`是一种代码复用技术，为PHP的单继承限制提供了一套灵活的代码复用机制
* `Trait` 可以看作类的实现，可以混入一个或多个现有的PHP类中，其作用有两个：
    * 表明类可以做什么
    * 提供模块化实现


#### Composer包管理器
* 在composer.json定义依赖
* vendor目录方第三方组件，并生成自动加载机制
* vendor目录下的autoloader.oho文件，以及composer文件夹，里面定义了自动加载的映射
* 本质用过PHP的`spl_autoload_register`自动加载函数实现，按照composer定义的自动加载规范


#### 语法新特性


#### PHP7 性能


#### Laravel框架介绍
