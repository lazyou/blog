## PHP 实现 JWT 认证方法
* https://segmentfault.com/a/1190000016251365

### JWT 是什么
> JWT 是 json web token 缩写。它将用户信息加密到 token 里，服务器不保存任何用户信息。服务器通过使用保存的密钥验证 token 的正确性，只要正确即通过验证。基于 token 的身份验证可以替代传统的 cookie+session 身份验证方法。

> JWT由三个部分组成：`header.payload.signature`

#### header 部分
```json
{
  "alg": "HS256",
  "typ": "JWT"
}
```

* 对应base64UrlEncode编码为：eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9

* 说明：该字段为 json 格式。alg 字段指定了生成 signature 的算法，默认值为 HS256，typ 默认值为 JWT


#### payload 部分
```json
{
  "sub": "1234567890",
  "name": "John Doe",
  "iat": 1516239022
}
```

* 对应base64UrlEncode编码为：`eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ`

* 说明：该字段为json格式，表明用户身份的数据，可以自己自定义字段，很灵活。sub 面向的用户，name 姓名 ,iat 签发时间。例如可自定义示例如下：
```json
{
    "iss": "admin",          //该JWT的签发者
    "iat": 1535967430,        //签发时间
    "exp": 1535974630,        //过期时间
    "nbf": 1535967430,         //该时间之前不接收处理该Token
    "sub": "www.admin.com",   //面向的用户
    "jti": "9f10e796726e332cec401c569969e13e"   //该Token唯一标识
}
```


#### signature 部分
```
HMACSHA256(
  base64UrlEncode(header) + "." +
  base64UrlEncode(payload),
  123456
)
```

* 对应的签名为：`keH6T3x1z7mmhKL1T3r9sQdAxxdzB6siemGMr_6ZOwU`

* 最终得到的 JWT 的 json 为(`header.payload.signature`)：`eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.keH6T3x1z7mmhKL1T3r9sQdAxxdzB6siemGMr_6ZOwU`

* 说明：对 header 和 payload 进行 base64UrlEncode 编码后进行拼接。通过 key（这里是123456）进行 HS256 算法签名。


### JWT使用流程
1. 初次登录：用户初次登录，输入用户名密码;
2. 密码验证：服务器从数据库取出用户名和密码进行验证;
3. 生成 JWT：服务器端验证通过，根据从数据库返回的信息，以及预设规则，生成 JWT;
4. 返还 JWT：服务器的 HTTP RESPONSE 中将 JWT 返还;
5. 带JWT的请求：以后客户端发起请求，HTTP REQUEST;
6. HEADER 中的 Authorization 字段都要有值，为 JWT;
7. 服务器验证 JWT;


### PHP 如何实现 JWT
* 作者使用的是PHP 7.0.31，不废话，直接上代码，新建 jwt.php，复制粘贴如下：
```php
<?php
/**
 * PHP实现jwt
 */
class Jwt
{
    //头部
    private static $header = array(
        'alg' => 'HS256', //生成signature的算法
        'typ' => 'JWT', //类型
    );

    //使用HMAC生成信息摘要时所使用的密钥
    private static $key = '123456';

    /**
     * 获取jwt token
     * @param array $payload jwt载荷   格式如下非必须
     * [
     *  'iss'=>'jwt_admin',  //该JWT的签发者
     *  'iat'=>time(),  //签发时间
     *  'exp'=>time()+7200,  //过期时间
     *  'nbf'=>time()+60,  //该时间之前不接收处理该Token
     *  'sub'=>'www.admin.com',  //面向的用户
     *  'jti'=>md5(uniqid('JWT').time())  //该Token唯一标识
     * ]
     * @return bool|string
     */
    public static function getToken(array $payload)
    {
        if (is_array($payload)) {
            $base64header = self::base64UrlEncode(json_encode(self::$header, JSON_UNESCAPED_UNICODE));
            $base64payload = self::base64UrlEncode(json_encode($payload, JSON_UNESCAPED_UNICODE));
            $token = $base64header . '.' . $base64payload . '.' . self::signature($base64header . '.' . $base64payload, self::$key, self::$header['alg']);
            return $token;
        } else {
            return false;
        }
    }

    /**
     * 验证token是否有效,默认验证exp,nbf,iat时间
     * @param string $Token 需要验证的token
     * @return bool|string
     */
    public static function verifyToken(string $Token)
    {
        $tokens = explode('.', $Token);
        if (count($tokens) != 3) {
            return false;
        }

        list($base64header, $base64payload, $sign) = $tokens;

        //获取jwt算法
        $base64decodeheader = json_decode(self::base64UrlDecode($base64header), JSON_OBJECT_AS_ARRAY);
        if (empty($base64decodeheader['alg'])) {
            return false;
        }

        //签名验证
        if (self::signature($base64header . '.' . $base64payload, self::$key, $base64decodeheader['alg']) !== $sign) {
            return false;
        }

        $payload = json_decode(self::base64UrlDecode($base64payload), JSON_OBJECT_AS_ARRAY);

        //签发时间大于当前服务器时间验证失败
        if (isset($payload['iat']) && $payload['iat'] > time()) {
            return false;
        }

        //过期时间小宇当前服务器时间验证失败
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }

        //该nbf时间之前不接收处理该Token
        if (isset($payload['nbf']) && $payload['nbf'] > time()) {
            return false;
        }

        return $payload;
    }

    /**
     * base64UrlEncode   https://jwt.io/  中base64UrlEncode编码实现
     * @param string $input 需要编码的字符串
     * @return string
     */
    private static function base64UrlEncode(string $input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * base64UrlEncode  https://jwt.io/  中base64UrlEncode解码实现
     * @param string $input 需要解码的字符串
     * @return bool|string
     */
    private static function base64UrlDecode(string $input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $addlen = 4 - $remainder;
            $input .= str_repeat('=', $addlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * HMACSHA256签名   https://jwt.io/  中HMACSHA256签名实现
     * @param string $input 为base64UrlEncode(header).".".base64UrlEncode(payload)
     * @param string $key
     * @param string $alg   算法方式
     * @return mixed
     */
    private static function signature(string $input, string $key, string $alg = 'HS256')
    {
        $alg_config = array(
            'HS256' => 'sha256',
        );
        return self::base64UrlEncode(hash_hmac($alg_config[$alg], $input, $key, true));
    }
}

//测试和官网是否匹配begin
$payload = array('sub' => '1234567890', 'name' => 'John Doe', 'iat' => 1516239022);
$jwt = new Jwt;
$token = $jwt->getToken($payload);
echo "<pre>";
echo $token;

//对token进行验证签名
$getPayload = $jwt->verifyToken($token);
echo "<br><br>";
var_dump($getPayload);
echo "<br><br>";
//测试和官网是否匹配end

//自己使用测试begin
$payload_test = array('iss' => 'admin', 'iat' => time(), 'exp' => time() + 7200, 'nbf' => time(), 'sub' => 'www.admin.com', 'jti' => md5(uniqid('JWT') . time()));
$token_test = Jwt::getToken($payload_test);
echo "<pre>";
echo $token_test;

//对token进行验证签名
$getPayload_test = Jwt::verifyToken($token_test);
echo "<br><br>";
var_dump($getPayload_test);
echo "<br><br>";
//自己使用时候end
```
