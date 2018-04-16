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

* solarized 主题安装
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
