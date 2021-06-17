<?php
// TODO: 注意--这里除了 两个魔术方法，其他都要方法的可见度不能为 public
class Model {
    // 定义查询所需要的参数
    protected $table;
    protected $wheres;
    protected $limit;
    protected $columns;

    // 获取表名,如果没有定义，将类名转换为复数形式后，在转换为「蛇式」命名，设置表名
    // 例如 User 会转变为 users
    protected function getTable()
    {
        if (! isset($this->table)) {
            return 'table_name';
            // return str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
        }

        return $this->table;
    }

    // 根据上面的一些条件拼装sql;
    protected function toSql()
    {
        // 这里实现步骤大家可以自己去拼写
        $sql = '';

        return $sql;
    }

    protected function get($columns = ['*'])
    {
        $this->columns = $columns;

        // 执行mysql语句
        // $results = mysql_query($this->toSql());
        $results = [];

        return $results;
    }

    // 设置参数
    public function take($value)
    {
        return $this->limit = $value;
    }

    public function first($columns)
    {
        return $this;
    }

    public function where($column, $operator = null, $value = null)
    {
        $this->wheres[] = [];
        return $this;
    }

    // TODO: 这里不能为 public, 因为外部使用静态方法的方式调用，优先级较高，会报错 find 不是静态方法
    protected function find($id, $columns = ['*'])
    {
        return $this->where($this->primaryKey, '=', $id)->first($columns);
    }

    public function __call($method, $parameters)
    {
        echo '__call: ';
        var_dump($method);
        var_dump(...$parameters);

        return $this->$method(...$parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        echo '__callStatic: ';
        var_dump($method);
        var_dump(...$parameters);

        return (new static)->$method(...$parameters);
    }
}


class Article extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'article';
}


Article::find(1);
