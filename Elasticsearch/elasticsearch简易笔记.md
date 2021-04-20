## 
* https://wiki.jikexueyuan.com/project/elasticsearch-definitive-guide-cn/


### 使用es的公司
* __维基百科__ 使用Elasticsearch提供全文搜索并高亮关键字，以及 __输入实时搜索(search-as-you-type)__ 和 __搜索纠错(did-you-mean)__ 等搜索建议功能
* __StackOverflow__ 结合全文搜索与地理位置查询，以及 more-like-this 功能来找到相关的问题和答案
* __Github__ 使用Elasticsearch检索1300亿行的代码


### 什么是Elasticsearch
* Elasticsearch是一个基于Apache Lucene(TM)的开源搜索引擎。无论在开源还是专有领域，Lucene可以被认为是迄今为止最先进、性能最好的、功能最全的搜索引擎库。
* Lucene只是一个库。想要使用它，你必须使用Java来作为开发语言并将其直接集成到你的应用中。
* Elasticsearch也使用Java开发并使用Lucene作为其核心来实现所有索引和搜索的功能，但是它的目的是通过简单的RESTful API来隐藏Lucene的复杂性，从而让全文搜索变得简单。
* Elasticsearch不仅仅是Lucene和全文搜索，我们还能这样去描述它：
    * 分布式的实时文件存储，每个字段都被索引并可被搜索
    * 分布式的实时分析搜索引擎
    * 可以扩展到上百台服务器，处理PB级结构化或非结构化数据


### 类比传统关系型数据库
* Elasticsearch集群可以包含多个 __索引(indices)（数据库）__，每一个索引可以包含多个 __类型(types)（表）__，每一个类型包含多个 __文档(documents)（行）__，然后每个文档包含多个 __字段(Fields)（列）__。
```
Relational DB -> Databases -> Tables -> Rows -> Columns
Elasticsearch -> Indices   -> Types  -> Documents -> Fields
```


### 文档
*  在Elasticsearch中，__文档(document)__ 这个术语有着特殊含义。它特指最顶层结构或者 __根对象(root object)__ 序列化成的JSON数据（以唯一ID标识并存储于Elasticsearch中）。

* 文档 __元数据(metadata)__, 三个必须的元数据节点是：
    * 节点 	         说明
    * `_index` 	    文档存储的地方 (类似数据库，是存储和索引关联数据的地方)
    * `_type` 	    文档代表的对象的类 （每个类型(type)都有自己的 __映射(mapping)__ 或者结构定义）
    * `_id` 	    文档的唯一标识(一个字符串，与_index和_type组合时，就可以在Elasticsearch中唯一标识一个文档, 可自定义，也可自动生成)


### RESTful API 风格
* GET  POST PUT, 200 201 400 404 不同HTTP请求方法he状态码的含义根据 RESTful API 风格去理解即可


### 索引一个文档
* 文档通过 `index` API被索引——使数据可以被存储和搜索

* 创建索引: `POST /{index}/{type}/{id}`, 如果省去 `{id}` 那么es会自动填充 UUID 作为 _id

* Elasticsearch中每个文档都有版本号，__每当文档变化（包括删除）都会使 `_version` 增加__。
    * 在《版本控制》章节中我们将探讨如何使用_version号确保你程序的一部分不会覆盖掉另一部分所做的更改。


### 文档局部更新
* 请求表单接受一个局部文档参数doc，它会合并到现有文档中——对象合并在一起，存在的标量字段被覆盖，新字段被添加。

* `POST  /{index}/{type}/{id}/_update`
    ```sh
    {
        "doc" : {
            "tags" : [ "testing" ],
            "views": 0
        }
    }
    ```



### 文档的操作 -- 增 删 改
* 文档增加: `POST /_index/_type/[_id]`, id 参数可有可无，无则自动生成. _index、_type、_id三者 __唯一__ 确定一个文档
    * 方式2: `POST /_index/_type/[_id]?op_type=create`
    * 方式3: `POST /_index/_type/[_id]/_create`
    * 响应: 成功`201 Created`， 失败 `409 Conflict`
    * 当然这种操作如果是 _id 已存在，则会变成更新文档，其中返回有一参数`"result": "created"`

* 文档更新: `PUT /_index/_type/_id`, 此时会响应 `_version` 会自增1，`created` 为 `false`

* 文档删除: `DELETE /_index/_type/id`, 找到并删除会有 `found` 字段体现，无论是否删除成功 `_version` 都会自增


* 索引的创建与修改， `/indices(索引名)/types(类型名)/2(文档)`
```sh
# PUT localhost:9200/indices/types/2
{
    "first_name" :  "Jane",
    "last_name" :   "Smith",
    "age" :         32,
    "about" :       "I like to collect rock albums",
    "interests":  [ "music" ]
}


# 新增
{
    "_index": "indices",
    "_type": "types",
    "_id": "2",
    "_version": 1,
    "result": "created", # "updated" 如果是修改则仅 created 变成 updated
    "_shards": {
        "total": 2,
        "successful": 1,
        "failed": 0
    },
    "_seq_no": 3,
    "_primary_term": 1
}
```


