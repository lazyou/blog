## iOS Safari 点击事件失效
* https://blog.zfanw.com/ios-safari-click-not-working/

* 我们在 jQuery 给动态添加的元素绑定事件一文里介绍过事件委托。

* 但是，iOS 的 Safari 下，委托点击事件在某些情况下会出现点击失效的问题。

* 假设我们有一个按钮，是用 div 制作的：
```html
<div id='btn'>我是按钮</div>
```

* 然后我们的 CSS 这样写：
```css
#btn {
  display: inline-block;
  background: #ccc;
  border: 1px solid #aaa;
  border-radius: 3px;
  padding: 0 5px;
  line-height: 2;
  font-size: 30px;
}
```

* 当然，我们还委托 document 给它绑一个 click 事件处理器：
```js
document.addEventListener('click', function (e) {
  if (e.target && e.target.matches('#btn')) {
    window.alert('hello ios safari')
  }
})
```

* 此时在桌面端点击是正常的，会弹出对话框，但 iOS Safari 则没反应。

* 这是移动端 Safari 至今仍存在的一个 bug 特性。

* 几个 __解决办法__：
    1. 最简单的，给 CSS 加上 `cursor: pointer`；
    2. 停止委托，直接给 `#btn` 绑定事件处理器；
    3. 给 div 元素加上 `onclick='void(0);'`；
    4. 将 div 换成其它不受该 bug 特性影响的元素，比如 a、button 等。
