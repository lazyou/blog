##
* https://learnku.com/laravel/t/25013

* https://github.com/ErickTamayo/laravel-scout-elastic

### laravel8 中使用记录
```
composer require elasticsearch/elasticsearch

composer require tamayo/laravel-scout-elastic

php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
    config/scout.php 配置
    'driver' => env('SCOUT_DRIVER', 'elasticsearch'),

    'elasticsearch'=> [
        'index' => env('ELASTICSEARCH_INDEX', 'laravel8'),

        'hosts' => [
            env('ELASTICSEARCH_HOST', 'localhost'),
        ],


php artisan scout:import "App\Models\Warehouse"

# 更多调用参考： https://learnku.com/docs/laravel/8.x/scout/9422
```


### TODO
* 可开启队列导入数据

* 然而感觉并不好用

* 如何搜索制定字段？
