## Sublime
* 官网: https://www.sublimetext.com

* 安装: https://www.sublimetext.com/docs/3/linux_repositories.html


### ppa 安装 sublime
```sh
wget -qO - https://download.sublimetext.com/sublimehq-pub.gpg | sudo apt-key add -

sudo apt-get install apt-transport-https

echo "deb https://download.sublimetext.com/ apt/stable/" | sudo tee /etc/apt/sources.list.d/sublime-text.list

sudo apt-get update

sudo apt-get install sublime-text
```