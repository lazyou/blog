### 简述
* Laravel 发行说明
* 重点： 功能太多，应用太少，需要对没用过又不错的功能做个mark。
* http://d.laravel-china.org/docs/5.4/releases
***


#### Laravel 4.1
* 新的 SSH 组件 (没用过)
* 数据库读写分离
    * Query Builder 和 Eloquent 目前通过数据库层，已经可以自动做到读写分离。
* 缓存标签
* 队列排序
    * 只要在 queue:listen 命令后将队列以逗号分隔送出
* 失败队列作业处理
    * 现在队列将会自动处理失败的作业，只要在 queue:listen 后加上 --tries 即可


