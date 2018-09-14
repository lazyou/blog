## Laravel tips
* 表单数组验证
```php
1. 
<input name='tags[]' >

Validator::make($request->all(), [
    "tags" => 'required|array',
    "tags.*" => 'required|string|distinct|min:3',
]);


2. 
<input type="text" name="employee[2][name]">
<input type="text" name="employee[2][title]">
<input type="text" name="employee[3][name]">
<input type="text" name="employee[3][title]">

$this->validate($request, [
    'employee.*.name' => 'required|string',
    'employee.*.title' => 'string',
]);
```
