## 表单中 readonly 和 disabled 的区别
* https://blog.csdn.net/u012717614/article/details/80137939

* 两种属性的写法如下：
```html
<input type="text" name="name" value="xxx" disabled />
<input type="text" name="name" value="xxx" readonly />
```

* 这两种写法都会使显示出来的文本框不能输入文字

* 但 disabled 会使文本框变灰，而且通过通过表单提交时， __获取不到文本框中的value值__（如果有的话）

* 而 readonly 只是使文本框不能输入，外观没有变化，而且表单提交时不影响获取 value 值

* readonly 只针对 input(text / password) 和 textarea 有效，而 disabled 对于所有的表单元素都有效，包括 select, radio, checkbox, button 等
