### 简述
* 重点： 
    * 理解 mysql存 储引擎 MyISAM / InnoDB / Memory （主要是前两中）。
* https://laravel-china.org/articles/4198/mysql-common-data-storage-engine
***


#### 简介
> mysql 有多种存储引擎，目前常用的是 **MyISAM** 和 **InnoDB** 这两个引擎，除了这两个引擎以为还有许多其他引擎，有官方的，也有一些公司自己研发的。这篇文章主要简单概述一下常用常见的 MySQL 引擎，一则这是面试中常被问到的问题，二则这也是数据库设计中不可忽略的问题，用合适的引擎可以更好的适应业务场景，提高业务效率。

#### MyISAM
> MyISAM 是 mysql 5.5.5 之前的默认引擎，它支持 `B-tree/FullText/R-tree` 索引类型。
>
> 锁级别为 __表锁__，表锁优点是开销小，加锁快； 缺点是锁粒度大，发生锁冲动概率较高，容纳*并发能力低*，这个引擎*适合查询为主的业务*。
>
> 此引擎 *不支持事务，也不支持外键*。
>
> MyISAM __强调了快速读取操作__。它存储表的行数，于是 `SELECT COUNT(*) FROM TABLE` 时只需要直接读取已经保存好的值而不需要进行全表扫描。


#### InnoDB
> InnoDB 存储引擎最大的亮点就是 __支持事务，支持回滚__，它支持 `Hash/B-tree` 索引类型。
>
> 锁级别为 __行锁__，行锁优点是 __适用于高并发的频繁表修改，高并发是性能优于 MyISAM__。缺点是系统消耗较大，索引不仅缓存自身，也缓存数据，相比 MyISAM 需要更大的内存。
>
> InnoDB 中不保存表的具体行数，也就是说，执行 `select count(*) from table` 时，InnoDB 要扫描一遍整个表来计算有多少行。
>
> 支持事务，支持外键。


#### ACID 事务
> A 事务的 **原子性** (Atomicity)：指一个事务要么全部执行，要么不执行。也就是说一个事务不可能只执行了一半就停止了。比如你从取款机取钱，这个事务可以分成两个步骤：1）划卡，2）出钱。不可能划了卡,而钱却没出来，这两步必须同时完成，要么就不完成。
>
> C 事务的 **一致性** (Consistency)：指事务的运行并不改变数据库中数据的一致性。例如，完整性约束了 a+b=10，一个事务改变了 a，那么 b 也应该随之改变。
>
> I **独立性**(Isolation）：事务的独立性也有称作隔离性，是指两个以上的事务不会出现交错执行的状态。因为这样可能会导致数据不一致。
>
> D **持久性**(Durability）：事务的持久性是指事务执行成功以后，该事务所对数据库所作的更改便是持久的保存在数据库之中，不会无缘无故的回滚。


#### Memory
> Memory 是 _内存级别存储引擎_，数据存储在内存中，所以他能够存储的数据量较小。
>
> 因为内存的特性，存储引擎对数据的一致性支持较差。锁级别为 _表锁_，_不支持事务_。 但 _访问速度非常快_，并且默认使用 hash 索引。
>
> Memory 存储引擎使用存在内存中的内容来创建表，每个 Memory 表只实际对应一个磁盘文件，在磁盘中表现为 `.frm` 文件。

#### 总结
<table>
  <thead>
    <tr>
      <th/>  
      <th style="text-align:center;">MyISAM</th>  
      <th style="text-align:center;">InnoDB</th> 
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>存储结构</td>  
      <td style="text-align:center;">每张表被存放在三个文件：frm-格定义MYD(MYData)-数据文件MYI(MYIndex)-索引文件</td>  
      <td style="text-align:center;">所有的表都保存在同一个数据文件中（也可能是多个文件，或者是独立的表空间文件），InnoDB表的大小只受限于操作系统文件的大小，一般为2GB</td> 
    </tr>
    <tr>
      <td>存储空间</td>  
      <td style="text-align:center;">MyISAM可被压缩，存储空间较小</td>  
      <td style="text-align:center;">InnoDB的表需要更多的内存和存储，它会在主内存中建立其专用的缓冲池用于高速缓冲数据和索引</td> 
    </tr>
    <tr>
      <td>可移植性、备份及恢复</td>  
      <td style="text-align:center;">由于MyISAM的数据是以文件的形式存储，所以在跨平台的数据转移中会很方便。在备份和恢复时可单独针对某个表进行操作</td>  
      <td style="text-align:center;">免费的方案可以是拷贝数据文件、备份 binlog，或者用 mysqldump，在数据量达到几十G的时候就相对痛苦了</td> 
    </tr>
    <tr>
      <td>事务安全</td>  
      <td style="text-align:center;">不支持 每次查询具有原子性</td>  
      <td style="text-align:center;">支持 具有事务(commit)、回滚(rollback)和崩溃修复能力(crash recovery capabilities)的事务安全(transaction-safe (ACID compliant))型表</td> 
    </tr>
    <tr>
      <td>AUTO_INCREMENT</td>  
      <td style="text-align:center;">MyISAM表可以和其他字段一起建立联合索引</td>  
      <td style="text-align:center;">InnoDB中必须包含只有该字段的索引</td> 
    </tr>
    <tr>
      <td>SELECT</td>  
      <td style="text-align:center;">MyISAM更优</td>  
      <td style="text-align:center;"/> 
    </tr>
    <tr>
      <td>INSERT</td>  
      <td style="text-align:center;"/>  
      <td style="text-align:center;">InnoDB更优</td> 
    </tr>
    <tr>
      <td>UPDATE</td>  
      <td style="text-align:center;"/>  
      <td style="text-align:center;">InnoDB更优</td> 
    </tr>
    <tr>
      <td>DELETE</td>  
      <td style="text-align:center;"/>  
      <td style="text-align:center;">InnoDB更优 它不会重新建立表，而是一行一行的删除</td> 
    </tr>
    <tr>
      <td>COUNT without WHERE</td>  
      <td style="text-align:center;">MyISAM更优。因为MyISAM保存了表的具体行数</td>  
      <td style="text-align:center;">InnoDB没有保存表的具体行数，需要逐行扫描统计，就很慢了</td> 
    </tr>
    <tr>
      <td>COUNT with WHERE</td>  
      <td style="text-align:center;">一样</td>  
      <td style="text-align:center;">一样，InnoDB也会锁表</td> 
    </tr>
    <tr>
      <td>锁</td>  
      <td style="text-align:center;">只支持表锁</td>  
      <td style="text-align:center;">支持表锁、行锁 行锁大幅度提高了多用户并发操作的新能。但是InnoDB的行锁，只是在WHERE的主键是有效的，非主键的WHERE都会锁全表的</td> 
    </tr>
    <tr>
      <td>外键</td>  
      <td style="text-align:center;">不支持</td>  
      <td style="text-align:center;">支持</td> 
    </tr>
    <tr>
      <td>FULLTEXT全文索引</td>  
      <td style="text-align:center;">支持</td>  
      <td style="text-align:center;">不支持（5.6.4以上支持英文全文索引） 可以通过使用Sphinx从InnoDB中获得全文索引，会慢一点</td> 
    </tr>
  </tbody>
</table>

> 互联网项目中随着硬件成本的降低及缓存、中间件的应用，**一般我们选择都以 InnoDB 存储引擎为主，很少再去选择 MyISAM 了**。而业务真发展的一定程度时，自带的存储引擎无法满足时，这时公司应该是有实力去自主研发满足自己需求的存储引擎或者购买商用的存储引擎了。
