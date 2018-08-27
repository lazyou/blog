## fish
* fish: https://fishshell.com/

* `sudo apt install fish`

* 设置默认打开, 待补充


## 终端显示配置
* 保存到 `~/.config/fish/config.fish` 然后重启 fish

* 来源: https://coderwall.com/p/ycvusg/show-git-branch-name-in-fish-shell

* 针对修改了路径为完成的路径
```sh
function fish_prompt --description 'Write out the prompt'
    # Just calculate these once, to save a few cycles when displaying the prompt
    if not set -q __fish_prompt_hostname
    set -g __fish_prompt_hostname (hostname|cut -d . -f 1)
    end

    if not set -q __fish_prompt_normal
    set -g __fish_prompt_normal (set_color normal)
    end

    if not set -q __git_cb
    set __git_cb ":"(set_color brown)(git branch ^/dev/null | grep \* | sed 's/* //')(set_color normal)""
    end

    switch $USER

    case root

    if not set -q __fish_prompt_cwd
        if set -q fish_color_cwd_root
            set -g __fish_prompt_cwd (set_color $fish_color_cwd_root)
        else
            set -g __fish_prompt_cwd (set_color $fish_color_cwd)
        end
    end

    printf '%s%s%s%s\n➤ ' "$__fish_prompt_cwd" (pwd) "$__fish_prompt_normal" $__git_cb

    case '*'

    if not set -q __fish_prompt_cwd
        set -g __fish_prompt_cwd (set_color $fish_color_cwd)
    end

    printf '%s%s%s%s\n➤ ' "$__fish_prompt_cwd" (pwd) "$__fish_prompt_normal" $__git_cb

    end
end
```
