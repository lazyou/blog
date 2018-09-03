<?php
/**
 * http://static.markbest.site/blog/59.html
 *
 * redis 列表（list）操作: Redis列表是简单的字符串列表，__按照插入顺序排序__。
 *
 * redis 原生： http://www.runoob.com/redis/redis-lists.html
 *
 *      LLEN key : 获取列表长度
 *
 *      LINDEX key index : 通过索引获取列表中的元素
 *      LRANGE key start stop : 获取列表指定范围内的元素
 *
 *      LSET key index value : 通过索引设置列表元素的值
 *
 * 	    LPUSH key value1 [value2] : 将一个或多个值插入到列表头部
 *	    RPUSH key value1 [value2] : 在列表中添加一个或多个值
 *
 *      LPUSHX key value : 将一个值插入到已存在的列表头部
 * 	    RPUSHX key value : 为已存在的列表添加值
 *
 *      LREM key count value : 移除列表元素
 * 	    LPOP key : 移出并获取列表的第一个元素
 *      RPOP key: 移除并获取列表最后一个元素
 */

// 初始化redis
$redis = new Redis();

$redis->connect('localhost', 6379);

// 验证redis密码
$redis->auth('redis112233');

// 选择数据库
$redis->select('1');

// 删除链表
// $redis->delete('list:key');

// 插入链表头部/左侧，返回链表长度
$redis->lPush('list:key', 'A');

// 插入链表尾部/右侧，返回链表长度
$redis->rPush('list:key', 'B');

// 插入链表头部/左侧,链表不存在返回0，存在即插入成功，返回当前链表长度
$redis->lPushx('list:key', 'C');

// 插入链表尾部/右侧,链表不存在返回0，存在即插入成功，返回当前链表长度
$redis->rPushx('list:key', 'D');

printList($redis, 'list:key');

// 返回LIST顶部（左侧）的VALUE ,后入先出(栈)
$redis->lPop('list:key');
printList($redis, 'list:key');

// 返回LIST尾部（右侧）的VALUE ,先入先出（队列）
$redis->rPop('list:key');
printList($redis, 'list:key');

//// 移出并获取列表的第一个元素
//$redis->blPop('list:key', 1);
//printList($redis, 'list:key');

//// 移出并获取列表的最后一个元素
//$redis->brPop('list:key', 1);
//printList($redis, 'list:key');

// 如果是链表则返回链表长度，空链表返回0。若不是链表或者不为空，则返回false
$redis->lSize('list:key');

// 通过索引获取链表元素 0获取左侧一个,-1获取最后一个
$redis->lGet('list:key',-1);
printList($redis, 'list:key');

// 0位置元素替换为 X
$redis->lSet('list:key', 0, 'X');
printList($redis, 'list:key');

// 链表截取从0开始3位置结束，结束位置为-1获取开始位置之后的全部
$redis->lRange('list:key', 0, 3);
printList($redis, 'list:key');

// 截取链表(不可逆) 从0索引开始 1索引结束
$redis->lTrim('list:key', 0, 1);
printList($redis, 'list:key');

// 链表从左开始删除元素2个C
$redis->lRem('list:key', 'C', 2);
printList($redis, 'list:key');

// 在C元素前面插入X, Redis::AfTER(表示后面插入),链表不存在则插入失败 返回0 若元素不存在返回-1
$redis->lInsert('list:key', Redis::BEFORE, 'C', 'X');

//// 从源LIST的最后弹出一个元素并且把这个元素从目标LIST的顶部（左侧）压入目标LIST。
//$redis->rpoplpush('list:key', 'list:key2');

//// rpoplpush的阻塞版本，这个版本有第三个参数用于设置阻塞时间即如果源LIST为空，那么可以阻塞监听timeout的时间，如果有元素了则执行操作。
//$redis->brpoplpush();

function printList($redis, $key) {
    $listLen = $redis->lLen($key);
    $list = $redis->lGetRange($key, 0, $listLen);
    var_dump($list);
}
