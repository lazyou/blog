## SSL与TLS的区别和联系
* https://www.jianshu.com/p/d79162feb608


### SSL 的由来
* SSL(Secure Socket Layer 安全套接层)是 TCP/IP 协议中基于HTTP之下TCP之上的一个可选协议层。

* 起初 HTTP 在传输数据时使用的是明文，是不安全的。为了解决这个隐患，网景（Netscap）公司推出了SSL。而越来越多的人也开始使用 __HTTPS（HTTP+SSL）__


### TLS 的由来
* HTTPS 的推出受到了很多人的欢迎，在 SSL 更新到3.0时， 互联网工程任务组（IETF）对 SSL3.0 进行了标准化，并添加了少数机制（但是几乎和SSL3.0无差异），并将其更名为 TLS1.0(Transport Layer Security 安全传输层协议)，可以说 TLS就是 SSL 的新版本3.1


### SSL 和 TLS 的联系
1. SSL是TLS的前世，TLS是SSL的今生

2. TLS与SSL连接过程无任何差异

3. TLS与SSL的两个协议（记录协议和握手协议）协作工作方式是一样的


### SSL 和 TLS 的区别
1. SSL 与 TLS 两者所使用的算法是不同的

2. TLS 增加了许多新的报警代码，比如解密失败(decryption_failed)、记录溢出(record_overflow)、未知CA(unknown_ca)、拒绝访问(access_denied)等，但同时也支持SSL协议上所有的报警代码!

> 由于这些区别的存在，我们可认为TLS是SSL的不兼容增强版。即TLS和SSL不能共用。

> 在认证证书时TLS指定必须与TLS之间交换证书， SSL必须与SSL之间交换证书。
