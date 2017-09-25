
直接百度百科的内容：
http://baike.baidu.com/view/5016366.htm


#### 什么是mod_rewrite
* mod_rewrite 是Apache的一个模块，是一个严格的Apache配置文件


#### mod_rewrite 的作用
* mod_rewrite 模块包括很多工作，其中SEO人员最常用的就是在网站编辑时声明规则，被Apache实时地将访问者请求的静态URL地址映射为 动态查询字符串，并发送给不同的PHP脚本处理。从搜索引擎蜘蛛的角度看来，这些URL地址是静态的。就是平时我们说的动态网站静态化。


#### 安装mod_rewrite
* 一般在安装Apache时已经包含了 mod_rewrite 模块

* 确认mod_rewrite是否安装
    * 在Apache的安装目录的modules文件夹下查找一个文件 mod_rewrite,如果找到的话就是已经安装了。


#### 启动mod_rewrite
* 一般 mod_rewrite 默认是不启动的，这时我们需要手动启用它。
打开Apache的配置文件“httpd.conf”，打开该文件，添加（最好添加在文本最后面）代码如下：
```
LoadModulerewrite_module modules/mod_rewrite.so
<Directory />
    Options FollowSymLinks
    #AllowOverride None
    AllowOverride All
</Directory>
```
重启 apache 服务即可。
