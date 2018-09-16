## linux下设置程序只开启单个实例
* 一些特殊情况下，使用快捷键快速切换已开启程序 无已开启则新开启 __可以提高效率__

* 首先安装 `wmctrl`， `sudo apt install wmctrl`

* restore.sh
```sh
#!/bin/bash
# -*- coding: utf-8 -*-
# https://www.quora.com/How-do-I-allow-only-one-instance-of-Terminal-in-Ubuntu
# eg: ./restore.sh xfce4-appfinder

# 以下三种功能方式均不能正确找到 terminator 的 pid
#     TPID=$(pgrep -f $app_name)
#     TPID=$(pidof $app_name || pgrep -f $app_name)
#     TPID=$(ps x | grep $app_name | grep -v grep | awk '{print $1}')
# else

app_name=$1

TPID=$(ps aux | pgrep $app_name)

if [ "$TPID" ] 
then
    wmctrl -xa $app_name
else
    # run-one $app_name &
    $app_name &
fi
```

* 使用脚本：
    * 设置快捷键 `Super + R` 执行 `sh /home/lin/Public/restore.sh xfce4-appfinder`
    * NOTE: xfce4-appfinder 需要设置取消勾选 Keep running instance in the background
    * NOTE: terminator 使用次脚本行不通，关于它的 pid 获取有问题
