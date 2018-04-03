## ssh 保持会话活跃
* https://stackoverflow.com/questions/25084288/keep-ssh-session-alive


### 配置解决
* sshd (the server) closes the connection if it doesn't hear anything from the client for a while. You can tell your client to send a sign-of-life signal to the server once in a while.

* The configuration for this is in the file "~/.ssh/config", create it if the configuration file does not exist. To send the signal every four minutes (240 seconds) to the remote host, put the following in your "~/.ssh/config" file.
```sh
Host remotehost:
    HostName remotehost.com
    ServerAliveInterval 240
```

* This is what I have in my "~/.ssh/config":

* To enable it for all hosts use:
```sh
Host *
ServerAliveInterval 240
```

Also make sure to run:
`chmod 600 ~/.ssh/config`

* because the config file must not be world-readable.


## 临时解决
* I wanted a one-time solution:
`ssh -o ServerAliveInterval=60 myname@myhost.com`

* Stored it in an alias:
`alias sshprod='ssh -v -o ServerAliveInterval=60 myname@myhost.com'`

* Now can connect like this:
`me@MyMachine:~$ sshprod`