### 批量操作 增删改
* `bulk` API允许我们使用单一请求来实现多个文档的create、index、update或delete

* > 这对索引类似于日志活动这样的数据流非常有用，它们可以以成百上千的数据为一个批次按序进行索引。

* `bulk` 请求体如下，它有一点不同寻常：
    ```sh
    { action: { metadata }}\n
    { request body        }\n
    { action: { metadata }}\n
    { request body        }\n
    ...
    ```

* 这种格式类似于用 `"\n"` 符号连接起来的一行一行的JSON文档 __流(stream)__。两个重要的点需要注意：
    * 每行必须以 `"\n"` 符号结尾，__包括最后一行__。这些都是作为每行有效的分离而做的标记。
    * 每一行的数据不能包含未被转义的换行符，它们会干扰分析——这意味着JSON不能被美化打印。

* action/metadata 这一行定义了文档行为(what action)发生在哪个文档(which document)之上。
    * 行为(action)必须是以下几种：
    ```sh
    create 	当文档不存在时创建之。详见《创建文档》
    index 	创建新文档或替换已有文档。见《索引文档》和《更新文档》
    update 	局部更新文档。见《局部更新》
    delete 	删除一个文档。见《删除文档》
    ```

* 在索引、创建、更新或删除时必须指定文档的_index、_type、_id这些元数据(metadata)
    ```sh
    # POST /_bulk
    { "delete": { "_index": "website", "_type": "blog", "_id": "123" }}
    { "create": { "_index": "website", "_type": "blog", "_id": "123" }}
    { "title":    "My first blog post" }
    { "index":  { "_index": "website", "_type": "blog" }}
    { "title":    "My second blog post" }
    { "update": { "_index": "website", "_type": "blog", "_id": "123", "_retry_on_conflict" : 3} }
    { "doc" : {"title" : "My updated blog post"} 

    # Elasticsearch响应包含一个items数组，它罗列了每一个请求的结果，结果的顺序与我们请求的顺序相同：
    {
        "took": 4,
        "errors": false,
        "items": [
        {  
            "delete": {
                "_index":   "website",
                "_type":    "blog",
                "_id":      "123",
                "_version": 2,
                "status":   200,
                "found":    true
            }},
            ...
        ]
    }
    ```



### 搜索 -- 文档的查询
* 检索文档指定字段: `?_source=age,name`

* 检查文档是否存在: 响应是 `HTTP/1.1 200 OK` 表示文档存在， `404 Not Found` 则文档不存在

* 检索文档 `GET: localhost:9200/indices/types/2`
```sh
# 找不到数据
{
    "_index": "indices",
    "_type": "types",
    "_id": "4",
    "found": false
}

# 找到数据
{
    "_index": "indices",
    "_type": "types",
    "_id": "2",
    "_version": 2,
    "_seq_no": 4,
    "_primary_term": 1,
    "found": true,
    "_source": {
        "first_name": "Jane",
        "last_name": "Smith",
        "age": 32,
        "about": "I like to collect rock albums",
        "interests": [
            "music"
        ]
    }
}
```

* 搜索 `GET：localhost:9200/indices/types/_search`
```sh
{
    "took": 3,
    "timed_out": false,
    "_shards": {
        "total": 1,
        "successful": 1,
        "skipped": 0,
        "failed": 0
    },
    "hits": {
        "total": {
            "value": 2,
            "relation": "eq"
        },
        "max_score": 1.0,
        "hits": [
            {
                "_index": "indices",
                "_type": "types",
                "_id": "1",
                "_score": 1.0,
                "_source": {
                    "first_name": "John",
                    "last_name": "Smith",
                    "age": 25,
                    "about": "I love to go rock climbing",
                    "interests": [
                        "sports",
                        "music"
                    ]
                }
            },
            ... # 更多数据
        ]
    }
}
```

* 搜索指定字段: `GET: localhost:9200/indices/types/_search?q=last_name:Smith`
    * 将查询语句传递给参数 `q=`


### 使用DSL语句查询
```sh
# 简单搜索
GET /indices/types/_search
{
    "query" : {
        "match" : {
            "last_name" : "Smith"
        }
    }
}

# 更复杂的搜索
# 教程比较旧，参考 https://www.cnblogs.com/miracle-luna/p/10989780.html
{
    "query" : {
        "bool" : {
            "filter" : {
                "range" : {
                    "age" : { "gt" : 30 }
                }
            },
            "must" : {
                "match" : {
                    "last_name" : "smith"
                }
            }
        }
    }
}


# 查询出错
{
    "status": 400
    "error": {
        "root_cause": [
            {
                "type": "parsing_exception",
                "reason": "unknown query [filtered]",
                "line": 3,
                "col": 22
            }
        ],
        "type": "parsing_exception",
        "reason": "unknown query [filtered]",
        "line": 3,
        "col": 22,
        "caused_by": {
            "type": "named_object_not_found_exception",
            "reason": "[3:22] unknown field [filtered]"
        }
    },
}
```

