### 把一张表的数据导入到另一张表里
* `INSERT INTO translated_new_en_07  SELECT * FROM translated_new_fr_07;`

* 把 `translated_new_fr_07` 表中的数据全部导入 `translated_new_en_07`  表中.

* 前提是这两个表的数据结构完全一样. 且被导入表最好为空 (truncate),才不会出现重复主键的情况. 


### 可以只导入我们想要的字段. 还能加条件过滤 
```sql
INSERT INTO translated_new_fr_07 (
	result_id,
	title,
	body,
	add_date
) SELECT
	result_id,
	title,
	body,
	NOW()
FROM
	translated_new_en_07
LIMIT 1;
```