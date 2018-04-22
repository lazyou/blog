## ubuntu下NTFS分区无法访问解决听语音
* https://jingyan.baidu.com/article/ff42efa933addec19e220299.html

* ubuntu 挂载硬盘提示错误，磁盘挂载不上去：
```
Error mounting /dev/sda3 at /media/dms/286A099C6A0967C0: Command-line `mount -t "ntfs" -o "uhelper=udisks2,nodev,nosuid,uid=1000,gid=1000,dmask=0077,fmask=0177" "/dev/sda3" "/media/dms/286A099C6A0967C0"' exited with non-zero exit status 14: The disk contains an unclean file system (0, 0).

Metadata kept in Windows cache, refused to mount.

Failed to mount '/dev/sda3': Operation not permitted

The NTFS partition is in an unsafe state. Please resume and shutdown

Windows fully (no hibernation or fast restarting), or mount the volume

read-only with the 'ro' mount option.
```

* 打开终端
    * 运行 `sudo ntfsfix /dev/sda3` （/dev/sda3是上图中划红框的部分，根据实际情况替换）
