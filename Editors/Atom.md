## Atom
* 官网： https://atom.io/

* 设置备份
    - [x] Atomic Soft Tabs
    - [x] Auto Indent
    - [x] Auto Indent On Paste
    - [x] Show Indent Guide
    - [x] Show Line Numbers
    - [x] Soft Tabs
    - [x] Soft Warp
    - [x] Tab Type -- soft

* 插件管理
    * 安装：
    ```
    cd ~/.atom/packages
    git clone https://github.com/emmetio/emmet-atom
    cd emmet-atom
    npm install
    ```

    * 更新：
    ```
    cd ~/.atom/packages/emmet-atom
    git pull
    npm update
    ```

    * 查看: `apm list` 可看到内建插件 和 用户安装的插件

* 常用插件
    * php 开发用插件: 语法校验 语法补充(跳转) 等号对齐 没了
    ```
    Community Packages (23) /home/linxl/.atom/packages
    ├── aligner@1.2.3
    ├── aligner-javascript@1.2.0
    ├── aligner-php@1.1.1
    ├── atom-autocomplete-php@0.25.6
    ├── atom-runner@2.7.1
    ├── busy-signal@1.4.3
    ├── php-cs-fixer@4.1.1
    ├── intentions@1.1.2
    ├── linter@2.2.0
    ├── linter-php@1.3.2
    ├── linter-ui-default@1.2.4
    └── vim-mode-plus@0.93.0
    ```

* php-cs-fixer 设置: http://cs.sensiolabs.org/#installation
    * wget http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar

    * PHP-CS-fixer executable path: /XXX/php-cs-fixer.phar
