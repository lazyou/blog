## Detecting input change in jQuery
* 使用 Jquery 检测 input 框变化

UPDATED for clarification and example

examples: http://jsfiddle.net/pxfunc/5kpeJ/

### Method 1. input event
* In modern browsers use the input event. This event will fire when the user is typing into a text field, pasting, undoing, basically anytime the value changed from one value to another.

* In jQuery do that like this
```js
$('#someInput').bind('input', function() { 
    $(this).val() // get the current value of the input field.
});
``` 

* starting with jQuery 1.7, replace `bind` with `on`:
```js
$('#someInput').on('input', function() { 
    $(this).val() // get the current value of the input field.
});
```

### Method 2. keyup event
* For older browsers use the keyup event (this will fire once a key on the keyboard has been released, this event can give a sort of false positive because when "w" is released the input value is changed and the keyup event fires, but also when the "shift" key is released the keyup event fires but no change has been made to the input.). Also this method doesn't fire if the user right-clicks and pastes from the context menu:

```js
$('#someInput').keyup(function() {
    $(this).val() // get the current value of the input field.
});
```


## If you've got HTML5
* `oninput` (fires only when a change actually happens, but does so immediately)
Otherwise you need to check for all these events which might indicate a change to the input element's value:

* `onchange`
* `onkeyup` (not keydown or keypress as the input's value won't have the new keystroke in it yet)
* `onpaste` (when supported)
and maybe:

* `onmouseup` (I'm not sure about this one)
