## MySQL用户管理：添加用户、授权、删除用户
* https://www.cnblogs.com/chanshuyi/p/mysql_user_mng.html

### 添加用户
* 以root用户登录数据库，运行以下命令：
    * `CREATE USER zhangsan IDENTIFIED BY 'zhangsan';`

* 上面的命令创建了用户 zhangsan，密码是 zhangsan。在 mysql.user 表里可以查看到新增用户的信息


### 授权
* 命令格式：`GRANT privilegesCode on dbName.[tableName] TO username@host [IDENTIFIED BY "password";]`
    * 更建议直接 TO 某个 user, 授权时不建议创建用户.
    * eg: `GRANT SELECT ON sync.* TO 'pig';`

* 然后执行 `FLUSH PRIVILEGES;` 刷新权限信息

* 在 mysql.db 表里可以查看到新增数据库权限的信息

* 也可以通过 `SHOW GRANTS` 命令查看权限授予执行的命令

* `privilegesCode` 表示授予的权限类型，常用的有以下几种类型[1]：
    * ALL PRIVILEGES: 所有权限;
    * SELECT: 读取权限;
    * DELETE: 删除权限;
    * UPDATE: 更新权限;
    * CREATE: 创建权限;
    * DROP: 删除数据库、数据表权;

* `dbName.tableName` 表示授予权限的具体库或表，常用的有以下几种选项：
    * `.`: 授予该数据库服务器所有数据库的权限;
    * `dbName.*`: 授予dbName数据库所有表的权限;
    * `dbName.dbTable`: 授予数据库dbName中dbTable表的权限;    

* `username@host` 表示授予的用户以及允许该用户登录的IP地址。其中Host有以下几种类型：
    * `localhost`: 只允许该用户在本地登录，不能远程登录;
    * `%`: 允许在除本机之外的任何一台机器远程登录;
    * `192.168.52.32`: 具体的IP表示只允许该用户从特定IP登录;

* `password` 指定该用户登录时的密码

* `FLUSH PRIVILEGES` 表示刷新权限变更

* TODO: 移除部分权限... 用到再说

### 修改密码
* 运行以下命令可以修改用户密码
```mysql
UPDATE mysql.user SET password = PASSWORD('zhangsannew') WHERE user = 'zhangsan' AND host = '%';
FLUSH PRIVILEGES;
```

### 删除用户
* 运行以下命令可以删除用户：
    * `DROP USER zhangsan@'%';`
    * `DROP USER` 命令会删除用户以及对应的权限，执行命令后你会发现 mysql.user 表和 mysql.db 表的相应记录都消失了


### 常用命令组
* 创建用户并授予指定数据库全部权限：适用于Web应用创建MySQL用户
```mysql
CREATE USER zhangsan IDENTIFIED BY 'zhangsan';
GRANT ALL PRIVILEGES ON zhangsanDb.* to zhangsan@'%' IDENTIFIED BY 'zhangsan';
FLUSH PRIVILEGES;
```

* 创建了用户 zhangsan，并将数据库 zhangsanDB 的所有权限授予 zhangsan。如果要使 zhangsan 可以从本机登录，那么可以多赋予 localhost 权限：
    * `GRANT ALL PRIVILEGES ON zhangsanDb.* TO zhangsan@'localhost' IDENTIFIED BY 'zhangsan';`


### 参考资料
* [1].百度.更多关于MySQL数据库权限类型（PrivilegesCode）.[DB/OL].2013-07-13 (http://jingyan.baidu.com/article/dca1fa6fb4ca34f1a5405270.html)
* [2].博客园.MySQL添加用户、删除用户与授权.[DB/OL].2011-12-15 (http://www.cnblogs.com/fly1988happy/archive/2011/12/15/2288554.html)