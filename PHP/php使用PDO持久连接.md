## PHP 使用 PDO 持久连接
* http://php.net/manual/zh/pdo.connections.php

* 很多 web 应用程序通过使用到数据库服务的持久连接获得好处。持久连接在脚本结束后不会被关闭，且被缓存，当另一个使用相同凭证的脚本连接请求时被重用。持久连接缓存可以避免每次脚本需要与数据库回话时建立一个新连接的开销，从而让 web 应用程序更快。


* eg1: 查询比较
```php
$pdo = new PDO('mysql:host=localhost;dbname=saas_final;charset=utf8', 'root', 'password', array(
    // PDO::ATTR_PERSISTENT => true, // 去掉注释就是 持久连接版本， 同样查询 ab 测试提高了不少
));

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
$pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

$dealers = $pdo->query('SELECT * from dealer')->fetchAll(PDO::FETCH_ASSOC);
$users = $pdo->query('SELECT * from user')->fetchAll(PDO::FETCH_ASSOC);
$departments = $pdo->query('SELECT * from department')->fetchAll(PDO::FETCH_ASSOC);
$classrooms = $pdo->query('SELECT * from classroom')->fetchAll(PDO::FETCH_ASSOC);
$liverooms = $pdo->query('SELECT * from liveroom')->fetchAll(PDO::FETCH_ASSOC);

$data = [
    'dealers' => $dealers,
    'users' => $users,
    'departments' => $departments,
    'classrooms' => $classrooms,
    'liverooms' => $liverooms,
];

echo json_encode($data);
```

* eg2: 连接比较
```php
set_time_limit(0);
$begiontime=microtime(true);
for($i=0; $i<10000; $i++) {
    $pdo = new PDO('mysql:host=localhost;dbname=saas_final;charset=utf8', 'root', 'password', array(
        // PDO::ATTR_PERSISTENT => true, // 去掉注释就是 持久连接版本，时间差很多
    ));
}
$endtime=microtime(true);
$times=$endtime-$begiontime;
echo $times;
```

* Note: 如果想使用持久连接，必须在传递给 `PDO` 构造函数的驱动选项数组中设置 `PDO::ATTR_PERSISTENT` 。如果是在对象初始化之后用 `PDO::setAttribute()` 设置此属性，则驱动程序将不会使用持久连接
    * NOTE:实践的时候表示没影响

* Note: 如果使用 `PDO` `ODBC` 驱动且 `ODBC` 库支持 `ODBC` 连接池（有 unix `ODBC` 和 Windows 两种做法；可能会有更多），建议不要使用持久的 `PDO` 连接，而是把连接缓存留给 `ODBC` 连接池层处理。 `ODBC` 连接池在进程中与其他模块共享；如果要求 `PDO` 缓存连接，则此连接绝不会被返回到 `ODBC` 连接池，导致创建额外的连接来服务其他模块。


### 缺点
* https://stackoverflow.com/questions/3332074/what-are-the-disadvantages-of-using-persistent-connection-in-pdo

* 手册还建议在使用PDO ODBC驱动程序时不要使用持久连接，因为它可能 _会妨碍ODBC连接池化进程_。
