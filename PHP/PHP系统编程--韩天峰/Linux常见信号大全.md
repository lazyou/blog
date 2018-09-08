## Linux 常见信号大全
* http://rango.swoole.com/archives/124

* 信号大全:
编号	    信号名称	                缺省动作	        说明
1	    SIGHUP	                终止	            终止控制终端或进程
2	    SIGINT	                终止	            键盘产生的中断(Ctrl-C)
3	    SIGQUIT	                dump	        键盘产生的退出
4	    SIGILL	                dump	        非法指令
5	    SIGTRAP	                dump	        debug中断
6	    SIGABRT／SIGIOT	        dump	        异常中止
7	    SIGBUS／SIGEMT	        dump	        总线异常/EMT指令
8	    SIGFPE	                dump	        浮点运算溢出
9	    SIGKILL	                终止	            强制进程终止
10  	SIGUSR1	                终止	            用户信号,进程可自定义用途
11  	SIGSEGV	                dump	        非法内存地址引用
12  	SIGUSR2	                终止	            用户信号，进程可自定义用途
13  	SIGPIPE	                终止	            向某个没有读取的管道中写入数据
14  	SIGALRM	                终止	            时钟中断(闹钟)
15  	SIGTERM	                终止	            进程终止
16  	SIGSTKFLT	            终止	            协处理器栈错误
17  	SIGCHLD	                忽略	            子进程退出或中断
18  	SIGCONT	                继续	            如进程停止状态则开始运行
19  	SIGSTOP	                停止	            停止进程运行
20  	SIGSTP	                停止	            键盘产生的停止
21  	SIGTTIN	                停止	            后台进程请求输入
22  	SIGTTOU	                停止	            后台进程请求输出
23  	SIGURG	                忽略	            socket发生紧急情况
24  	SIGXCPU	                dump	        CPU时间限制被打破
25  	SIGXFSZ	                dump	        文件大小限制被打破
26  	SIGVTALRM	            终止	            虚拟定时时钟
27  	SIGPROF	                终止	            profile timer clock
28  	SIGWINCH	            忽略	            窗口尺寸调整
29  	SIGIO/SIGPOLL	        终止	            I/O可用
30  	SIGPWR	                终止	            电源异常
31  	SIGSYS／SYSUNUSED	    dump	        系统调用异常
