## VIM
* vim 配置: `vim ~/.vimrc `
```
set nu

"将Tab自动转化成空格
set expandtab

" 突出显示当前行
set cursorline
set autoindent
set tabstop=4
set shiftwidth=4
set softtabstop=4
set fencs=utf-8,gbk

"文件修改之后自动载入
set autoread

" 高亮search命中的文本
set hlsearch

"括号配对情况
set showmatch

"在状态栏显示正在输入的命令
set showcmd

"打开增加搜索模式，随着键入即时搜索
set incsearch

```

### VIM 打开中文文件乱码
* https://www.cnblogs.com/hopeworld/archive/2011/04/20/2022331.html

* `vim ~/.vimrc` 加入 `set fencs=utf-8,gbk` 或者 `set fileencodings=utf-8,gb18030,utf-16,big5`


### solarized 主题安装
```
git clone git://github.com/altercation/solarized.git

cd solarized
cd vim-colors-solarized/colors
mkdir -p ~/.vim/colors
cp solarized.vim ~/.vim/colors/

vi ~/.vimrc
syntax enable
set background=dark
colorscheme solarized
```
