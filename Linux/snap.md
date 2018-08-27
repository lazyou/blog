## snap
* https://snapcraft.io

* https://snapcraft.io/store (支持搜索)

* https://uappexplorer.com/snaps

* 各种软件都有 VSCode jetbrains系列 RedisDesktopManager 等等


## Snap软件包介绍
* 首先要说什么是「包」？Linux 中应用程序的安装通常有两种方式：其一，是直接通过源代码编译安装，需要用户手动执行脚本、处理依赖等不太人性化的操作；其二，是由软件发行商将应用程序打包成「软件包」进行交付，例如 Ubuntu 用户直接双击 .deb（Debian 软件包） 文件即可安装软件。

* 什么是 snap，snap 是一种全新的软件包管理方式，它类似一个容器拥有一个应用程序所有的文件和库，各个应用程序之间完全独立。所以使用 snap 包的好处就是它解决了应用程序之间的依赖问题，使应用程序之间更容易管理。但是由此带来的问题就是它占用更多的磁盘空间
`snap` 软件包一般安装在 `/snap` 目录下

* 常用命令：
```sh
snap find <包名>
sudo snap install <包名>
sudo snap remove <包名>
sudo snap refresh <包名> -- 升级
sudo snap revert <snap name> -- 还原到之前版本

snap list
snap changes -- 更改历史记录
```
