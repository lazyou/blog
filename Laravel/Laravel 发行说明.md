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


#### Laravel 5.0
* 采用自动加载标准（PSR-4）
* 新的目录结构
* Contracts
    * 所有 Laravel 组件实现所用的接口都放在 illuminate/contracts 文件夹中，他们没有其他依赖
* 路由缓存
    * `route:cache` Artisan 命令可大幅度地优化路由注册寻找速度
* 路由中间件
    * Laravel4 时叫作 过滤器
* 控制器方法注入
    * 可以在控制器方法中使用依赖注入， *服务容器* 会自动注入依赖
    * 例子 `public function createPost(Request $request, PostRepository $posts)`
* 认证基本架构
    * 认证系统默认包含了用户注册，认证，以及重设密码的控制器，还有对应的视图，视图文件存放在 `resources/views/auth`
* 事件对象（TODO:）
* 数据库队列
* Laravel 调度器
* DotEnv
* Laravel Elixir
    * 一个流畅、口语化的接口，可以编译以及合并静态资源
* 文件系统集成
* Form Requests 
    * 这些 `request` 对象可以和控制器方法依赖注入结合使用，提供一个不需模版的方法，来验证用户输入
* 简易控制器请求验证
    * 如果对你的应用程序来说 `Form Requests` 太复杂了，可以考虑使用手动验证方法
* 新的生成器
    * `php artisan list` 查看 `make` 系列的命令
* 配置文件缓存
* Symfony VarDumper
    * `dd()` 函数


#### Laravel 5.1
* PHP 5.5.9+
* LTS： 第一个长支持版本
* PSR-2 代码风格
    * PSR-2 代码风格指南 已经被 Laravel 框架采用为默认的代码风格指
* 事件广播（TODO:）
    * WebSockets
    * Laravel 的事件广播机制很好的支持了此类应用的开发，广播事件允许服务器端代码和 JavaScript 框架间分享相同的事件名称
* 中间件参数
* 测试改进
* 模型工厂
* Artisan 的改进
* 文件夹结构
* 加密
    * 以前版本使用 `mcrypt` PHP扩展
    * 现在版本使用 `openssl` PHP扩展


#### Laravel 5.1.4
* 增加了简单的登录限制功能。认证的文档 -- http://d.laravel-china.org/docs/5.4/authentication#authentication-throttling


#### Laravel 5.1.11
* 出了内置的 授权 功能！利用回调和授权策略类，能更方便的组织应用程序的授权逻辑。
    * 授权的文档： http://d.laravel-china.org/docs/5.4/authorization


#### Laravel 5.2
* 用户认证驱动 / "多认证系统"
* 用户认证脚手架
    * `php artisan make:auth`
* 隐式数据模型绑定
* 中间件群组
* 访问频率限制
* 数组输入验证
* Bail 认证规则
* Eloquent 全局作用域优化


#### Laravel 5.3
* 消息通知
* WebSockets / 事件广播
* Laravel Passport (OAuth2 认证服务)
* 搜索系统 Laravel Scout
* Mailable 对象
* 存储上传文件
* Webpack 和 Laravel Elixir
* 路由文件
* Blade 中的 $loop 魔术变量


#### Laravel 5.4
* Markdown 邮件和通知
* Laravel Dusk
* Laravel Mix
    * 完全基于 `Webpack` 而非 `Gulp`
* Blade Components & Slots
* 广播模型绑定
* 集合高阶消息传递
* 基于对象的 Eloquent 事件
* 任务级别重试和超时
* 请求清理中间件
* "实时" Facades
* 自定义 Pivot 表模型
* 优化 Redis 集群支持
* 迁移默认字符长度
    * 认使用 `utf8mb4` 字符编码，该编码支持对 "emojis" 表情在数据库进行存储。