* ORDER BY FIELD : 按指定字段的指定顺序排序

* http://blog.csdn.net/aidenliu/article/details/7554860

```sql
SELECT
	`text`,
	`value`
FROM
	`dicts`
WHERE
	`dicts`.`deleted_at` IS NULL
AND `code` = 'booking_status'
AND `value` IN (2, 1, 3)
ORDER BY
	FIELD(`value`, 2, 1, 3)
```


```php
$result = Dict::where('code', '=', 'booking_status')
            ->select('text', 'value')
            ->whereIn('value', [2, 1, 3])
            ->orderByRaw(DB::raw('FIELD(`value`, 2, 1, 3)'))
            ->get();
```
