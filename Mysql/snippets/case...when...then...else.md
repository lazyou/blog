* 语法:
```sql
SELECT <myColumnSpec> = 
CASE 
    WHEN <A> THEN <somethingA> 
    WHEN <B> THEN <somethingB> 
    ELSE <somethingE> 
END 
```

* 在 update 时使用 case:

```sql
UPDATE fee_shared_results
SET fee_item = (
	CASE
	WHEN (fee_type = 10) THEN
		'公用区用水'
	WHEN (fee_type = 20) THEN
		'公用区用电'
	WHEN (fee_type = 30) THEN
		'生活变频泵'
	WHEN (fee_type = 31) THEN
		'电梯用电'
	WHEN (fee_type = 32) THEN
		'楼梯间照明'
	WHEN (fee_type = 11) THEN
		'店面水公摊'
	ELSE
		(fee_item)
	END
)
```