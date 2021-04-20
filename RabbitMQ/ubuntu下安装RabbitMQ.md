## ubuntu 安装 RabbitMQ
* https://www.imooc.com/article/36269

* RabbitMQ是实现了高级消息队列协议（AMQP）的开源消息代理软件（亦称面向消息的中间件）。


### 安装方法1
```sh
sudo apt-get install rabbitmq-server

sudo service rabbitmq-server disable|enable|restart|start|status|stop

# 运行状态
rabbitmqctl status
```

* TODO: rabbitmqctl 是什么？


### 配置文件
* `/etc/rabbitmq/rabbitmq-env.conf`

### 操作--用户管理
* 查看所有用户： `sudo rabbitmqctl list_users`
* 添加用户： `sudo rabbitmqctl add_user username password`
* 删除用户： `sudo rabbitmqctl delete_user username`
* 修改密码： `sudo rabbitmqctl change_password username newpassword`

* 添加用户，设置权限（可用于web后台登录）
    ```sh
    sudo rabbitmqctl add_user admin admin
    sudo rabbitmqctl set_user_tags admin administrator
    sudo rabbitmqctl set_permissions -p / admin ".*" ".*" ".*"
    ```


### 操作--开启rabbit网页控制台 （好像默认已经包含）
* 进入rabbit安装目录: `cd /usr/lib/rabbitmq`
* 查看已经安装的插件: `sudo rabbitmq-plugins list`
* 开启网页版控制台: `sudo rabbitmq-plugins enable rabbitmq_management`
* 重启rabbitmq服务
* 输入网页访问地址: http://localhost:15672/ , 使用默认账号: guest/guest登录
