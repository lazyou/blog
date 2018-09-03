<?php
/**
 * http://static.markbest.site/blog/59.html
 *
 * redis 列表（list）操作: Redis 的 Set 是 String 类型的无序集合。
 *      集合成员是唯一的，这就意味着集合中不能出现重复的数据。
 *
 *      Redis 中集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是 O(1)。
 *
 *      集合中最大的成员数为 232 - 1 (4294967295, 每个集合可存储40多亿个成员)。
 *
 * redis 原生： http://www.runoob.com/redis/redis-sets.html
 *      SADD key member1 [member2] : 向集合添加一个或多个成员
 * 	    SMOVE source destination member : 将 member 元素从 source 集合移动到 destination 集合
 *
 * 	    SCARD key : 获取集合的成员数
 * 	    SMEMBERS key : 返回集合中的所有成员
 *      SPOP key : 移除并返回集合中的一个随机元素
 *      SRANDMEMBER key [count]: 返回集合中一个或多个随机数
 *
 * 	    SREM key member1 [member2] : 移除集合中一个或多个成员
 *
 * 	    SDIFF key1 [key2] : 返回给定所有集合的差集
 *      SINTER key1 [key2] : 返回给定所有集合的交集
 *  	SUNION key1 [key2] : 返回所有给定集合的并集
 *
 * 	    SISMEMBER key member : 判断 member 元素是否是集合 key 的成员
 */

// 初始化redis
$redis = new Redis();

$redis->connect('localhost', 6379);

// 验证redis密码
$redis->auth('redis112233');

// 选择数据库
$redis->select('1');

// 获取容器key中所有元素
$redis->sMembers('set:key');

// (从左侧插入,最后插入的元素在0位置),集合中已经存在TK 则返回false,不存在添加成功返回true
$redis->sAdd('set:key', 'TK'); // NOTE: 注意这里是传入 value
$redis->sAdd('set:key', 'set1');
$redis->sAdd('set:key', 'set2', 'set3');
$redis->sAddArray('set:key', ['set4', 'set5']);
var_dump($redis->sMembers('set:key'));

// 移除容器中的TK
$redis->sRem('set:key', 'TK');
var_dump($redis->sMembers('set:key'));

// 将容易key中的元素set3移动到容器key1,操作成功返回TRUE
$redis->sMove('set:key', 'set:key1', 'set3');
var_dump($redis->sMembers('set:key'));

// 检查VALUE是否是SET容器中的成员
$redis->sIsMember('set:key', 'TK');

// 返回SET容器的成员数
$setCount = $redis->sCard('set:key');
var_dump($setCount);

// 随机返回容器中一个元素，并移除该元素
$redis->sPop('set:key');

// 随机返回容器中一个元素，不移除该元素
$redis->sRandMember('set:key');

// 返回两个集合的交集 没有交集返回一个空数组，若参数只有一个集合，则返回集合对应的完整的数组
$redis->sInter('set:key', 'set:key1');

// 将集合key和集合key1的交集 存入容器store成功返回1
$redis->sInterStore('set:store', 'set:key', 'set:key1');

// 集合key和集合key1的并集  注意即使多个集合有相同元素只保留一个
$redis->sUnion('set:key', 'set:key1');

// 集合key和集合key1的并集保存在集合store中,  注意即使多个集合有相同元素 只保留一个
$redis->sUnionStore('set:store', 'set:key', 'set:key1');

// 返回数组，该数组元素是存在于key集合而不存在于集合key1、key2
$redis->sDiff('set:key', 'set:key1', 'set:key2');
