## go mod 使用
作者：goodspeed
链接：https://juejin.im/post/5c8e503a6fb9a070d878184a
来源：掘金
著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。

* go modules 是 golang 1.11 新加的特性。

* https://github.com/golang/go/wiki/Modules

### Go Module代理仓库服务
* 阿里云: `export GOPROXY=https://mirrors.aliyun.com/goproxy/`

* goproxy: https://github.com/goproxy/goproxy.cn


### go mod
Usage:

        go mod <command> [arguments]

The commands are:

        download    download modules to local cache
        edit        edit go.mod from tools or scripts
        graph       print module requirement graph
        init        initialize new module in current directory
        tidy        add missing and remove unused modules
        vendor      make vendored copy of dependencies
        verify      verify dependencies have expected content
        why         explain why packages or modules are needed


### 如何在项目中使用
```sh
➜  ~ mkdir hello
➜  ~ cd hello
➜  hello go mod init hello
go: creating new go.mod: module hello
➜  hello ls
go.mod
➜  hello cat go.mod
module hello

go 1.12
```

* go.mod 提供了module, require、replace和exclude 四个命令
    * module 语句指定包的名字（路径）
    * require 语句指定的依赖项模块
    * replace 语句可以替换依赖项模块
    * exclude 语句可以忽略依赖项模块

* 执行 `go run main.go` 运行代码会发现 go mod 会自动查找依赖自动下载

* go module 安装 package 的原則是先拉最新的 release tag，若无tag则拉最新的commit
