### 简述
* 重点： 
    * 理解HTTP Basic的原理
    * 如何使用 （例如在php中使用 http basic）
* https://zh.wikipedia.org/wiki/HTTP%E5%9F%BA%E6%9C%AC%E8%AE%A4%E8%AF%81
***


### 内容

#### 什么是HTTP Basic
> 在HTTP中，基本认证是一种用来允许Web浏览器或其他客户端程序在请求时*提供用户名和口令形式的身份凭证的一种登录验证方式*。
>
> 在发送之前是以用户名追加一个冒号然后串接上口令，并将得出的结果字符串再用*Base64算法*编码。例如，提供的用户名是Aladdin、口令是open sesame，则拼接后的结果就是Aladdin:open sesame，然后再将其用`Base64`编码，得到`QWxhZGRpbjpvcGVuIHNlc2FtZQ==`。最终将Base64编码的字符串发送出去，由接收者解码得到一个由冒号分隔的用户名和口令的字符串。
>
> 虽然对用户名和口令的Base64算法编码结果很难用肉眼识别解码，但它仍可以极为轻松地被计算机所解码，就像其容易编码一样。编码这一步骤的目的并不是安全与隐私，而是为将用户名和口令中的不兼容的字符转换为均与HTTP协议兼容的字符集。
>
> 最初，基本认证是定义在HTTP 1.0规范（RFC 1945）中，后续的有关安全的信息可以在HTTP 1.1规范（RFC 2616）和HTTP认证规范（RFC 2617）中找到。


#### 优点
* 基本所有流行的网页浏览器都会支持基本认证。


#### 缺点
* 在没有SSL/TLS这样的传输层安全的协议，以明文传输的密钥和口令很容易被拦截。
* 除了关闭标签页或浏览器或清除用户历史记录， 没有有效的退出登录方法。


#### 例子（php使用HTTP Basic）
* http://www.php.net/manual/en/features.http-auth.php
```php
<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    // 必须有 WWW-Authenticate 才能使用 HTTP Basic
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
} else {
    echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
}
```

* *输入帐号密码点确认后*看到请求头信息 `Authorization`
    * `Authorization:Basic MjIzMzo0NDQ1NTU=` 其中 `MjIzMzo0NDQ1NTU=` base64解码为 `2233:444555`
* *直接点取消*后看到响应头信息
    * `WWW-Authenticate:Basic realm="My Realm"`
    * `Status Code:401 Unauthorized`