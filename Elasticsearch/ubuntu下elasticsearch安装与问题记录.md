## Ubuntu下Elasticsearch安装与问题记录
* https://www.marsshen.com/2018/04/23/Elasticsearch-install-and-set-up


### 安装Elasticsearch注意事项
* ES对内存的要求很高，最好可以在内存2G以上的坏境运行Elasticsearch，否则可能会出现运行不稳定的问题

* ES运行需要Java8的运行环境 (`sudo apt-get install openjdk-8-jdk`)


### 通过tar包安装Elasticsearch
```sh
curl -L -O https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-6.2.4.tar.gz
tar -xvf elasticsearch-6.2.4.tar.gz
cd elasticsearch-6.2.4/bin
./elasticsearch


# Elasticsearch出于安全方面的考虑， 不允许用户使用root账号启动Elasticsearch。我们得新建一个用户，专门用于启动Elasticsearch。
# 创建一个用户组elsearch与用户组中的用户elsearch：
groupadd elsearch
useradd elsearch -g elsearch
passwd elsearch # 修改密码
chown -R elsearch:elsearch elasticsearch-6.2.4 # 修改目录拥有者，赋予相应的权限

# 切换到用户elsearch，或者使用elsearch登陆，启动Elasticsearch：
su elsearch cd elasticsearch-6.2.4/bin
./elasticsearch

# ElasticSearch在后端启动
./bin/elasticsearch -d -p pid
```

* Log 信息可以在 `$ES_HOME/logs/` 中找到

* 关闭 Elasticsearch 后台进程: `kill cat pid`


### 通过Docker安装Elasticsearch
```sh
docker pull docker.elastic.co/elasticsearch/elasticsearch:6.2.4

# 为了让我们能够方便的配置镜像中Elasticsearch的配置文件，我们可以用挂载配置文件的方式运行Elasticsearch镜像
docker run -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" --rm --name es docker.elastic.co/elasticsearch/elasticsearch:6.2.4

# 将镜像中的配置文件与Data文件夹拷贝到宿主主机
docker cp 容器name:/usr/share/elasticsearch/config /opt/elasticsearch/config/
docker cp 容器name:/usr/share/elasticsearch/data /opt/elasticsearch/data/

# 在宿主主机相应目录中修改相关配置如Elasticsearch.yml。
# 用挂载的宿主主机中的配置文件运行Elasticsearch的Docker镜像：
docker run -p 9200:9200 -p 9300:9300 -d -e "discovery.type=single-node" --rm --name es -v /opt/elasticsearch/config:/usr/share/elasticsearch/config -v /opt/elasticsearch/data:/usr/share/elasticsearch/data docker.elastic.co/elasticsearch/elasticsearch:6.2.4

# 因为加了-d，所以当前运行模式是后台运行，不会有什么输出，若要停止这个镜像的运行，输入docker ps查看相应的信息，
# 根据相关信息使用docker stop命令，停止Elasticsearch服务。
# 在上面的例子中我们使用docker stop es来停止Elasticsearch服务。
```


### 安装 elasticsearch-analysis-ik 插件
* 方式一(不推荐)：从这里下载你 Elasticsearch 相应版本的安装包，解压缩后放在 `your-es-root/plugins/` 中。

* 方式二：注意版本一定要对应
  * 使用Elasticsearch-plugin来安装，这个方式支持v5.5.1以后的版本。
  * `./bin/elasticsearch-plugin install https://github.com/medcl/elasticsearch-analysis-ik/releases/download/v6.2.3/elasticsearch-analysis-ik-6.2.3.zip`


### 宿主机无法访问虚拟机中 ElasticSearch服务
* 修改 ES 的配置文件 /config/elasticsearch.yml
```yml
network.host: 0.0.0.0
http.port: 9200
transport.host: localhost
transport.tcp.port: 9300
```


### 使用 elasticsearch
```sh
#首先创建一个index
curl -XPUT http://localhost:9200/index

#然后创建mapping
curl -XPOST http://localhost:9200/index/fulltext/_mapping -H 'Content-Type:application/json' -d'
{
  "properties": {
    "content": {
      "type": "text",
      "analyzer": "ik_max_word",
      "search_analyzer": "ik_max_word"
    }
  }
}'

#创建doc并且查询这个中文字段
curl -XPOST http://localhost:9200/index/fulltext/1 -H 'Content-Type:application/json' -d'{"content":"美国留给伊拉克的是个烂摊子吗"}'
curl -XPOST http://localhost:9200/index/fulltext/2 -H 'Content-Type:application/json' -d'{"content":"公安部：各地校车将享最高路权"}'
curl -XPOST http://localhost:9200/index/fulltext/3 -H 'Content-Type:application/json' -d'{"content":"中韩渔警冲突调查：韩警平均每天扣1艘中国渔船"}'
curl -XPOST http://localhost:9200/index/fulltext/4 -H 'Content-Type:application/json' -d'{"content":"中国驻洛杉矶领事馆遭亚裔男子枪击 嫌犯已自首"}'

#查询
curl -XPOST http://localhost:9200/index/fulltext/_search  -H 'Content-Type:application/json' -d'
{
  "query" : { "match" : { "content" : "中国" }},
  "highlight" : {
    "pre_tags" : ["<tag1>", "<tag2>"],
    "post_tags" : ["</tag1>", "</tag2>"],
    "fields" : {
      "content" : {}
    }
  }
}'
```
