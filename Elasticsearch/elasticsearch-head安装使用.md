## head插件安装
* https://www.cnblogs.com/hong-fithing/p/11221020.html


### elasticsearch-head
```sh
sudo npm install -g grunt-cli 
git clone https://github.com/mobz/elasticsearch-head
cd elasticsearch-head/
npm install
npm start

# 访问 localhost:9100
``` 


### 问题
* 访问时网络问题: CORS Missing Allow Origin, NS_ERROR_DOM_BAD_URI
```
# vim config/elasticsearch.yml 添加以下两项配置 （TODO: 当然最好配合es账号密码使用）
http.cors.enabled: true
http.cors.allow-origin: "*"
```

