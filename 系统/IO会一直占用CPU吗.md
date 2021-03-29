## I/O会一直占用CPU吗
* https://www.zhihu.com/question/27734728

* 阻塞io情况下，比如磁盘io，accept ，read，recv，write等调用导致进程或者线程阻塞，这时候线程/进程 会占用cpu吗？比如连接mysql，执行一条需要执行很长的sql语句，recv调用的时候阻塞了，这个时候会不会大量占用cpu时间？磁盘io是什么操作，比如linux调用cp拷贝大文件的时候会大量占用cpu吗？


### 
* __IO所需要的CPU资源非常少__, 大部分工作是分派给DMA完成的。

* CPU是不会直接和硬盘对话的，他们之间有个中间人，叫DMA（Direct Memory Access）芯片.

* 过程: CPU计算文件地址 -> 委派DMA读取文件 -> DMA接管总线 -> CPU的A进程阻塞，挂起 -> CPU切换到B进程 -> DMA读完文件后通知CPU（一个中断异常） -> CPU切换回A进程操作文件
