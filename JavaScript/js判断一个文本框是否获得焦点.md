## js 判断一个文本框是否获得焦点
```js
// 可以用document.activeElement判断
// document.activeElement表示当前活动的元素

// 查找你要判断的文本框
var myInput = document.getElementById('myInput');

if (myInput == document.activeElement) {
    alert('获取焦点');
} else {
    alert('未获取焦点');
}
```