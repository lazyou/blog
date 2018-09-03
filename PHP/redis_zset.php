<?php
/**
 * http://static.markbest.site/blog/59.html
 *
 * redis 有序集合(sorted set) : http://www.runoob.com/redis/redis-sorted-sets.html
 *      * Redis 有序集合和集合一样也是string类型元素的集合,且不允许重复的成员。
 *
 *      * 不同的是每个元素都会关联一个double类型的分数。redis正是通过分数来为集合中的成员进行从小到大的排序。有序集合的成员是唯一的,但分数(score)却可以重复。
 *
 *      * 集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是O(1)。 集合中最大的成员数为 232 - 1 (4294967295, 每个集合可存储40多亿个成员)。
 *
 *
 * redis 原生： http://www.runoob.com/redis/redis-sorted-sets.html
 *      NOTE: 少用，先不介绍
 */

/* 初始化redis */
$redis = new Redis();

$redis->connect('localhost', 6379);

// 验证redis密码
$redis->auth('redis112233');

// 选择数据库
$redis->select('1');

// 插入集合tkey中，A元素关联一个分数，插入成功返回1。同时集合元素不可以重复, 如果元素已经存在返回0
$redis->zAdd('zset:tkey', 1, 'A');

// 获取集合元素，从0位置到-1位置
$redis->zRange('zset:tkey', 0, -1);

// 获取集合元素，从0位置到-1位置, 返回一个关联数组带分数array([A] => 0.01,[B] => 0.02,[D] => 0.03)其中小数来自zAdd方法第二个参数
$redis->zRange('zset:tkey', 0, -1, true);

// 移除集合tkey中元素B成功返回1 失败返回 0
$redis->zDelete('zset:tkey', 'B');

// 获取集合元素，从0位置到-1位置，数组按照score降序处理
$redis->zRevRange('zset:tkey', 0, -1);

// 获取集合元素，从0位置到-1位置，数组按照score降序处理 返回score关联数组
$redis->zRevRange('zset:tkey', 0, -1,true);

// 获取几个tkey中score在区间[0,0.2]元素 ,score由低到高排序,元素具有相同的score，那么会按照字典顺序排列, withscores控制返回关联数组
$redis->zRangeByScore('zset:tkey', 0, 0.2, array('withscores' => true));

// 其中limit中 0和1 表示取符合条件集合中 从0位置开始，向后扫描1个 返回关联数组
$redis->zRangeByScore('zset:tkey', 0.1, 0.36, array('withscores' => TRUE, 'limit' => array(0, 1)));

// 获取tkey中score在区间[2, 10]元素的个数
$redis->zCount('zset:tkey', 2, 10);

// 移除tkey中score在区间[1, 3](含边界)的元素
$redis->zRemRangeByScore('zset:tkey', 1, 3);

// 默认元素score是递增的，移除tkey中元素 从0开始到-1位置结束
$redis->zRemRangeByRank('zset:tkey', 0, 1);

// 返回存储在key对应的有序集合中的元素的个数
$redis->zSize('zset:tkey');

// 返回集合tkey中元素A的score值
$redis->zScore('zset:tkey', 'A');

// 返回集合tkey中元素A的索引值z集合中元素按照score从低到高进行排列 ，即最低的score index索引为0
$redis->zRank('zset:tkey', 'A');

// 将集合tkey中元素A的score值 加 2.5
$redis->zIncrBy('zset:tkey', 2.5, 'A');

// 将集合tkey和集合tkey1元素合并于集合union,并且新集合中元素不能重复返回新集合的元素个数，如果元素A在tkey和tkey1都存在，则合并后的元素A的score相加
$redis->zUnion('union', array('zset:tkey', 'zset:tkey1'));

// 集合k1和集合k2并集于k02 ，array(5,1)中元素的个数与子集合对应，然后5对应k1每个元素score都要乘以5 ，同理1对应k2，k2每个元素score乘以1 然后元素按照递增排序，默认相同的元素score(SUM)相加
$redis->zUnion('zset:ko2', array('k1', 'k2'), array(5, 2));

// 各个子集乘以因子之后，元素按照递增排序，相同的元素的score取最大值(MAX)也可以设置MIN 取最小值
$redis->zUnion('zset:ko2', array('k1', 'k2'), array(10, 2),'MAX');

// 集合k1和集合k2取交集于k01 ，且按照score值递增排序如果集合元素相同，则新集合中的元素的score值相加
$redis->zInter('zset:ko1', array('k1', 'k2'));

// 集合k1和集合k2取交集于k01，array(5,1)中元素的个数与子集合对应，然后 5 对应k1 k1每个元素score都要乘以5 ，同理1对应k2，k2每个元素score乘以1 ，然后元素score按照递增排序，默认相同的元素score(SUM)相加
$redis->zInter('zset:ko1', array('k1', 'k2'), array(5, 1));

// 各个子集乘以因子之后，元素score按照递增排序，相同的元素score取最大值(MAX)也可以设置MIN取最小值
$redis->zInter('zset:ko1', array('k1', 'k2'), array(5, 1),'MAX');
