## VSCode
* 官网： https://code.visualstudio.com/

* 常用快捷键
```conf
# 快速跳转文件
ctrl + p

# 左侧菜单显示关闭切换
ctrl + b
```

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
    "editor.minimap.enabled": false,
    "terminal.integrated.shell.windows": "C:\\WINDOWS\\Sysnative\\bash.exe",
    "terminal.integrated.shell.linux": "/usr/bin/fish",
    "atomKeymap.promptV3Features": true,
    "editor.multiCursorModifier": "ctrlCmd",
    "editor.formatOnPaste": true, // 自动换行 
    "window.menuBarVisibility": "toggle",
    "files.associations": {
        "*.gtpl": "html"
    },
    "git.path": "E:\\Program Files\\Git\\bin\\git.exe",
    // 插件添加新关键字
    "todohighlight.keywords": [
    {
        "text": "NOTE:",
        "color": "#ff0000",
        "backgroundColor": "yellow",
        "overviewRulerColor": "grey"
    },
]
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
    * Code Runner
    * go

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


### go 插件
* https://github.com/Microsoft/vscode-go.git

* http://www.cnblogs.com/OctoptusLian/p/9325934.html
