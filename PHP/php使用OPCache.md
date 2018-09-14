## php 使用 OPCache
* 安装： `sudo apt install php7.0-opcache`

* php.ini 配置参考：
```ini
[opcache]
opcache.enable=1
;opcache.enable_cli=0
; 总Cache size MB大小
opcache.memory_consumption=256
; strings 占用的MB大小
opcache.interned_strings_buffer=32
; 最大用多少文件句柄
opcache.max_accelerated_files=20000
opcache.validate_timestamps=1
; Cache ttl 60s
opcache.revalidate_freq=60
opcache.fast_shutdown=1
opcache.enable_file_override=1
```

* NOTE: xdebug如果同opcache同时加载，opcache需要放在xdebug之前

* 效果报表: https://github.com/rlerdorf/opcache-status