## VSCode
* 官网： https://code.visualstudio.com/

* 语言设置: F1 -> 语言设置 -> 修改为en-US -> 保存重启 VSCode

* 设置备份
```json
{
    "editor.fontFamily": "Monaco",
    "editor.fontSize": 14,
    "editor.insertSpaces": true, // 空格代替tab
    "editor.detectIndentation": false, // 是否监听源文件 缩进
    "editor.wordWrap": "on",
    "terminal.integrated.fontFamily": "Monaco",
    "terminal.integrated.fontSize": 13,
    "workbench.colorTheme": "Atom One Dark",
    "window.zoomLevel": 0,
    "terminal.integrated.shell.windows": "C:\\WINDOWS\\Sysnative\\bash.exe",
    "atomKeymap.promptV3Features": true,
    "editor.multiCursorModifier": "ctrlCmd",
    "editor.formatOnPaste": true, // 自动换行 
    "window.menuBarVisibility": "toggle",
    "files.associations": {
        "*.gtpl": "html"
    },
    "git.path": "E:\\Program Files\\Git\\bin\\git.exe"
}
```

* 主题:
    * Atom One Dark Theme

* 插件:
    * DotENV
    * phpfmt
    * TODO Highlight
    * Todo Tree
    * PHP IntelliSense (感觉没啥用啊)


### 使用 VSCode 进行 Laravel 开发
* https://laravel-china.org/articles/6895/vscode-build-laravel-development-environment


### PHP 格式化插件
* phpfmt - PHP formatter: https://marketplace.visualstudio.com/items?itemName=kokororin.vscode-phpfmt

* 设置备份:
```json
{
    "[php]": {
        "editor.formatOnSave": true
    },
    "phpfmt.php_bin": "D:\\software\\php7\\php.exe",
}
```
