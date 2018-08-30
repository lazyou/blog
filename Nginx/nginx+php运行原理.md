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
