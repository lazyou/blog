## Getting this SQL Error: GROUP BY incompatible with sql_mode=only_full_group_by
* https://craftcms.stackexchange.com/questions/12084/getting-this-sql-error-group-by-incompatible-with-sql-mode-only-full-group-by

* ERROR:
```sql
Error: SQLSTATE[42000]: Syntax error or access violation: 1055 Expression #2 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'arashi_cake_web.c.name' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by
```

* `sudo vim /etc/mysql/my.cnf`:
```cnf
[mysqld]
sql_mode=STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
```

* `sudo service mysql restart`
