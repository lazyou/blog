## 参考
* https://segmentfault.com/a/1190000014610688


## nginx+php运行原理
1. nginx 的 `worker进程` 直接管理每一个请求到nginx的网络请求。

2. 对于php而言，由于在整个网络请求的过程中 _php 是一个 `cgi程序` 的角色_，所以采用名为 `php-fpm 的进程管理程序` 来对这些被请求的php程序进行管理。
    * php-fpm 程序也如同 nginx 一样，需要监听端口，并且有 master 和 worker 进程。worker进程直接管理每一个 php 进程。

3. 关于 `fastcgi`： _fastcgi 是一种进程管理器，管理 cgi 进程_。市面上有多种实现了 fastcgi 功能的进程管理器，php-fpm 就是其中的一种。再提一点，php-fpm 作为一种 fast-cgi 进程管理服务，会监听端口，一般 `默认监听 9000 端口，并且是监听本机`，也就是只接收来自本机的端口请求，所以我们通常输入命令 `netstat -nlpt | grep php-fpm` (TODO: 没效果) 会得到： `tcp 0 0 127.0.0.1:9000 0.0.0.0:* LISTEN 1057/php-fpm` 这里的127.0.0.1:9000 就是监听本机9000端口的意思。

4. 关于 fastcgi 的配置文件，目前 fastcgi 的配置文件一般放在 nginx.conf 同级目录下，配置文件形式，一般有两种： `fastcgi.conf` 和 `fastcgi_params`。
    * 不同的 nginx 版本会有不同的配置文件，这两个配置文件有一个非常重要的区别： fastcgi_parames 文件中缺少下列配置： `fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;` 我们可以打开`fastcgi_parames` 文件加上上述行，也可以在要使用配置的地方动态添加。使得该配置生效。

5. 当需要处理 php 请求时，`nginx 的 worker 进程` 会将请求移交给 `php-fpm 的 worker 进程` 进行处理，也就是最开头所说的 nginx 调用了 php，其实严格得讲是 nginx 间接调用php。


## php-fpm socket 监听与端口监听切换
* `sudo vim /etc/php/7.0/fpm/pool.d/www.conf` 的 `listen = ` 配置：
```
listen = /run/php/php7.0-fpm.sock
; listen = 127.0.0.1:9000
```


## 深入理解PHP之：Nginx 与 FPM 的工作机制
* https://www.imooc.com/article/38194


* 要说 Nginx 与 PHP 是如何协同工作的，首先得说 `CGI (Common Gateway Interface)` 和 `FastCGI` 这两个协议。

* CGI 的缺点： CGI 有一个致命的缺点，那就是每处理一个请求都需要 fork 一个全新的进程


* 所以有了 FastCGI: FastCGI，顾名思义为更快的 CGI，它允许在一个进程内处理多个请求，而不是一个请求处理完毕就直接结束进程，性能上有了很大的提高。


* 至于 `FPM (FastCGI Process Manager)`，它是 FastCGI 的实现，任何实现了 FastCGI 协议的 Web Server 都能够与之通信。
    * FPM 是一个 PHP 进程管理器，包含 `master 进程` 和 `worker 进程` 两种进程：
        * _master 进程_ 只有一个，负责监听端口，接收来自 Web Server 的请求
        * _worker 进程_ 则一般有多个 (具体数量根据实际需要配置)，每个进程内部都嵌入了一个 PHP 解释器，__是 PHP 代码真正执行的地方__，下图是我本机上 fpm 的进程情况，1一个 master 进程，3个 worker 进程：

    * 从 FPM 接收到请求，到处理完毕，其具体的流程如下：
        1. FPM 的 master 进程接收到请求;
        2. master 进程根据配置指派特定的 worker 进程进行请求处理，如果没有可用进程，返回错误，这也是我们配合 Nginx 遇到502错误比较多的原因;
        3. worker 进程处理请求，如果超时，返回504错误;
        4. 请求处理结束，返回结果


* Nginx 又是如何发送请求给 fpm: 代理 (走端口 或者 走socket通信)
    * Nginx 不仅仅是一个 Web 服务器，也是一个功能强大的 _Proxy 服务器_，除了进行 http 请求的代理，也可以进行许多其他协议请求的代理，包括本文与 fpm 相关的 fastcgi 协议。

    * 为了能够使 Nginx 理解 fastcgi 协议，_Nginx 提供了 fastcgi 模块来将 http 请求映射为对应的 fastcgi 请求_

    * Nginx 的 fastcgi 模块提供了 fastcgi_param 指令来主要处理这些映射关系，下面 Ubuntu 下 Nginx 的一个配置文件，其主要完成的工作是 _将 Nginx 中的变量翻译成 PHP 中能够理解的变量_。
        * 默认 fastcgi_param 指令配置在 `/etc/nginx/fastcgi_params` 或者 `/etc/nginx/fastcgi.conf`
