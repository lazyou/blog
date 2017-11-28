### Git 杂记

#### git GUI 软件推荐
* gitk
* sourcetree


#### git 坑之 -- 换行符自动转换 （window 下应取消）
* `git config --global core.autocrlf false` // 换行符自动转换
*  autocrlf = false` // 当前项目的 .git/config


#### git 坑之 -- 文件名大小写敏感自动忽略 （window 下应取消
* `git config core.ignorecase false`


#### git 初始化
```
git init
git remote add origin http://105.xxxxxx/txh.git
git pull // 输入账号密码(私有账号需要账号密码)
git pull origin master // 如果第5步没有下载就继续这一步.
```


#### 免输入用户名：
```
在当前的项目目录下
vim .git/config // 在 url 上配置用户名
url=htt://用户名@115.29.../meishenghuo/web.git
```


#### 暂存
```
git stash
git stash list
git stash pop
```


#### 添加远程服务器：
* `git remote add`


#### 提交回滚：
* `git reset hash值`

* `git reset hash值 xx文件` // 回滚单个文件


#### 修改最后一次提交注释：
* `git commit --amend -m"fix xxx"`
* 问题： 如何修改更多提交注释？


#### git 为不同项目设置独立的 name email
* 编辑 .git/config 文件, 添加:
```
[user]
    name = xxx
    email = xxx@qq.com
```    


#### 修改文件权限引起的 git 记录文件变化
* git 默认会跟踪文件的权限修改，当我们使用chmod指令的时候，git也会把被修改权限的文件添加到被修改的状态

* 编辑 `.git/config` 设置 `filemode=true`

* 全局设置: `git config core.filemode false`