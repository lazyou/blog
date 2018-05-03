### 查看CPU
```sh
more /proc/cpuinfo | grep "model name"

grep "model name" /proc/cpuinfo

如果觉得需要看的更加舒服

grep "model name" /proc/cpuinfo | cut -f2 -d:
```


### 查看内存
```sh
grep MemTotal /proc/meminfo

grep MemTotal /proc/meminfo | cut -f2 -d:

free -m |grep "Mem" | awk '{print $2}'
```


### 查看cpu是32位还是64位
```sh
getconf LONG_BIT

echo $HOSTTYPE

uname -a
```


### 查看当前linux的版本 (redhat 系列)
```sh
more /etc/RedHat-release

cat /etc/redhat-release
```


### 查看内核版本
```sh
uname -r

uname -a
```


### 查看硬盘和分区
```sh
df -h

fdisk -l
```


### 查看ip，mac地址 -- 在ifcfg-eth0 文件里你可以看到mac，网关等信息
```sh
ifconfig
```
