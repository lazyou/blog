### 简述
* 让更好用的Laravel来构建web应用
* 重点： Repository 模式 和 Service 模式的实际运用
* http://slides.com/ryanyuan/better-use-of-laravel-to-build-web-applications#/
***



### 内容

#### Laravel特点和优点
* 强大的RESTful Routing
* Blade模板引擎
* Eloquent ORM
* Migration & Seed
* Artisan 控制台
* Laravel Elixir
* ServiceProvider,Contracts,Facades
* Composer
* ......


#### 不同的环境如何调用不同的配置文件？
* 比如本机开发环境调用.env.local配置，预览环境调用.env.preview配置，线上直接调用.env配置
```
// bootstrap/app.php
$environment = getenv('DEV_ENV') ? '.' . getenv('DEV_ENV') : '';
$app->loadEnvironmentFrom('.env'.$environment);
```
设置`webserver`变量 `DEV_ENV＝local`
`export DEV_ENV=local` （linux terminal 运行此命令）


#### 面向对象设计和编程的SOLID
* SRP       单一责任原则
* OCP       开发封闭原则
* LSP       里氏替换原则
* DIP       依赖倒置原则
* ISP       接口分离原则


#### 为什么很多开源项目中用 **Repositories** 而不用 Model？
* 不要把数据库操作写在`Controller`中
* `Model`会变得很大怎么办
* 解耦 & SOLID
* 将`Model`注入到`Repository`，`Repository`注入到`Controller`
* **Repository模式**例子：
```php
* app/Models/User.php

<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

}



* app/Repositories/UserRepository.php
<?php namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository {
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Store user
     * @param $inputs
     * @return bool
     */
    public function store($inputs)
    {
        $user = new $this->user;
        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->password = bcrypt($inputs['password']);
        if ($user->save()) {
            return $user->id;
        }
        return false;
    }

    /**
     * Get user list
     * @param int $perPage
     * @return mixed
     */
    public function userList($perPage = 20)
    {
        return $this->user->orderBy('id', 'DESC')->paginate($perPage);
    }

    /**
     * Attach roles to user
     * @param $userId
     * @param $roles
     */
    public function attachRole($userId, $roles)
    {
        foreach ($roles as $role) {
            $this->user->find($userId)->attachRole($role);
        }
    }

    /**
     * Update User
     * @param $id
     * @param $inputs
     */
    public function update($id, $inputs)
    {
        ....
    }

    /**
     * Destroy user by id
     * @param int $id
     * @return bool|null
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return false;
        }
        $user->roles()->detach();
        Cache::forget('user:menus:' . $id);
        return $user->delete();
    }

}



* app/Controllers/UserController.php
<?php namespace App\Http\Controllers\;

use App\Http\Controllers\BaseController;
......
use App\Repositories\UserRepository;

class UserController extends BaseController {
    protected $userRepository;
    protected $roleRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->userRepository->userList(static::PER_PAGE_NUM);
        $users->setPath('');    
        ......
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateRequest $createRequest)
    {
        $userId = $this->userRepository->store($createRequest->all());
        if ($userId && ($roles = $createRequest->input('roles', []))) {
            $this->userRepository->attachRole($userId, $roles);
        }
        $alert = [
            'type' => $userId ? 'success' : 'warning',
            'data' => $userId ? ['新用户创建成功'] : ['用户创建失败'],
        ];
        ......
    }

    ......

}
```



#### 使用 **Service** 给Controller减肥
* Controller方法中的逻辑代码太长
* Controller中的逻辑代码复用
    * ~~A控制器调用B控制器的方法~~
* 一个逻辑中涉及到多Respository
* 解耦
* **Service模式**例子：
```php
* app/Services/OrderService.php
<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class OrderService
{
    protected $orderRepository;
    protected $productRepository;

    /**
     * OrderService constructor.
     * @param OrderRepository $orderRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * 结算
     * @param $id   商品ID
     * @param $status  订单状态
     * @param $num  购买数量
     */
    public function checkout($id, $status, $num)
    {
        DB::transaction(function () use ($id, $status, $num) {
            $productId = $this->orderRepository->updateStatus($id);
            $this->productRepository->stockMinusNum($productId);
        });
    }
}



* app/Repositories/OrderRepository.php
<?php
namespace App\Respositories;
......
use App\Models\Order;

class OrderRepository extends BaseRepository
{
    protected $order;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * 改变订单状态
     * @param integer $id
     * @return integer
     */
    function updateStatus($id,$status)
    {
        $order = $this->find($id);
        $order->status = $status;
        $productId = $order->product_id;
        $order->save();
        return $productId;
    }
}



* app/Repositories/ProductRepository.php
<?php
namespace App\Respositories;
......
use App\Models\Product;

class ProductRepository extends BaseRepository
{
    protected $product;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * 减少库存
     *
     * @param integer $productId
     */
    function stockMinusNum($productId,$num)
    {
        $product = $this->find($productId);
        $product->stock = $product->stock - $num;
        $product->save();
    }
}



* app/Http/Controllers/OrderController.php
<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function store($id, $status, $num)
    {
        $this->orderService->checkout($id, $status, $num);
    }
}
```


#### 实用的Debug调试工具
* Laravel-Debugbar (http://github.com/barryvdh/laravel-debugbar)


#### 自定义函数放在哪？
* 新建app/helpers.php,写入自定义函数
* app/Providers/AppServiceProvider.php
```php
/**
* Bootstrap any application services.
*
* @return void
*/
public function boot()
{
    require_once(app_path('helpers.php'));
}
```


#### 更多实用技巧
* 《50 Laravel Tricks in 50 Minutes》 (https://speakerdeck.com/willroth/50-laravel-tricks-in-50-minutes)
* Laravel Tricks (http://laravel-tricks.com/)


#### 学习资源 & 中文社区
* Laravel-awesome (https://github.com/chiraggude/awesome-laravel)
* Laravel China (https://laravel-china.org/)
* Laravel 学院 （http://laravelacademy.org/）
* Laravel 问答社区 （http://wenda.golaravel.com/）
* Laravelcasts （https://laracasts.com/）
