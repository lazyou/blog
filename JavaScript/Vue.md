### Mixins
* Mixins是一种分发Vue组件中可 __代码复用__ 功能的非常灵活的一种方式

### 添加点击事件 @click 无效怎么处理
* 使用 `@click.native="XXX"`


### 触发某个 dom 的事件
* `this.$refs.inputResult.$emit('click')`

### watch 里面不能使用箭头函数, 否则调用 methods 和 data 会失败
* 为什么呢?