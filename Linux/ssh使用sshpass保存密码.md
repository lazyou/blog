## 借助 sshpass 保存 ssh 中的密码
* sudo apt-get install sshpass

* 编写 ssh_to_dev.sh 脚本并赋予执行权限
```ssh_to_dev.sh
#!/bin/bash
sshpass -p '服务器密码' ssh 服务器用户名@服务器ip
```
