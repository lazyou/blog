## php tips
* json 解码并美化输出： `json_encode($jsonString, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);`

* 获取客户端 IP： `$_SERVER['REMOTE_ADDR']` 最可靠

* PHP自带的过滤器: `filter_var` http://php.net/manual/zh/function.filter-var.php