### 全文搜索 -- 拥有 “结果相关性评分”
* __相关性(relevance)__ 的概念在Elasticsearch中非常重要，而这个概念在传统关系型数据库中是不可想象的，因为传统数据库对记录的查询只有匹配或者不匹配。
```sh
# GET /indices/types/_search
{
    "query" : {
        "match" : {
            "about" : "rock climbing"
        }
    }
}

# 匹配的结果包含 "rock climbing"， "rock"， "climbing"， 
# 结果相关性评分。默认情况下，Elasticsearch根据结果相关性评分来对结果集进行排序，所谓的「结果相关性评分」就是文档与查询条件的匹配程度
{
    "took": 2,
    "timed_out": false,
    "_shards": {
        "total": 1,
        "successful": 1,
        "skipped": 0,
        "failed": 0
    },
    "hits": {
        "total": {
            "value": 2,
            "relation": "eq"
        },
        "max_score": 1.1143606,
        "hits": [
            {
                "_index": "indices",
                "_type": "types",
                "_id": "1",
                "_score": 1.1143606, # 评分，默认根据匹配度
                "_source": {
                    "first_name": "John",
                    "last_name": "Smith",
                    "age": 25,
                    "about": "I love to go rock climbing",
                    "interests": [
                        "sports",
                        "music"
                    ]
                }
            },
            {
                "_index": "indices",
                "_type": "types",
                "_id": "2",
                "_score": 0.13353139, # 评分，默认根据匹配度
                "_source": {
                    "first_name": "Jane",
                    "last_name": "Smith",
                    "age": 32,
                    "about": "I like to collect rock albums",
                    "interests": [
                        "music"
                    ]
                }
            }
        ]
    }
}
```


### 短语搜索
* 确切的匹配若干个单词或者 __短语(phrases)__
```sh
# GET /indices/types/_search
{
    "query" : {
        "match_phrase" : {
            "about" : "rock climbing"
        }
    }
}
```

### 高亮我们的搜索
```sh
# GET localhost:9200/indices/types/_search
{
    "query" : {
        "match_phrase" : {
            "about" : "rock climbing"
        }
    },
    "highlight": {
        "fields" : {
            "about" : {}
        }
    }
}

{
    "took": 66,
    "timed_out": false,
    "_shards": {
        "total": 1,
        "successful": 1,
        "skipped": 0,
        "failed": 0
    },
    "hits": {
        "total": {
            "value": 1,
            "relation": "eq"
        },
        "max_score": 1.1143606,
        "hits": [
            {
                "_index": "indices",
                "_type": "types",
                "_id": "1",
                "_score": 1.1143606,
                "_source": {
                    "first_name": "John",
                    "last_name": "Smith",
                    "age": 25,
                    "about": "I love to go rock climbing",
                    "interests": [
                        "sports",
                        "music"
                    ]
                },
                "highlight": {
                    "about": [
                        "I love to go <em>rock</em> <em>climbing</em>" # 匹配词添加高亮标签
                    ]
                }
            }
        ]
    }
}
```


### 检索多个文档 -- 批量搜索
* 合并多个请求可以避免每个请求单独的网络开销, 一个请求中使用 `multi-get` 或者 `mget` API

* 其中 index 和 type 可以放在 url 中， docs 内即可省去（如果 docs 里仍有index type 则优先）

* `POST /[index]/[type]/_mget`
```sh
# 请求
{
    "docs" : [
      {
         "_index" : "indices",
         "_type" :  "types",
         "_id" :    1
      },
      {
         "_index" : "test_index",
         "_type" :  "test_type",
         "_id" :    999
         # _source 指定查询字段
      }
   ]
}


# 响应
{
    "docs": [
        {
            "_index": "indices",
            "_type": "types",
            "_id": "1",
            "_version": 3,
            "_seq_no": 2,
            "_primary_term": 1,
            "found": true, # 查不到则为 false
            "_source": {
                "first_name": "John",
                "last_name": "Smith",
                "age": 25,
                "about": "I love to go rock climbing",
                "interests": [
                    "sports",
                    "music"
                ]
            }
        },
        {
            "_index": "test_index",
            "_type": "test_type",
            "_id": "999",
            "_version": 3,
            "_seq_no": 11,
            "_primary_term": 1,
            "found": true, 
            "_source": {
                "name": "test",
                "age": 3,
                "xxx": true
            }
        }
    ]
}
```


