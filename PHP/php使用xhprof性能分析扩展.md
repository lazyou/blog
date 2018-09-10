## 安装
* 编译
```sh
git clone https://github.com/longxinH/xhprof

cd xhprof/extension/

phpize

make

sudo make install

sudo apt install graphviz # 后续查看统计图
```

* 配置：
```sh
sudo echo 'extension=xhprof.so' > /etc/php/7.0/mods-available/xhprof.ini
sudo ln -s /etc/php/7.0/mods-available/xhprof.ini /etc/php/7.0/fpm/conf.d/20-xhprof.ini
sudo ln -s /etc/php/7.0/mods-available/xhprof.ini /etc/php/7.0/cli/conf.d/20-xhprof.ini
```

* `sudo vim /etc/php/7.0/fpm/php.ini` 
```ini
[xhprof]
xhprof.output_dir=/var/www/xhprof_logs ; 建议解析此目录方便日志查看
```


## 使用
* 项目里内置代码目录：
```conf
xhprof/examples # 案例

xhprof/xhprof_lib # 工具类

xhprof/xhprof_html # 日志查看
```

* eg: xhprof_test.php
```php
<?php
function test() {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://www.baidu.com");
  $output = curl_exec($ch);
  curl_close($ch);
}

function getUsers() {
  $mysqli = new mysqli("localhost", "root", "mysql112233", "saas_final");
  $result = $mysqli->query("SELECT * FROM user LIMIT 10");
}
// start profiling
// xhprof_enable();
xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);

// run program
test();

getUsers();

// stop profiler
$xhprof_data = xhprof_disable();

// display raw xhprof data for the profiler run
print_r($xhprof_data);

//加载所需文件
include_once "../xhprof_lib/utils/xhprof_lib.php";
include_once "../xhprof_lib/utils/xhprof_runs.php";

// save raw data for this profiler run using default
// implementation of iXHProfRuns.
$xhprof_runs = new XHProfRuns_Default();

// save the run under a namespace "xhprof_foo"
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");

echo "---------------\n".
     "Assuming you have set up the http based UI for \n".
     "XHProf at some address, you can view run at \n".
     "http://www.xhprof_logs.test/index.php?run=$run_id&source=xhprof_foo\n".
     "---------------\n";
```


## 日志参数
```
Function Name：方法名称。

Calls：方法被调用的次数。

Calls%：方法调用次数在同级方法总数调用次数中所占的百分比。

Incl.Wall Time(microsec)：方法执行花费的时间，包括子方法的执行时间。（单位：微秒）

IWall%：方法执行花费的时间百分比。

Excl. Wall Time(microsec)：方法本身执行花费的时间，不包括子方法的执行时间。（单位：微秒）

EWall%：方法本身执行花费的时间百分比。

Incl. CPU(microsecs)：方法执行花费的CPU时间，包括子方法的执行时间。（单位：微秒）

ICpu%：方法执行花费的CPU时间百分比。

Excl. CPU(microsec)：方法本身执行花费的CPU时间，不包括子方法的执行时间。（单位：微秒）

ECPU%：方法本身执行花费的CPU时间百分比。

Incl.MemUse(bytes)：方法执行占用的内存，包括子方法执行占用的内存。（单位：字节）

IMemUse%：方法执行占用的内存百分比。

Excl.MemUse(bytes)：方法本身执行占用的内存，不包括子方法执行占用的内存。（单位：字节）

EMemUse%：方法本身执行占用的内存百分比。

Incl.PeakMemUse(bytes)：Incl.MemUse峰值。（单位：字节）

IPeakMemUse%：Incl.MemUse峰值百分比。

Excl.PeakMemUse(bytes)：Excl.MemUse峰值。单位：（字节）

EPeakMemUse%：Excl.MemUse峰值百分比。
```