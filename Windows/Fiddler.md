## Fiddler抓包工具总结
```
* https://www.cnblogs.com/yyhh/p/5140852.html
1. Fiddler 抓包简介
    1） 字段说明
    2）. Statistics 请求的性能数据分析
    3）. Inspectors 查看数据内容
    4）. AutoResponder 允许拦截指定规则的请求
    4）. Composer 自定义请求发送服务器
    5）. Filters 请求过滤规则
2. Fiddler 设置解密HTTPS的网络数据
3. Fiddler 抓取Iphone / Android数据包
4. Fiddler 内置命令与断点
```


## 转发请求或响应
* Rules -> Customize Rules

* 找到 `static function OnBeforeResponse`

* 添加如下代码:
```c#
if (
    oSession.fullUrl.Contains("mp.weixin.qq.com/mp/profile_ext?action=home") ||
    oSession.fullUrl.Contains("mp.weixin.qq.com/mp/profile_ext?action=getmsg")
    )
{
    oSession.utilDecodeResponse();//消除保存的请求可能存在乱码的情况

    var url = oSession.url;
    var urlBytes = System.Text.Encoding.UTF8.GetBytes(url);
    var urlBase64 = System.Convert.ToBase64String(urlBytes);

    var responseCode = oSession.responseCode;
    var responseCodeBytes = System.Text.Encoding.UTF8.GetBytes(responseCode);
    var responseCodeBase64 = System.Convert.ToBase64String(responseCodeBytes);

    var responseHeaders = oSession.oResponse.headers;
    var responseHeadersBytes = System.Text.Encoding.UTF8.GetBytes(oSession.oResponse.headers);
    var responseHeadersBase64 = System.Convert.ToBase64String(responseHeadersBytes);

    var responseBody = oSession.GetResponseBodyAsString();
    var responseBodyBytes = System.Text.Encoding.UTF8.GetBytes(responseBody);
    var responseBodyBase64 = System.Convert.ToBase64String(responseBodyBytes);

    // // local
    // var fso;
    // var file;
    // fso = new ActiveXObject("Scripting.FileSystemObject");
    // //文件保存路径，可自定义
    // file = fso.OpenTextFile("C:\\FiddlerTestResponse.txt",8 ,true, true);
    // file.writeLine("url: " + urlBase64);
    // file.writeLine("responseCode: " + responseCodeBase64);

    // file.writeLine("responseHeaders:");
    // file.writeLine("" + responseHeadersBase64);

    // file.writeLine("responseBody: ");
    // file.writeLine(responseBodyBase64);
    // file.writeLine("\n");
    // file.close();

    // http
    var data = '{' +
        '"url":"' + urlBase64 + '",' +
        '"responseCode":"' + responseCodeBase64 + '",' +
        '"responseHeaders":"' + responseHeadersBase64 + '",' +
        '"responseBody":"' + responseBodyBase64 + '"' +
    '}';

    // http data debug
    var fsoData;
    var fileData;
    fsoData = new ActiveXObject("Scripting.FileSystemObject");
    //文件保存路径，可自定义
    fileData = fsoData.OpenTextFile("C:\\FiddlerData.txt",8 ,true, true);
    fileData.writeLine(data);
    fileData.close();

    // 通过 xhr 转发请求到你的服务器接口上 (然后你就可以拿着数据再次处理了)
    var xhr = new ActiveXObject("Microsoft.XMLHTTP");
    var url = "http://www.mp.test/fiddler_test";
    // 不需要返回值所以写啦个空回调
    xhr.onreadystatechange = function() {};
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send(data);
}
```
