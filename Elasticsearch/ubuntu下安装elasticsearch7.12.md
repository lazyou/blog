##
* https://www.elastic.co/downloads/elasticsearch


### 安装 -- 压缩包解压
* https://www.elastic.co/guide/en/elasticsearch/reference/current/getting-started-install.html
```
curl -L -O https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-7.12.0-linux-x86_64.tar.gz

tar -xvf elasticsearch-7.12.0-linux-x86_64.tar.gz

cd elasticsearch-7.12.0/bin
./elasticsearch

# 启动另外两个Elasticsearch实例，这样您就可以看到典型的多节点集群的行为。 您需要为每个节点指定唯一的数据和日志路径。 
# TODO: 实际操作失败，只能有一个实例存活
./elasticsearch -Epath.data=data2 -Epath.logs=log2
./elasticsearch -Epath.data=data3 -Epath.logs=log3

# 访问
http://localhost:9200
http://localhost:9200/_cat/health?v=true
```

### 插件安装
* https://github.com/medcl/elasticsearch-analysis-ik
```
./bin/elasticsearch-plugin install https://github.com/medcl/elasticsearch-analysis-ik/releases/download/v7.12.0/elasticsearch-analysis-ik-7.12.0.zip

./bin/elasticsearch-plugin list
``````


### 安装 -- 不推荐使用 deb 安装方式，配置 安装插件不方便等问题
```
sudo apt install openjdk-8-jre-headless

# deb-repo
# https://www.elastic.co/guide/en/elasticsearch/reference/7.12/deb.html#deb-repo

wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -

sudo apt-get install apt-transport-https

echo "deb https://artifacts.elastic.co/packages/7.x/apt stable main" | sudo tee /etc/apt/sources.list.d/elastic-7.x.list

sudo apt-get update && sudo apt-get install elasticsearch


# cd: elasticsearch/: Permission denied 问题解决
sudo su - elasticsearch -s /bin/bash

sudo service elasticsearch start
# 访问 http://localhost:9200/ 看到效果
```
