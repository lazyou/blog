#### [Laravel 5.1 doc fast](https://laravel.com/docs/5.1/) : 


##### Prologue 序：
* https://laravel.com/docs/5.1/releases
  * Laravel 5.1 特性：
    * laravel的第一个LTS版本， 2年bugfixes、3年security fixes。
    * php 5.59+。
    * [PSR-2编码风格](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)。
    * Event Broadcasting： 事件广播。
    * Middleware Parameters： 中间件参数。
    * Testing Overhaul： 什么鬼。
    * Model Factories： Model工厂， 生成测试数据之类。
    * Artisan Improvements： Artisan升级。
    * Folder Structure： 目录结构变化 `app/Commands` 重命名为 `app/Jobs`。
    * Encryption： 加密方式， 以前版本laravel借助 php的`mcrypt`加码，laravel5.1开始借助`openssl`扩展（因为它维护更活跃）。 
    * API文档： [https://laravel.com/api/5.1/](https://laravel.com/api/5.1/)

##### Setup：
  * https://laravel.com/docs/5.1/installation
    * Installation 安装： 
      * 环境：PHP >= 5.5.9， OpenSSL、PDO、Mbstring、Tokenizer 等PHP Extension， 