## gRPC
* https://www.grpc.io

### 简介


### go 中使用 grpc
* https://github.com/grpc/grpc-go


### web 中使用 grpc
* https://github.com/grpc/grpc-web

* grpc web 只支持服务端流, 不支持客户端流

* 编译命令案例: `rotoc -I=. rpc\common\common.proto --js_out=import_style=commonjs,binary:. --grpc-web_out=import_style=commonjs,mode=grpcwebtext:.`

* 客户端案例:
  ```js

  let teamActClient = new TeamActClient(GRPC_HOSTNAME, null, null)

  // 根据 teamId 获取群成员列表. metadata: 验证信息
  export function GetTeamMembers(metadata, teamId) {
    let request = new GetTeamRequest()
    request.setTeamId(teamId)

    return new Promise((resolve, reject) => {
      teamActClient.getTeamMemberInfoList(request, metadata, (err, response) => {
        rpcLog('getTeamMemberInfoList', request, err, response)

        if (err) {
          reject(err)
        } else {
          resolve(response.toObject())
        }
      })
    })
  }
  ```


### 使用代理支持 gRPC-Web protocol 协议
* grpcwebproxy:
  * https://github.com/improbable-eng/grpc-web/tree/master/go/grpcwebproxy
  * `grpcwebproxy --backend_addr=localhost:50059 --allow_all_origins --server_http_max_write_timeout=24h --run_tls_server=false`
  * `grpcwebproxy --server_tls_cert_file=../../misc/localhost.crt --server_tls_key_file=../../misc/localhost.key --backend_addr=localhost:50059 --backend_tls_noverify --allow_all_origins  --server_http_max_write_timeout=24h`

* envoy: TODO:这个暂时不会
  * https://www.envoyproxy.io/
