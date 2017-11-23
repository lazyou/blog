### Virtualbox虚拟机Linux Guest的Additions安装方法
* https://my.oschina.net/jsk/blog/289275

* 如果是windows做Guest，直接单击菜单栏 "Insert Guest Additions CD Image... " 就可以将 Additions CD 自动加载到Guest里的虚拟光驱里，但是Linux是不行的，**因为Linux需要root权限才可以mount CD Image**。
    * 做法是在Guest里打开终端，输入：`sudo mount /dev/sr0  /media/cdrom`

    * 把sr0挂载到 /media/cdrom 里，如果没有cdrom，可以先mkdir一个，挂载到其他位置也可以。

    * 然后查看一下
        ```
        jesse@jesse-VirtualBox ~ $ ls /media/cdrom/
        32Bit        cert                    VBoxSolarisAdditions.pkg
        64Bit        OS2                     VBoxWindowsAdditions-amd64.exe
        AUTORUN.INF  runasroot.sh            VBoxWindowsAdditions.exe
        autorun.sh   VBoxLinuxAdditions.run  VBoxWindowsAdditions-x86.exe
        ```
    * 里面有 `VBoxLinuxAdditions.run` 这一项，直接运行即可: `sudo sh ./VBoxLinuxAdditions.run`

    * 安装后，`reboot` 一下就可以了。


### 把 window 下的目录共享文件夹到 virtualbox 的 linux 系统下
* http://blog.csdn.net/lydyangliu/article/details/12278945

* 现在虚拟机的设置 => 共享文件夹 分配要挂载的目录.

* 然后运行 `sudo mount -t vboxsf rainbowdog /mnt/codes/`

* 最后 `cd /mnt/codes/` 就能看见挂载进来的目录
