## Ubuntu修改时区和更新时间
* https://blog.csdn.net/zhengchaooo/article/details/79500032

* `date -R` 先查看当前系统时间

* 修改时区:
```sh
tzselect // 选择对应时区地点
sudo cp /usr/share/zoneinfo/Asia/Shanghai  /etc/localtime
date -R // 查看修改结果
```
