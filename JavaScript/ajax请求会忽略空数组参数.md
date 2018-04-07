## ajax请求会忽略空数组参数
* https://www.jianshu.com/p/d8e32e9ec712

* eg:
```js
$.ajax({
  url: 'test'，
  data:{
    a:1,
    b:[]
  }
});
```

* 此时服务端并不会收到 b
