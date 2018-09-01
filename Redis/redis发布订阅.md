## Redis 发布订阅
* http://www.runoob.com/redis/redis-pub-sub.html

* Redis 发布订阅(pub/sub)是一种 `消息通信模式`：发送者(pub)发送消息，订阅者(sub)接收消息。

* Redis 客户端可以 _订阅任意数量的频道_。

```shell
# 发布者
$ redis-cli
127.0.0.1:6379> AUTH password
OK
127.0.0.1:6379> `PUBLISH` redisChat "Learn redis by runoob.com"
(integer) 2
127.0.0.1:6379> `PUBLISH` redisChat "Redis is a great caching technique"


# 订阅者 1
$ redis-cli                               
127.0.0.1:6379> AUTH password
OK
127.0.0.1:6379> `SUBSCRIBE` redisChat
Reading messages... (press Ctrl-C to quit)
1) "subscribe"
2) "redisChat"
3) (integer) 1
1) "message"
2) "redisChat"
3) "Redis is a great caching technique"
1) "message"
2) "redisChat"
3) "Learn redis by runoob.com"
1) "message"
2) "redisChat"
3) "Learn redis by runoob.com"

# 订阅者 2
$ redis-cli 
127.0.0.1:6379> AUTH password
OK
127.0.0.1:6379> `SUBSCRIBE` redisChat
Reading messages... (press Ctrl-C to quit)
1) "subscribe"
2) "redisChat"
3) (integer) 1
1) "message"
2) "redisChat"
3) "Learn redis by runoob.com"
1) "message"
2) "redisChat"
3) "Learn redis by runoob.com"
```

### 常用命令
1. `PSUBSCRIBE pattern [pattern ...]`
订阅一个或多个符合给定模式的频道。

2. `PUBSUB subcommand [argument [argument ...]]`
查看订阅与发布系统状态。

3. `PUBLISH channel message`
将信息发送到指定的频道。

4. `PUNSUBSCRIBE [pattern [pattern ...]]`
退订所有给定模式的频道。

5. `SUBSCRIBE channel [channel ...]`
订阅给定的一个或多个频道的信息。

6. `UNSUBSCRIBE [channel [channel ...]]`
指退订给定的频道。
