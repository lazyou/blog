## 简要谈谈php中mysql,mysqli,mysqlnd,pdo到底是什么.
* https://blog.csdn.net/u013785951/article/details/60876816


### 简述
* __MYSQL__: 也叫 Original MySQL，PHP4版本的MYSQL扩展，从PHP5起已经被废弃，并别从PHP7开始已经被移除。
* __MYSQLI__: 叫做 “MySQL增强 __扩展__”。
* __MYSQLND__: MYSQL Native Dirver 叫做MYSQL “官方驱动”或者更加直接点的叫做“原生 __驱动__”
* __PDO__: PHP Data Objects PHP数据对象，是PHP应用中的一个数据库抽象层规范。


### 什么是API？
* 一个应用程序接口（Application Programming Interface的缩写），定义了类，方法，函数，变量等等一切 你的应用程序中为了完成特定任务而需要调用的内容。在PHP应用程序需要和数据库进行交互的时候所需要的API 通常是通过PHP扩展暴露出来（给终端PHP程序员调用）。

* 上文所说的 __MYSQL__ 和 __MYSQLI__ 扩展就提供了这样的API


### 什么是驱动？
* 驱动是一段设计用来于一种特定类型的数据库服务器进行交互的软件代码。驱动可能会调用一些库，比如 MySQL 客户端库或者 MySQL Native 驱动库。 这些库实现了用于和 MySQL 数据库服务器进行交互的底层协议。

* 在PHP拓展的角度上看，MYSQL和MYSQLi还是比较上层的拓展，依赖更底层的库去连接和访问数据库。 __上文所说的 MYSQLND 就是所说的底层的数据库驱动__。当然，还有一个驱动叫做 libmysqlclient。


### 总的来说:
* 从应用的层面上看，我们通过 PHP 的 MYSQL 或者 MYSQLi 扩展提供的 API 去操作数据库。

* 从底层来看，MYSQLND 提供了底层和数据库交互的支持(可以简单理解为和MySQL server进行网络协议交互)。

* 而 PDO，则提供了一个统一的 API 接口，使得你的 PHP 应用不去关心具体要连接的数据库服务器系统类型。
    * 也就是说，如果你使用 PDO 的 API，可以在任何需要的时候无缝切换数据库服务器。比如 MYSQL, SQLITE 任何数据库都行。

    * 即从大部分功能上看，PDO 提供的 API 接口和 MYSQLI 提供的接口对于普通的增删改查效果是一致的。


### 代码
```php
MYSQL连接：
    $conn = @ mysql_connect("localhost", "root", "") or die("数据库连接错误");
    mysql_select_db("bbs", $conn);
    mysql_query("set names 'utf8'");
    echo "数据库连接成功";


MYSQLI连接：
    $conn = mysqli_connect('localhost', 'root', '', 'bbs');
    if(!$conn){
        die("数据库连接错误" . mysqli_connect_error());
    }else{
        echo"数据库连接成功";
    }

PDO连接：
    try{
        $pdo=new pdo("mysql:host=localhost;dbname=bbs","root","");
    }catch(PDDException $e){
        echo"数据库连接错误";
    }

    echo"数据库连接成功";

* 想更多去了解他们的区别和联系，可以手动去编译一下PHP的源代码。注意参数
    --enable-pdo 
    --with-pdo-mysql
    --enable-mysqlnd 
    --with-mysqli
    --with-mysql//php7的已经不再支持，此参数configure 的时候会报ERROR
```
