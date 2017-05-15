### 简述
* Laravel 发行说明
* 重点： 功能太多，应用太少，需要对没用过又不错的功能做个mark。
* http://d.laravel-china.org/docs/5.4/releases
***


#### Laravel 4.1
* 新的 SSH 组件 (TODO:)
* 数据库读写分离
    * Query Builder 和 Eloquent 目前通过数据库层，已经可以自动做到读写分离。
* 缓存标签
* 队列排序 (TODO:用不明白)
    * 只要在 queue:listen 命令后将队列以逗号分隔送出
* 失败队列作业处理
    * 现在队列将会自动处理失败的作业，只要在 queue:listen 后加上 --tries 即可


#### Laravel 4.2
* PHP 5.4 需求
* Laravel Forge
* Laravel Homestead（TODO:用不明白）
* Laravel 收银台
    * Laravel 收银台是一个简单、具表达性的资源库，用来管理 Stripe 的订阅服务
* Queue Workers 常驻程序 (TODO:用不明白)
    * Artisan `queue:work` 命令现在支持 `--daemon` 参数让 worker 可以作为「常驻程序」启用
* Mail API Drivers(TODO:)
* 软删除 Traits
* 更为方便的 认证(auth) & Remindable Traits
* "简易分页"
    * `simplePaginate`
* 迁移确认
