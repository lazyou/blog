## 使用git和github进行协同开发流程
* https://github.com/livoras/blog/issues/7


### 分支（Branch）
* 永久性分支
    * `master branch`：主分支
    * `develop branch`：开发分支

* 临时性分支
    * `feature branch`：功能分支
    * `release branch`：预发布分支
    * `hotfix branch`：bug修复分支

* __master__：主分支从项目一开始便存在，它用于存放经过测试，已经完全稳定代码；在项目开发以后的任何时刻当中， `master` 存放的代码应该是可作为产品供用户使用的代码。所以，应该随时保持 `master` 仓库代码的清洁和稳定，确保入库之前是通过完全测试和代码 reivew 的。`master` 分支是所有分支中最不活跃的，大概每个月或每两个月更新一次，每一次 `master` 更新的时候都应该用 git 打上 tag，说明你的产品有新版本发布了。

* __develop__：开发分支，一开始从 `master` 分支中分离出来，用于开发者存放基本稳定代码。之前说过，每个开发者的仓库相当于源仓库的一个镜像，每个开发者自己的仓库上也有 `master` 和 `develop`。开发者把功能做好以后，是存放到自己的 `develop` 中，当测试完以后，可以向管理者发起一个 `pull request`，请求把自己仓库的 `develop` 分支合并到源仓库的 `develop` 中。

* 注意，任何人不应该向 `master` 直接进行无意义的合并、提交操作。正常情况下， `master` 只应该接受 `develop` 的合并，也就是说， `master` 所有代码更新应该源于合并 `develop` 的代码。

* __feature__：功能性分支，是用于开发项目的功能的分支，是开发者主要战斗阵地。开发者在本地仓库从 `develop` 分支分出功能分支，在该分支上进行功能的开发，开发完成以后再合并到 `develop` 分支上，这时候功能性分支已经完成任务，可以删除。功能性分支的命名一般为 `feature-*`，`*` 为需要开发的功能的名称。

* eg: 完成一次功能的开发和提交
    ```sh
    step 1: 切换到develop分支
    >>> git checkout develop

    step 2: 分出一个功能性分支
    >>> git checkout -b feature-discuss

    step 3: 在功能性分支上进行开发工作，多次commit，测试以后...

    step 4: 把做好的功能合并到develop中

    >>> git checkout develop
    # 回到develop分支

    >>> git merge --no-ff feature-discuss
    # 把做好的功能合并到develop中

    >>> git branch -d feature-discuss
    # 删除功能性分支

    >>> git push origin develop
    # 把develop提交到自己的远程仓库中
    ```


### 工作流（Workflow）
* Step 1：源仓库的构建

* Step 2：开发者fork源仓库

* Step 3：把自己开发者仓库clone到本地

* Step 4：构建功能分支进行开发
    ```sh
    >>> git checkout develop
    # 切换到`develop`分支

    >>> git checkout -b feature-discuss
    # 分出一个功能性分支

    >> touch discuss.js
    # 假装discuss.js就是我们要开发的功能

    >> git add .
    >> git commit -m 'finish discuss feature'
    # 提交更改

    >>> git checkout develop
    # 回到develop分支

    >>> git merge --no-ff feature-discuss
    # 把做好的功能合并到develop中

    >>> git branch -d feature-discuss
    # 删除功能性分支

    >>> git push origin develop
    # 把develop提交到自己的远程仓库中
    ```

* Step 5：向管理员提交pull request

* Step 6 管理员测试、合并
    1. 对我的代码进行review。github提供非常强大的代码review功能：

    2. 在他的本地测试新建一个测试分支，测试我的代码：
        ```sh
        >> git checkout develop
        # 进入他本地的develop分支

        >> git checkout -b livoras-develop
        # 从develop分支中分出一个叫livoras-develop的测试分支测试我的代码

        >> git pull https://github.com/livoras/git-demo.git develop
        # 把我的代码pull到测试分支中，进行测试
        ```
    
    3. 判断是否同意合并到源仓库的develop中，如果经过测试没问题，可以把我的代码合并到源仓库的develop中：
        ```sh
        >> git checkout develop
        >> git merge --no-ff livoras-develop
        >> git push origin develop
        ```


## 小结
* 感觉作为管理员的工作量很大，频繁提交做pr岂不是很痛苦？
