### Git 杂记

#### git GUI 软件推荐
* gitk
* sourcetree


#### git 坑之 -- 换行符自动转换 （window 下应取消）
* `git config --global core.autocrlf false` // 换行符自动转换
*  autocrlf = false // 当前项目的 .git/config


 #### 中文路径显示乱码解决
 * git config --global core.quotepath false


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


#### 免输入密码设置
* 方法一, 全局设置: `git config --global credential.helper store`

* 方法二, 设置在项目的 url 上: `vim .git/config, 然后设置 https://{username}:{password}@github.com`


#### gitk 等查看 log 出现乱码
* 找到配置文件例如: D:\software\Git\mingw64\etc\gitconfig, 添加设置: 
```
[gui]
  encoding = utf-8
[i18n]
  commitencoding = utf-8
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


### git 批量删除文件夹和文件
```
1. 删除文件 || 目录
2. git rm <文件> || git rm * -r (到要删除的目录下)
3. git add . || git commit -m"clear"
```
