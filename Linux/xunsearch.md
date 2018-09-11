## xunsearch
* xunsearch架构简图.png
    * ![xunsearch架构简图.png](xunsearch架构简图.png)

* 快速入门： http://www.xunsearch.com/download/xs_quickstart.pdf

* 安装： http://www.xunsearch.com/doc/php/guide/start.installation

* 体验 DEMO 项目: http://www.xunsearch.com/doc/php/guide/start.demo

* composer: https://github.com/hightman/xunsearch

* NOTE: 
    * 整体比较简单， 安装的时候最好在根目录下创建一个独立项目。

    * xunsearch 与 mysql 本质上是没有啥关联的，只是间接关联，实际上搜索的是 xunsearch 的索引，并没涉及 mysql


### 安装
```
+=================================================+
| Installation completed successfully, Thanks you |
| 安装成功，感谢选择和使用 xunsearch              |
+-------------------------------------------------+
| 说明和注意事项：                                |
| 1. 开启/重新开启 xunsearch 服务程序，命令如下： |
|    /etc/xunsearch/bin/xs-ctl.sh restart
|    强烈建议将此命令写入服务器开机脚本中         |
|                                                 |
| 2. 所有的索引数据将被保存在下面这个目录中：     |
|    /etc/xunsearch/data
|    如需要转移到其它目录，请使用软链接。         |
|                                                 |
| 3. 您现在就可以在我们提供的开发包(SDK)基础上    |
|    开发您自己的搜索了。                         |
|    目前只支持 PHP 语言，参见下面文档：          |
|    /etc/xunsearch/sdk/php/README
+=================================================+
```


### 快速创建索引
```
 17:22:03  lin@u  ...xunsearch/sdk/php 
$ util/Indexer.php --rebuild --source=mysql://root:password@localhost/laravel5 --sql="SELECT * FROM sentences" --project=sentences
开始重建索引 ...
初始化数据源 ... mysql://root:password@localhost/laravel5 
开始批量导入数据 (请直接输入数据) ...
报告：累计已处理数据 10000 条 ...
报告：累计已处理数据 20000 条 ...
报告：累计已处理数据 30000 条 ...
报告：累计已处理数据 40000 条 ...
报告：累计已处理数据 50000 条 ...
报告：累计已处理数据 60000 条 ...
报告：累计已处理数据 70000 条 ...
报告：累计已处理数据 80000 条 ...
报告：累计已处理数据 90000 条 ...
报告：累计已处理数据 100000 条 ...
报告：累计已处理数据 110000 条 ...
报告：累计已处理数据 120000 条 ...
报告：累计已处理数据 130000 条 ...
报告：累计已处理数据 140000 条 ...
完成索引导入：成功 144546 条，失败 0 条
完成重建索引 ...
```
