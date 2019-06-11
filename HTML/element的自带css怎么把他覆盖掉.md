## element 的自带css怎么把他覆盖掉

* scoped 时, style 只作用于当前的组件
* 去掉 scoped, style就是作用于整个页面

* 第一种方法
```css
<style>
.parent el-range-xxxx{

}
</style>
```

* 第二种方法
```css
<style scoped>
.parent >>> el-range-xxxx{

}
</style>
```

* 给加一层父元素 class 的作用是避免污染其他不需要重置的地方
