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
