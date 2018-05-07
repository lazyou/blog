## VIM
* vim 配置: `vim ~/.vimrc `
```
set nu
set expandtab
set cursorline
set autoindent
set tabstop=4
set shiftwidth=4
set softtabstop=4
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
