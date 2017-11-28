* 修复表: `REPAIR TABLE xxx`

* 清空表: `TRUNCATE TABLE xxx`
    * 自增id会重置为初始值

* 优化表: `OPTIMIZE TABLE xxx`
    * OPTIMIZE TABLE 用于回收闲置的数据库空间, 当表上的数据行被删除时, 所占据的磁盘空间并没有立即被回收, 使用了OPTIMIZE TABLE命令后这些空间将被回收, 并且对磁盘上的数据行进行重排（**注意**: 是磁盘上, 而非数据库）

    * 多数时间并不需要运行 OPTIMIZE TABLE, 只需在批量删除数据行之后, 或定期（每周一次或每月一次）进行一次数据表优化操作即可, 只对那些特定的表运行
