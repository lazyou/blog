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
      * 环境： PHP >= 5.5.9， OpenSSL、PDO、Mbstring、Tokenizer 等PHP Extension。
      * Homestead环境： 或使用 [Laravel Homestead 虚拟机](https://laravel.com/docs/5.1/homestead)。
      * Composer全局安装： `composer global require "laravel/installer"， laravel new blog`。
      * Composer Create-Project安装 -- 推荐： composer create-project laravel/laravel blog "5.1.*"。
    * Configuration 配置：
      * 目录权限： `storage`、 `bootstrap/cache` 可写， `sudo chmod -R 777 storage`。
      * 应用key： `key:generate`设置到`.env`文件， 用于session等加密。
      * 可选配置：在`config/app.php`设置， 如`timezone`、`locale`
      * Apache、Nginx 配置。
      * 环境配置 -- [DotEnv](https://github.com/vlucas/phpdotenv)： 点配置文件切换开发、测试、生产的环境！配置项都在超全局变量 `$_ENV` 中， laravel中可用`env()`辅助方法获取。
      * 访问当前应用的环境： 可在 .env 文件的 APP_ENV 配置项得到；也可以使用 `$environment = App::environment();`获取。
      * Configuration Caching： `php artisan config:cache`生成的缓存文件用来快速的加载你的框架，不建议在开发环境中使用。
      * 配置项获取： `config('app.timezone', 'if null return');`