<?php
/**
 * http://static.markbest.site/blog/59.html
 *
 * redis 有序集合(sorted set) : http://www.runoob.com/redis/redis-hashes.html
 *      * Redis hash 是一个string类型的field和value的映射表，hash特别适合用于存储对象。
 *
 *      * Redis 中每个 hash 可以存储 232 - 1 键值对（40多亿）。
 *
 * redis 原生： http://www.runoob.com/redis/redis-hashes.html
 * 	    HDEL key field1 [field2] : 删除一个或多个哈希表字段
 *
 * 	    HSET key field value : 将哈希表 key 中的字段 field 的值设为 value 。
 *      HMSET key field1 value1 [field2 value2 ] : 同时将多个 field-value (域-值)对设置到哈希表 key 中。
 *      HSETNX key field value : 只有在字段 field 不存在时，设置哈希表字段的值。
 *
 *      HEXISTS key field : 查看哈希表 key 中，指定的字段是否存在。
 *
 * 	    HGET key field : 获取存储在哈希表中指定字段的值。
 * 	    HGETALL key : 获取在哈希表中指定 key 的所有字段和值
 *
 * 	    HLEN key: 获取哈希表中字段的数量
 * 	    HMGET key field1 [field2] : 获取所有给定字段的值
 *
 *      HKEYS key : 获取所有哈希表中的字段
 * 	    HVALS key: 获取哈希表中所有值
 */

/* 初始化redis */
$redis = new Redis();

$redis->connect('localhost', 6379);

// 验证redis密码
$redis->auth('redis112233');

// 选择数据库
$redis->select('1');

// 在h表中添加name字段value为TK
$redis->hSet('hash:h', 'name', 'TK');

// 在h表中 添加name字段 value为TK 如果字段name的value存在返回false 否则返回 true
$redis->hSetNx('hash:h', 'name', 'TK');

// 获取h表中name字段value
$redis->hGet('hash:h', 'name');

// 获取h表长度即字段的个数
$redis->hLen('hash:h');

// 删除h表中email 字段
$redis->hDel('hash:h', 'email');

// 获取h表中所有字段
$hkeys = $redis->hKeys('hash:h');
var_dump($hkeys);

// 获取h表中所有字段value
$redis->hVals('hash:h');

// 获取h表中所有字段和value 返回一个关联数组(字段为键值)
$redis->hGetAll('hash:h');

// 判断email 字段是否存在与表h 不存在返回false
$redis->hExists('hash:h', 'email');
$redis->hSet('hash:h', 'age', 28);

// 设置h表中age字段value加(-2) 如果value是个非数值 则返回false否则，返回操作后的value
$redis->hIncrBy('hash:h', 'age', -2);

// 设置h表中age字段value加(-2.6) 如果value是个非数值则返回false否则返回操作后的value(小数点保留15位)
$redis->hIncrByFloat('hash:h', 'age', -0.33);

// 表h批量设置字段和value
$redis->hMset('hash:array', array(
    'score' => '80',
    'salary' => 2000
));

// 表h批量获取字段的value
$hget = $redis->hMGet('hash:array', array('score', 'salary'));
var_dump($hget);
