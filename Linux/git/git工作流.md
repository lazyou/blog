#### git 工作流：团队开发用

0. 图例
```
master> git checkout master  # 这是命令解说
#------ --------------------
#  |              \ 需要输入的 git 指令
#  |            
#  \ 分支/版本提示符，不需要输入（实际在 gitbash 里显示在上一行）
#    执行每一条 git 指令时，都应知道当前处在那个分支（非常重要！）
```

1. 获取远程更新，确保 master 是最新的
```
issueX> git checkout master
master> git pull
```


2. 基于最新 master 创建新的 issue 分支，并在 issue 分支上工作
```
master> git checkout -b issue33
# 命令执行之后，会自动切换到 issue33 分支
# 可以开始工作了
```


3. 工作完成，在 issue 分支上 commit
```
issue33> git add                            # 把增/删/改过的文件添加到 index 区
issue33> git commit -m"修改了 xx 问题，fixes #33"  # 把 index 区的内容提交到仓库
```


4. 再次获取远程更新，合并修改，推送
```
issue33> git checkout master
master> git pull                                 # 获得远程更新，注意查看命令行输出，确认是否有更新

a. 如果远程有更新
需要对 issue 分支进行 rebase：
master> git checkout issue33
issue33> git rebase master
解决冲突(如果有)，下一步到 c 进行合并

b. 如果远程无更新
直接下一步到 c 进行合并

c. 切换到 master
issue33> git checkout master    # 切换到 master 分支
master> git merge issue33       # 合并 issue33 分支的修改

d. 向远程 push
master> git push
附一篇 "Git换行符": https://github.com/cssmagic/blog/issues/22
```
