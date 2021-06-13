### 内存调整
* `vim config/jvm.options` 添加如下（或去掉注释）
```sh
-Xms4g
-Xmx4g
```

* 或者在启动时设置 `./bin/elasticsearch -Xmx10g -Xms10g`
