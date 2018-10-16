## MySql5.7 InnoDB全文索引（针对中文搜索）
* 作者：馬輝53541 
* 来源：CSDN 
* 原文：https://blog.csdn.net/qq_33663251/article/details/69612619?utm_source=copy 
* 版权声明：本文为博主原创文章，转载请附上博文链接！


### 1、ngram and MeCab full-text parser plugins
全文检索在MySQL里面很早就支持了，只不过一直以来只支持英文。缘由是他从来都使用空格来作为分词的分隔符，而对于中文来讲，显然用空格就不合适，需要针对中文语义进行分词。但 __从MySQL 5.7开始，MySQL内置了ngram全文检索插件，用来支持中文分词，并且对MyISAM和InnoDB引擎有效__。


### 2、必要的参数设置
* 在使用中文检索分词插件ngram之前，先得在MySQL配置文件里面设置他的分词大小（默认是2），比如，
```
[mysqld] 
ngram_token_size=2
```

* 分词的SIZE越小，索引的体积就越大，所以要根据自身情况来设置合适的大小


### 3、添加全文索引
```sql
alter table testtable add fulltext index testfulltext(clumn1,clumn2) with parser ngram; 

// 当然也可以在建表时
CREATE TABLE articles ( 
    id INTUNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, 
    title VARCHAR(200), 
    body TEXT, 
    FULLTEXT (title,body) WITH PARSER ngram 
) ENGINE=InnoDB CHARACTER SET utf8mb4;
```


### 4、查询索引
```sql
# 按自然语言搜索模式查询 
SELECT * FROM articles WHERE MATCH (title,body) AGAINST ('关键词' IN NATURAL LANGUAGE MODE);

# 按布尔全文搜索模式查询 
# 匹配既有管理又有数据库的记录 
SELECT * FROM articles WHERE MATCH (title,body) AGAINST ('+数据库 +管理' IN BOOLEAN MODE); 

# 匹配有数据库，但是没有管理的记录 
SELECT * FROM articles WHERE MATCH (title,body) AGAINST ('+数据库 -管理' IN BOOLEAN MODE); 

# 匹配MySQL，但是把数据库的相关性降低 
SELECT * FROM articles WHERE MATCH (title,body) AGAINST ('>数据库 +MySQL' INBOOLEAN MODE);
```


### TODO
* 需要更多量级的数据做测试
