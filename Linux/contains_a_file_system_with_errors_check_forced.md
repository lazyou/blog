## ubuntu 系统的笔记本没电以后再开机出现如下的问题
```
/dev/sda1 contains a file system with errors, check forced.
Inodes that were part of a corrupted orphan linked list found.

/dev/sda1: UNEXPECTED INCONSISTENCY: RUN fsck MANUALLY.
         (i.e., without -a or -p options)
fsck exited with status code 4
The root filesystem on /dev/sda1 requires a manual fsck

BusyBox v1.22.1 (Ubuntu 1:1.22.0-19ubuntuu2) built-in shell (ash)
Enter 'help' for a list of built-in commands.

(initramfs)_
```

* 解决方式:
    * At the (initramfs) prompt, type `fsck -f /dev/sda1` to check/repair your file system.
