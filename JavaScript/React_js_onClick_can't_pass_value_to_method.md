## React js onClick can't pass value to method
* https://stackoverflow.com/questions/29810914/react-js-onclick-cant-pass-value-to-method

* react 事件传参解决方案



### Easy Way
* Use an arrow function:
```js
return (
  <th value={column} onClick={() => this.handleSort(column)}>{column}</th>
);
```

* This will create a new function that calls handleSort with the right params.


### Better Way
* E xtract it into a sub-component. The problem with using an arrow function in the render call is it will create a new function every time, which ends up causing unneeded re-renders.

* If you create a sub-component, you can pass handler and use props as the arguments, which will then re-render only when the props change (because the handler reference now never changes):

* Sub-component
```js
class TableHeader extends Component {
  handleClick = () => {
    this.props.onHeaderClick(this.props.value);
  }

  render() {
    return (
      <th onClick={this.handleClick}>
        {this.props.column}
      </th>
    );
  }
}
```

* Main component
```js
{this.props.defaultColumns.map((column) => (
  <TableHeader
    value={column}
    onHeaderClick={this.handleSort}
  />
))}
```


### Old Easy Way (ES5)
* Use `.bind` to pass the parameter you want:

```js
return (
  <th value={column} onClick={that.handleSort.bind(that, column)}>{column}</th>
);
```