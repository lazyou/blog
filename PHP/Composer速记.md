## Composer 速记
* https://pkg.phpcomposer.com/

* Composer 包含两部分: 
    * https://getcomposer.org/ 
    * https://packagist.org/


* 入门指南: http://docs.phpcomposer.com/00-intro.html

* 中文文档: http://docs.phpcomposer.com/


### 安装 Composer
```sh
php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```


### 镜像用法
* https://developer.aliyun.com/composer

* 方法一： 修改 composer 的全局配置文件（推荐方式）
    * `composer config -g repo.packagist composer https://mirrors.aliyun.com/composer`

* 方法二： 修改当前项目的 composer.json 配置文件：
    * `composer config repo.packagist composer https://mirrors.aliyun.com/composer`

    * 会在当前项目中的 composer.json 文件的末尾自动添加镜像的配置信息:
    ```json
    "repositories": {
        "packagist": {
            "type": "composer",
            "url": "https://mirrors.aliyun.com/composer"
        }
    }
    ```

### 取消设置
`composer config -g --unset repos.packagist`


### 升级 Composer
* `composer self-update`


### 输出详细日志
* 如果你的问题涉及到执行 `composer` 命令，请在命令末尾添加 `-vvv` 参数输出详细日志
```sh
composer install -vvv
composer update -vvv
```


### 5 个 Composer 小技巧
* https://www.phpcomposer.com/5-features-to-know-about-composer-php/

* 1.仅更新单个库: 
    * `composer update xxx/xxx`
    * `composer update nothing` || `composer update --lock`: 这样一来，Composer不会更新库，但是会更新 `composer.lock`

* 2. 不编辑 `composer.json` 的情况下安装库:
    * `composer require "foo/bar:1.0.0"`

* 3. `create-project` 自动克隆仓库，并检出指定的版本:
    * `composer create-project doctrine/orm path 2.2.0`

* 4. 考虑缓存，dist包优先
    * 最近一年以来的 Composer 会自动存档你下载的 `dist` 包
    * composer 缓存所在目录: `cd ~/.composer/cache/` (是一个个 zip 压缩包)
    * `--profile` 选项来显示执行时间: `composer install/update --profile`

* 5. 若要修改，源代码优先
    * 使用 `--prefer-source` 来强制选择克隆源代码: `composer update symfony/yaml --prefer-source`

* 为生产环境作准备:
    * 优化一下自动加载: `composer dump-autoload --optimize`


### Composer Cheat Sheet for developers
* http://composer.json.jolicode.com/


### composer install 出现 proc_open(): fork failed - Cannot allocate memory 的错误
```sh
/bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
/sbin/mkswap /var/swap.1
/sbin/swapon /var/swap.1

# 第一行：创建一个 1G 大小的文件
# 第二行：格式化该文件
# 第三行：将该文件挂载至文件系统中。
# 效果，内存大了一些
```
