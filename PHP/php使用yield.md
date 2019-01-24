## PHP yield应用
* https://courages.us/archives/524


### 
* PHP 5.5开始新增了神奇的关键字 yield，能够从生成器（generators）中返回数据。yield 有点像普通函数中的关键字 return，但是不会彻底停止函数的执行（普通函数一旦 return 便不执行了），可以暂停循环并返回值，每一次调用便从中断处继续迭代。生成器可以用于替代循环迭代，每一次调用返回一个生成器对象（generator）。

* 评论: PHP的yield与return的区别在于：yield跟return一样具有中断函数执行的效果，但yield的函数，再次调用又可以从中断处继续执行。强调这一点，比较容易理解PHP的协程，也能明白起限制性。

* yield能够延迟执行，可以用于对大量数据进行迭代而不用预先在内存中生成数组。例如动态生成一个大数组：
```php
function xrange($start, $end, $step = 1)
{
    for ($i = $start; $i <= $end; $i += $step) {
        yield $i;
    }
}

$range = xrange(1, 10);

foreach ($range as $num) {
    echo $num, "\n";
}

var_dump($range); // object(Generator)#1
var_dump($range instanceof Iterator); // bool(true)
```


* 利用yield简便、高效的生成fibonacci数列而不是循环或递归:
```php
function fibonacci($count)
{
    $prev = 0;
    $current = 1;

    for ($i = 0; $i < $count; ++$i) {
        yield $prev;
        $next = $prev + $current;
        $prev = $current;
        $current = $next;
    }
}

foreach (fibonacci(12) as $i => $value) {
    echo $i, ' -> ', $value, PHP_EOL;
}
```


* 利用yield来循环读取文件，而不需要像file函数那样一次性加载进来，节省内存:
```php
<?php
function file_lines($filename) {
    $file = fopen($filename, 'r'); 
    while (($line = fgets($file)) !== false) {
        yield $line; 
    } 
    fclose($file); 
}
  
foreach (file_lines('somefile') as $line) {
    // do some work here
}
```


* yield除了能够返回值，用作变量时还可以接收值:
```php
function logger($fileName)
{
    $fileHandle = fopen($fileName, 'a');
    while (true) {
        fwrite($fileHandle, yield  . "\n");
    }
}

$logger = logger(__DIR__ . '/log');
$logger->send('Foo');
$logger->send('Bar');
```


* 由于yield具有中断执行后再次调用又可以从中断处执行，外界又可以通过生成器对象（generator）的send方法进行交互，可以用于协程（coroutine），作多任务协作的流程控制。这里有个例子：
```php
class Task
{
    protected $taskId;
    protected $coroutine;
    protected $sendValue = null;
    protected $beforeFirstYield = true;

    public function __construct($taskId, Generator $coroutine)
    {
        $this->taskId = $taskId;
        $this->coroutine = $coroutine;
    }

    public function getTaskId()
    {
        return $this->taskId;
    }

    public function setSendValue($sendValue)
    {
        $this->sendValue = $sendValue;
    }

    public function run()
    {
        if ($this->beforeFirstYield) {
            $this->beforeFirstYield = false;
            return $this->coroutine->current();
        } else {
            $retval = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;
            return $retval;
        }
    }

    public function isFinished()
    {
        return !$this->coroutine->valid();
    }
}

class Scheduler
{
    protected $maxTaskId = 0;
    protected $taskMap = []; // taskId => task
    protected $taskQueue;

    public function __construct()
    {
        $this->taskQueue = new SplQueue();
    }

    public function newTask(Generator $coroutine)
    {
        $tid = ++$this->maxTaskId;
        $task = new Task($tid, $coroutine);
        $this->taskMap[$tid] = $task;
        $this->schedule($task);
        return $tid;
    }

    public function schedule(Task $task)
    {
        $this->taskQueue->enqueue($task);
    }

    public function run()
    {
        while (!$this->taskQueue->isEmpty()) {
            $task = $this->taskQueue->dequeue();
            $task->run();

            if ($task->isFinished()) {
                unset($this->taskMap[$task->getTaskId()]);
            } else {
                $this->schedule($task);
            }
        }
    }
}

function task1()
{
    for ($i = 1; $i <= 10; ++$i) {
        echo "This is task 1 iteration $i.\n";
        yield;
    }
}

function task2()
{
    for ($i = 1; $i <= 5; ++$i) {
        echo "This is task 2 iteration $i.\n";
        yield;
    }
}

$scheduler = new Scheduler;
$scheduler->newTask(task1());
$scheduler->newTask(task2());
$scheduler->run();
```

* 有些任务是需要交互进行的，如socket的监听和回复；有些任务异步执行又需要回调，如A执行不阻塞程序，但B执行又取决于A是否执行完毕。这些都可以使用yield来进行封装，达到流程控制的目的。
