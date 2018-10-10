## du命令 实现Linux 某个文件夹下的文件按大小排序
* https://www.cnblogs.com/mfryf/p/3243211.html

1. df -lh

2. du -s /usr/* | sort -rn
这是按字节排序

3. du -sh /usr/* | sort -rn
这是按兆（M）来排序

4.选出排在前面的10个
du -s /usr/* | sort -rn | head

5.选出排在后面的10个
du -s /usr/* | sort -rn | tail

du -h –-max-depth=0 user
du -sh –-max-depth=2 | more
