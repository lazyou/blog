## 介绍
* PsySH是一个PHP的运行时开发平台，交互式调试器和 Read-Eval-Print Loop (REPL)。

* http://psysh.org/

* http://psysh.org/#docs

* 参考：
    * http://vergil.cn/archives/psysh

* tip: `php -a` 也能进去 php 的控制台


## 安装
```sh
composer global require psy/psysh:@stable

export PATH="/home/lin/.config/composer/vendor/bin:$PATH"

sudo apt install php-sqlite3

# 文档, 重启 psysh
mkdir -p ~/.local/share/psysh/
wget -O \
    ~/.local/share/psysh/php_manual.sqlite http://psysh.org/manual/en/php_manual.sqlite


# 查看手册
help

# 查看文档
doc in_array
```


## 使用
* 更多使用参考
    * https://github.com/bobthecow/psysh/wiki
    
    * http://vergil.cn/archives/psysh

* 可以在 psysh 中 `require` php 脚本，然后调用 show doc 等等

## 扩展
