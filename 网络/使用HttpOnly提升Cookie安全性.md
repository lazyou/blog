## 使用 HttpOnly 提升 Cookie 安全性
* https://www.cnblogs.com/zlhff/p/5477943.html

* 如何获得 Cookie 劫持呢?在浏览器中的 document 对象中，就储存了 Cookie 的信息，而利用 js 可以把这里面的 Cookie 给取出来，只要得到这个 Cookie 就可以拥有别人的身份了。

* 如何保障我们的 Cookie 安全呢？Cookie 都是通过 document 对象获取的，我们如果能让 cookie 在浏览器中不可见就可以了，那 HttpOnly 就是在设置 cookie 时接受这样一个参数，一旦被设置，在浏览器的 document 对象中就看不到 cookie 了。而浏览器在浏览网页的时候不受任何影响，因为 Cookie 会被放在浏览器头中发送出去(包括Ajax的时候)，应用程序也一般不会在JS里操作这些敏感 Cookie 的，对于一些敏感的 Cookie 我们采用 HttpOnly，对于一些需要在应用程序中用JS操作的 cookie 我们就不予设置，这样就保障了 Cookie 信息的安全也保证了应用。

* PHP 中设置
```php
<?php
ini_set("session.cookie_httponly", 1);
```
