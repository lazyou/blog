## mysql 中 geometry 类型的简单使用
* https://blog.csdn.net/MinjerZhang/article/details/78137795

* 使用geometry类型存储空间点数据


### 建表脚本
```sql
CREATE TABLE `z_gis` (
    `id` varchar(45) NOT NULL,
    `name` varchar(10) NOT NULL COMMENT '姓名',
    `gis` geometry NOT NULL COMMENT '空间位置信息',
    `geohash` varchar(20) GENERATED ALWAYS AS (st_geohash(`gis`,8)) VIRTUAL, // 根据gis字段的值自动生成的值
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`),
    SPATIAL KEY `idx_gis` (`gis`),
    KEY `idx_geohash` (`geohash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='空间位置信息';
```

* 这里我创建了一张位置信息表，每个人对应的经纬度都会以 `geometry` 类型存在表中，`geohash` 字段是把坐标系分成很多小方格，然后将经纬度转化成字符串，其原理可自行百度，在这里就不多说了。 

* 哦，对了，`geometry` 类型好像不能为 null，所以建表时 __必须__ 为 `not null`。


### 插入表数据
```sql
insert into z_gis(id,name,gis) values
(replace(uuid(),'-',''),'张三',geomfromtext('point(108.9498710632 34.2588125935)')),
(replace(uuid(),'-',''),'李四',geomfromtext('point(108.9465236664 34.2598766768)')),
(replace(uuid(),'-',''),'王五',geomfromtext('point(108.9477252960 34.2590342786)')),
(replace(uuid(),'-',''),'赵六',geomfromtext('point(108.9437770844 34.2553719653)')),
(replace(uuid(),'-',''),'小七',geomfromtext('point(108.9443349838 34.2595663206)')),
(replace(uuid(),'-',''),'孙八',geomfromtext('point(108.9473497868 34.2643456798)')),
(replace(uuid(),'-',''),'十九',geomfromtext('point(108.9530360699 34.2599476152)'))
```

* `geomfromtext()` 函数是将字符串格式的点坐标，转化成 `geometry` 类型，还有个字段 `geohash` 是根据gis字段的值自动生成的，可以仔细看看建表脚本。



### 几个简单的查询例子
1. 查询张三的经纬度信息： 
    ```sql
    select name, astext(gis) gis
    from z_gis
    where name = '张三';
    ```

    * `astext()` 函数是将 geometry 类型转化为字符串


2. 修改张三的位置信息:
    ```sql
    update z_gis
    set gis = geomfromtext('point(108.9465236664 34.2598766768)')
    where name = '张三';
    ```

    * `geomfromtext()` 函数是将字符串格式的点坐标，转化成 geometry 类型


3. 查询张三和李四之间的距离:
    ```sql
    select floor(st_distance_sphere(
        (select gis from z_gis where name = '张三'),
        gis
    )) distance
    from z_gis
    where name = '李四';
    ```

    * `st_distance_sphere()` 函数是计算两点之间距离的，所以传两个参数，都是geometry类型的，
    * `floor()` 函数是把计算出的距离取整。



4. 查询距离张三500米内的所有人:
    ```sql
    SELECT name,
        FLOOR(ST_DISTANCE_SPHERE((SELECT gis
                                    FROM z_gis
                                    WHERE name = '张三'),
                                    gis)) distance,
        astext(gis)                    point
    FROM z_gis
    WHERE ST_DISTANCE_SPHERE((SELECT gis
                            FROM z_gis
                            WHERE name = '张三'),
                            gis) < 500
    AND name != '张三';
    ```


* 如果表中数据非常多时，这样查 __效率__ 会非常低，这时就会用到 `geohash` 字段查询:
    ```sql
    SELECT name,
        floor(ST_DISTANCE_SPHERE((SELECT gis
                                    FROM z_gis
                                    WHERE name = '张三'),
                                    gis)) distance,
        astext(gis)                    point
    FROM z_gis
    WHERE geohash like concat(left((select geohash from z_gis where name = '张三'), 6), '%')
    AND ST_DISTANCE_SPHERE((SELECT gis
                            FROM z_gis
                            WHERE name = '张三'),
                            gis) < 500
    AND name != '张三';  
    ```

    * 前面说过geohash是把经纬度转成字符串，建表的时候我定义让它转成8位字符，当两个点离得越近时，它生成的 geohash 字符串前面相同的位数越多，所以我在这里先用 left() 截取前6位字符，前6位相同的误差在±600米左右，然后模糊查询，查出大概符合条件的数据，最后再精确比较，下面是 geohash 官方文档对 geohash 长度和距离误差的说
        ```
        geohash长度	    误差距离（km）
        1	            ±2500
        2	            ±630
        3	            ±78
        4	            ±20
        5	            ±2.4
        6	            ±0.61
        7	            ±0.076
        8	            ±0.019
        ```

    * 注意：用 geohash 查询会有边界问题，所以查询出来的结果又可能不准确，可以用程序(例如java代码)先查出当前点周围8个范围的geohash值，然后再匹配这9个范围的所有数据，这样就解决了geohash 的边界问题。



### 其他
* geohash 官方文档地址: https://en.wikipedia.org/wiki/Geohash
