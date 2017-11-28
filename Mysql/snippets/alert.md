```sql
添加字段：
ALTER table `user_movement_log`;
ADD COLUMN gateway_id int NOT NULL default 0 AFTER `regionid`; (在哪个字段后面添加)

删除字段：
ALTER TABLE `user_movement_log` DROP COLUMN gateway_id;

调整字段顺序：
ALTER TABLE `user_movement_log` CHANGE `GatewayId` `GatewayId` int not null default 0 AFTER RegionID

主键
ALTER TABLE tabelname ADD new_field_id int(5) unsigned default 0 NOT NULL auto_increment ,add primary key (new_field_id);

增加一个新列
alter table t2 add d timestamp;
alter table infos add ex tinyint not null default '0';

删除列
alter table t2 drop column c;

重命名列
alter table t1 change a b integer;

改变列的类型
alter table t1 change b b bigint not null;
alter table infos change list list tinyint not null default '0';

重命名表
alter table t1 rename t2;

加索引
mysql> alter table tablename change depno depno int(5) not null;
mysql> alter table tablename add index 索引名 (字段名1[，字段名2 …]);
mysql> alter table tablename add index emp_name (name);

加主关键字的索引
mysql> alter table tablename add primary key(id);

加唯一限制条件的索引
mysql> alter table tablename add unique emp_name2(cardnumber);

删除某个索引
mysql>alter table tablename drop index emp_name;

修改表：
增加字段：
mysql> ALTER TABLE table_name ADD field_name field_type;

修改原字段名称及类型：
mysql> ALTER TABLE table_name CHANGE old_field_name new_field_name field_type;

删除字段：
mysql> ALTER TABLE table_name DROP field_name;

4.2.修改某个表的字段类型及指定为空或非空
> alter table 表名称 change 字段名称 字段名称 字段类型 [是否允许非空];
> alter table 表名称 modify 字段名称 字段类型 [是否允许非空];
```