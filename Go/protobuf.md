## protobuf
* https://developers.google.com/protocol-buffers/       (https://developers.google.cn/protocol-buffers/)
* https://github.com/protocolbuffers/protobuf

### 简介
* Protocol Buffers (a.k.a., protobuf) are Google's language-neutral, platform-neutral, extensible mechanism for serializing structured data. You can find protobuf's documentation on the Google Developers site.

### golang 中使用 protobuf
* https://github.com/golang/protobuf

* 安装 golang 的 protobuf 协议编译器: `go get -u github.com/golang/protobuf/protoc-gen-go`

* __gRPC 中使用 protobuf__
  * protoc --go_out=plugins=grpc:. *.proto
  * 几个案例:
    * protobuf 文件:
    ```proto
    syntax = "proto3";

    package api;

    option go_package = "imProject/rpc/api";

    import public "rpc/api/message.proto"; // 不推荐 public, 容易分不清
    import "rpc/common/common.proto";
    ```

    * 编译: `protoc --go_out=plugins=grpc:..\ rpc\common\common.proto`


### protobuf 文件编写 tip
* https://developers.google.cn/protocol-buffers/docs/proto3
* https://developers.google.cn/protocol-buffers/docs/style

* proto 文件推荐 下划线命名风格, 编译后会被转为 驼峰命名风格.
  * 如果是 驼峰命名风格 那么编译后都会变成小写

* 推荐 service 和 数据结构(message)分开写 (好处是修改了 service 的 message 只需要编译 message 文件即可)

* 推荐公共的数据结构(message)放在 common.proto

* grpc-web 编译成js客户端:
  * `repeated xxx = 1` 会被重命名为 `xxxList`
