### SQL HAVING 子句:
* https://www.w3cschool.cn/mysql/sql-having.html

* 在 SQL 中增加 HAVING 子句原因是，WHERE 关键字无法与 Aggregate 函数一起使用。

* 对查询结果的再次筛选


```sql
SELECT
	fd.id,
	fd.fee_list_id,
	fl.house_id,
	fd.fee_month,
	fd.amount,
	h.building_no,
	h.house_no,
	fl.count_months,
	f.fee_no,
	f.payment_status
FROM
	fee_lists fl
INNER JOIN fees f ON f.id = fl.fee_id
INNER JOIN fee_details fd ON fl.id = fd.fee_list_id
INNER JOIN houses h ON fl.house_id = h.id
WHERE
	fl.ref_type = 1
AND fd.amount < 800
AND ISNULL(fd.deleted_at)
AND f.payment_status = 2
GROUP BY
	house_id,
	fee_month
HAVING
	COUNT(CONCAT(house_id, fee_month)) > 1
ORDER BY
	house_id,
	fee_month
```