### 聚合(aggregations)
* 很像SQL中的 `GROUP BY` 但是功能更强大
* 说明： 这里 age 字段是数字，所以可以所聚合，如果是 text 类型，则需要配置 _mapping（不推荐）
    * 参考： https://blog.csdn.net/prufeng/article/details/108929293
```sh
# GET localhost:9200/indices/types/_search
{
    "aggs": {
    "all_ages": {
      "terms": { "field": "age" }
    }
    # 以下是无效案例，字段类型不允许聚合
    # 文本字段并未针对需要每个文档字段数据的操作（例如聚合和排序）进行优化，因此默认情况下将禁用这些操作。 请改用关键字字段。
    # Text fields are not optimised for operations that require per-document field data like aggregations and sorting, so these operations are disabled by default. Please use a keyword field instead. Alternatively, set fielddata=true on [interests] in order to load field data by uninverting the inverted index. Note that this can use significant memory.
    # "all_interests": {
    #   "terms": { "field": "interests" }
    # }
  }
}
```


### 版本控制
* 处理冲突:
    * 如果其他人同时也修改（机会很小）了这个文档，他们的修改将会丢失
    * 但是如果做 __秒杀__ 促销，就容易出现同时多个web进程处理一件商品的情况

* 秒杀 __库存冲突分析__:
    * `web_1`进程让 `stock_count` 失效是因为 `web_2` 进程没有察觉到 `stock_count` 的拷贝已经过期（__译者注__：`web_1` 取数据，减一后更新了 `stock_count`。可惜在 `web_1` 更新`stock_count` 前它就拿到了数据，这个数据已经是过期的了，当 `web_2` 再回来更新 `stock_count` 时这个数字就是错的。这样就会造成看似卖了一件东西，其实是卖了两件，这个应该属于幻读。）。结果是我们认为自己确实还有更多的商品，最终顾客会因为销售给他们没有的东西而失望。
    * 变化越是频繁，或读取和更新间的时间越长，越容易丢失我们的更改。


* 在数据库中，有两种通用的方法确保在并发更新时修改不丢失：
    * __悲观并发控制（Pessimistic concurrency control）__:
        * 这在关系型数据库中被广泛的使用，假设冲突的更改经常发生，为了解决冲突我们把 __访问区块化__。
        * 典型的例子是 __在读一行数据前锁定这行，然后确保只有加锁的那个线程可以修改这行数据__。
    * __乐观并发控制（Optimistic concurrency control）__:
        * 被Elasticsearch使用，假设冲突不经常发生，也不区块化访问，然而， __如果在读写过程中数据发生了变化，更新操作将失败__(根据比较 `_version` 数据是否发生变化)。
        * 这时候由程序决定在失败后如何解决冲突。实际情况中，可以重新尝试更新，刷新数据（重新读取）或者直接反馈给用户。

* ES的乐观并发控制：
    * Elasticsearch是分布式的。当文档被创建、更新或删除，文档的新版本会被复制到集群的其它节点。
    * Elasticsearch即是同步的又是异步的，意思是这些复制请求都是平行发送的，并 __无序(out of sequence)__ 的到达目的地。这就需要一种方法确保老版本的文档永远不会覆盖新的版本。
    * 利用 `_version` 的这一优点确保数据不会因为修改冲突而丢失。我们可以指定文档的 version 来做想要的更改。如果那个版本号不是现在的，我们的请求就失败了。

* 我们可以指定文档的version来做想要的更改。如果那个版本号不是现在的，我们的请求就失败了:
    * `PUT /website/blog/1?version=1` 
    * 这里的 version 表示当前文档的最新版本号，若指定的版本号与最新版本号不一致，那么无法更新文档索引

* 使用外部版本控制系统： (自定义/控制版本号)
    * > 一种常见的结构是使用一些其他的数据库做为主数据库，然后使用Elasticsearch搜索数据，这意味着所有主数据库发生变化，就要将其拷贝到Elasticsearch中。如果有多个进程负责这些数据的同步，就会遇到上面提到的 __并发问题__。

    * 在Elasticsearch的查询字符串后面添加 `version_type=external` 来使用这些版本号。版本号必须是整数


### 分布式
* Elasticsearch致力于隐藏分布式系统的复杂性。以下这些操作都是在底层自动完成的：
    * 将你的文档分区到不同的容器或者 __分片(shards)__ 中，它们可以存在于一个或多个节点中。
    * 将分片均匀的分配到各个节点，对索引和搜索做负载均衡。
    * 冗余每一个分片，防止硬件故障造成的数据丢失。
    * 将集群中任意一个节点上的请求路由到相应数据所在的节点。
    * 无论是增加节点，还是移除节点，分片都可以做到无缝的扩展和迁移。
