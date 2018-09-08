### MySQL 索引
* http://www.runoob.com/mysql/mysql-index.html

* 索引分 **单列索引** 和 **组合索引**。
    * 单列索引，即一个索引只包含单个列，一个表可以有多个单列索引，*但这不是组合索引*。
    * 组合索引，即一个索引包含多个列。

* 虽然索引大大提高了查询速度，同时却会降低更新表的速度，如对表进行INSERT、UPDATE和DELETE。
    * 因为更新表时，MySQL不仅要保存数据，还要保存一下索引文件。

* 1. 普通索引
    * 最基本的索引，它没有任何限制

* 2. 唯一索引
    * 索引列的值必须唯一，但允许有空值
    * 如果是组合索引，则列值的 *组合必须唯一*

* 3. 全文索引?


* 使用ALTER 命令添加和删除索引
    * 主键索引: `ALTER TABLE tbl_name ADD PRIMARY KEY (column_list)`: 该语句添加一个主键，这意味着索引值必须是唯一的，且不能为 NULL。

    * 唯一索引: `ALTER TABLE tbl_name ADD UNIQUE index_name (column_list)`: 这条语句创建索引的值必须是唯一的（除了NULL外，NULL可能会出现多次）。

    * 普通索引: `ALTER TABLE tbl_name ADD INDEX index_name (column_list)`: 添加普通索引，索引值可出现多次。

    * 全文索引: `ALTER TABLE tbl_name ADD FULLTEXT index_name (column_list)`:该语句指定了索引为 FULLTEXT ，用于全文索引。

* 显示索引信息
    * 使用 SHOW INDEX 命令来列出表中的相关的索引信息。可以通过添加 \G 来格式化输出信息。
    * `mysql> SHOW INDEX FROM table_name \G`


### 写会MySQL索引
* https://my.oschina.net/u/1462914/blog/1563127

* 摘要:

* **索引区分度**:
    * 区分度: 指字段在数据库中的不重复比
    * 区分度计算规则: 字段去重后的总数与全表总记录数的商。 eg: `select count(distinct(name))/count(*) from t_base_user;`
    * 其中区分度最大值为1.000,最小为0.0000, 区分度的值越大, 也就是数据不重复率越大，新建索引效果也越好

* 函数运算影响索引:
    * 不要在索引列上, 进行函数运算, 否则索引会失效
