http://www.cnblogs.com/jiangyao/archive/2011/01/26/1945570.html

在linux下一般用 scp 这个命令来通过ssh传输文件。

* 1、从服务器上下载文件
`scp username@servername:/path/filename /var/www/local_dir（本地目录）`

* 2、上传本地文件到服务器
`scp /path/filename username@servername:/path`

* 3、从服务器下载整个目录
`scp -r username@servername:/var/www/remote_dir/（远程目录） /var/www/local_dir（本地目录）`

* 4、上传目录到服务器
`scp  -r local_dir username@servername:remote_dir`


注：目标服务器要开启写入权限。
