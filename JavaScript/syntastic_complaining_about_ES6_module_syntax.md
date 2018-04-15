## syntastic complaining about ES6 module syntax
* https://stackoverflow.com/questions/20160921/syntastic-complaining-about-es6-module-syntax


###
* Syntastic will use JSHint to check JavaScript syntax if it's available (which I recommend over jslint).

* JSHint supports es6 syntax with the esnext flag, which includes support for the `export` and `import` module syntax.

I suggest adding a `.jshintrc` file to your project to control JSHint's behavior (and thus Syntastic's) for your entire project:
```json
{
  "esnext": true
}
```

* Note: be careful, since using the esnext flag will add support for all of es6's new language sytax that JSHint currently supports, not just the module syntax.

* Note: esnext has now been deprecated in favour of the esversion syntax.
```json
{
  "esversion": 6
}
```


### 
* To work around this, I'd suggest the following steps as recommended here: Configure Vim for React:

* Install `eslint` and `babel-eslint`:
	* `npm install -g eslint babel-eslint`

* Create a local `.eslintrc` config in your project or a global `~/.eslintrc` configuration:
```json
{
    "parser": "babel-eslint",
    "env": {
        "browser": true,
        "node": true
    },
    "settings": {
        "ecmascript": 6
    },
    "rules": {
        "strict": 0 // you can add more rules if you want
    }
}
```
Finally, configure `syntastic` to use `eslint`:
	* `let g:syntastic_javascript_checkers = ['eslint']`
