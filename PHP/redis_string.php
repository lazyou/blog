<?php
/**
 * http://static.markbest.site/blog/59.html
 *
 * redis 字符串操作
 *
 * redis 原生： http://www.runoob.com/redis/redis-strings.html
 *      SET key value
 *      GET key
 *      MGET key1 [key2..]
 *      SETEX key seconds value // 将值 value 关联到 key ，并将 key 的过期时间设为 seconds (以秒为单位)
 *      SETNX key value // 只有在 key 不存在时设置 key 的值
 *      STRLEN key // 返回 key 所储存的字符串值的长度
 *    	INCR key // 将 key 中储存的数字值增一。
 *      INCRBY key increment
 * 	    DECR key // 将 key 中储存的数字值减一。
 *      DECRBY key decrement
 *      APPEND key value
 */

/* 初始化redis */
$redis = new Redis();

$redis->connect('localhost', 6379);

// 验证redis密码
$redis->auth('redis112233');

// 选择数据库
$redis->select('1');

$redis->set('string:key', 'key content');

// 字符串操作
$redis->set('string:str1', 'str1 content');

$redis->set('string:str2', 'str2 content');

// 设置有效期为5秒的键值
$redis->setex('string:str3', 5, '五秒后过期 1');

// 设置有效期为5000毫秒(同5秒)的键值
$redis->psetex('string:str4', 5000, '五秒后过期 2');

// 若键值存在返回false 不存在返回true
$redis->setnx('string:str5', '若键值存在返回false 不存在返回true');

// 删除键值 可以传入数组
// $redis->delete('key');

// 获取
$str1 = $redis->get('string:str1');
var_dump($str1);

// 将键 key 的值覆盖，并返回这个键值原来的值
$str1Replace = $redis->getSet('string:str1', 'get and replace str1');
var_dump($str1Replace);


/*
// 批量事务处理,不保证处理数据的原子性
$result = $redis->multi()
    ->set('string:key1','val1')
    ->get('string:key1')
    ->setnx('string:key','val2')
    ->get('string:key2')
    ->exec();

// 监控键key是否被其他客户端修改，如果KEY在调用watch()和exec()之间被修改，exec失败
$redis->watch('string:key');

// 验证键是否存在，存在返回true
$redis->exists('string:key');

$redis->incr('string:number');
$redis->incrby('string:number',-10);
$redis->incrByFloat('string:number', +/- 1.5);
$redis->decr('string:number');
$redis->decrBy('string:number',10);
*/


$getMany = $redis->mget([
    'string:str1',
    'string:str2',
    'string:str_not_exist',
]);
var_dump($getMany);

/*
array(3) {
  [0]=>
  string(20) "get and replace str1"
  [1]=>
  string(12) "str2 content"
  [2]=>
  bool(false)
}
*/

// 批量设置键值
$redis->mset(array('string:key0' => 'value0', 'string:key1' => 'value1'));

// 批量设置键值，类似将 setnx() 方法批量操作
$redis->msetnx(array('string:key0' => 'value0', 'string:key1' => 'value1'));

// 原键值TK，将值追加到键值后面，键值为TK-Smudge
$redis->append('string:key', '-Smudge');

//键值截取从0位置开始到5位置结束
$redis->getRange('key', 0, 5);

//字符串截取从-6(倒数第6位置)开始到-1(倒数第1位置)结束
$redis->getRange('string:key', -6, -1);

//键值中替换字符串，0表示从0位置开始有多少个字符替换多少位置，其中汉字占2个位置
$redis->setRange('string:key', 0, 'Smudge');

//键值长度
$redis->strlen('string:key');
