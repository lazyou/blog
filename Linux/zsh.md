
## 终端辅助工具 -- oh-my-zsh:
* zsh: `sudo apt install zsh`

* oh-my-zsh 项目来帮我们配置 zsh: `wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | sh`

* 切换到 zsh 模式: `chsh -s /usr/bin/zsh`

* zsh 主题推荐： https://github.com/caiogondim/bullet-train.zsh (所有配置都在 readme 里, 配置到 ~/.zshrc 即可)
    * `cd ~/.oh-my-zsh/themes`
    * `wget http://raw.github.com/caiogondim/bullet-train-oh-my-zsh-theme/master/bullet-train.zsh-theme`
    * `vim .oh-my-zsh/themes/bullet-train.zsh-theme` 进行更多设置

* powerline 安装： https://github.com/powerline/powerline OR `sudo apt install powerline`

* zsh-autosuggestions 插件
    * https://github.com/zsh-users/zsh-autosuggestions

    * `cd ~/.oh-my-zsh/custom/plugins && git clone https://github.com/zsh-users/zsh-autosuggestions`

    * `vim  ~/.zshrc` 设置 `plugins=(zsh-autosuggestions)`

    * 提示字符颜色设置： `.zshrc` 设置`ZSH_AUTOSUGGEST_HIGHLIGHT_STYLE='fg=5'`
        * `ZSH_AUTOSUGGEST_HIGHLIGHT_STYLE='fg=yellow'` 直接设置颜色也行

## tips
* tab 自动补全

* 环境变量展开 (`$PWD` 然后 tab)

* kill命令补全 (`kill` 空格 tab)

* 历史记录 （`ctrl+r`)

* alias 别名 (在目录 `~/.oh-my-zsh/plugins/` 下)
    * 在配置里使用 `alias` 设置别名: 例如 `alias gst='git status'`
    * 例如 git 的别名在 `~/.oh-my-zsh/plugins/git/git.plugin.zsh`
