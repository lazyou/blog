## PHP 标准规范
* https://github.com/php-fig

* https://psr.phphub.org/

* https://laravel-china.org/docs/psr

* PSR 是 PHP Standard Recommendations 的简写，由 PHP FIG 组织制定的 PHP 规范，是 PHP 开发的实践标准。


### PSR-1 基础编码规范
* https://laravel-china.org/docs/psr/basic-coding-standard/1605

* 概览：
    * 类的命名 必须 遵循 StudlyCaps 大写开头的驼峰命名规范；

    * 类中的常量所有字母都 必须 大写，单词间用下划线分隔；

    * 方法名称 必须 符合 camelCase 式的小写开头驼峰命名规范。


### PSR-2 编码风格规范
* https://laravel-china.org/docs/psr/psr-2-coding-style-guide/1606
    * NOTE: 需要经常阅读

* 概览：
    * 每个 `namespace` 命名空间声明语句和 `use` 声明语句块后面，必须 插入一个空白行。

    * 类的开始花括号（`{`） 必须 写在函数声明后自成一行，结束花括号（`}`）也 必须 写在函数主体后自成一行。

    * 方法的开始花括号（`{`） 必须 写在函数声明后自成一行，结束花括号（`}`）也 必须 写在函数主体后自成一行。

    * 控制结构的关键字后 必须 要有一个空格符，而调用方法或函数时则 一定不可 有。

    * 控制结构的开始花括号（`{`） 必须 写在声明的同一行，而结束花括号（`}`） 必须 写在主体后自成一行。


### PSR-4 自动加载规范
* 因 Composer 而来
