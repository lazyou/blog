## php性能分析工具xdebug
* https://zhuanlan.zhihu.com/p/26615449

* http://yzone.net/blog/151

* `sudo apt install php-xdebug`

* php.ini 添加配置：
```
[xdebug]
# xdebug.profiler_enable=0
# 默认值是0，如果设为1 则当我们的请求中包含 XDEBUG_PROFILE 参数时才会生成性能报告文件
xdebug.profiler_enable_trigger=1

# 分析文件保存目录， 默认是 /var/tmp
xdebug.profiler_output_dir="/var/www/xdebug_logs"
```


### 使用
* way 1
```conf
# 访问 连接带参数 ?XDEBUG_PROFILE 才会进行性能分析
http://xxx/test?XDEBUG_PROFILE


# 日志生成在 /var/www/xdebug_logs
cachegrind.out.22338

# 分析查看工具1: kcachegrind
sudo apt-get install kcachegrind
# `kcachegrind cachegrind.out.22338 `

# 分析查看工具2: webgrind -- https://github.com/jokkedk/webgrind
需要配合工具 graphviz -- `sudo apt install graphviz`
```
