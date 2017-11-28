
* 编码转换

```sql
SELECT
	*
FROM
	`lb_haidu_university`
WHERE
	(`province` LIKE '北京%')
ORDER BY
	is_985 DESC,
	is_211 DESC,
	CONVERT (school_name USING gb2312) ASC
```