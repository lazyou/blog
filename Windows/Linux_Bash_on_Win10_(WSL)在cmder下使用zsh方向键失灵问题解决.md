## Linux_Bash_on_Win10_(WSL)在cmder下使用zsh方向键失灵问题解决
* https://www.jianshu.com/p/e080fe502217

* 设置 cmder 的启动命令: Starup => Command line:
    * `cmd /k "%ConEmuDir%\..\init.bat"  -new_console:d:%USERPROFILE% & bash  -cur_console:p:n & zsh -cur_console:p:n`
