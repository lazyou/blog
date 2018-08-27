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

### 设置备份
```json
{
	"auto_complete": true,
	"auto_complete_commit_on_tab": false,
	"auto_complete_selector": "source, text",
	"binary_file_patterns":
	[
		"node_modules/**",
		"vender/**",
		"*.jpg",
		"*.jpeg",
		"*.png",
		"*.gif",
		"*.ttf",
		"*.tga",
		"*.dds",
		"*.ico",
		"*.eot",
		"*.pdf",
		"*.swf",
		"*.jar",
		"*.zip"
	],
	"color_scheme": "Packages/Color Scheme - Default/Mariana.sublime-color-scheme",
	"default_line_ending": "unix",
	"draw_minimap_border": true,
	"font_face": "Monaco",
	"font_size": 11,
	"highlight_line": true,
	"highlight_modified_tabs": true,
	"hot_exit": false,
	"ignored_packages":
	[
		"Vintage",
		"LiveStyle"
	],
	"line_padding_bottom": 1,
	"line_padding_top": 1,
	"tab_size": 4,
	"theme": "Default.sublime-theme",
	"translate_tabs_to_spaces": true,
	"trim_trailing_white_space_on_save": true,
	"word_wrap": true
}
```

* 每次重启sublime的时候非常占cpu： 因为重启时会对整个项目重新 index files 做索引
	* http://www.sublimetext.com/blog/articles/file-indexing

* sublime支持中文： http://blog.csdn.net/cywosp/article/details/32350899

* 常用插件: https://packagecontrol.io/installation
```
- Emmet  
- Ctags
- SublimeLinter  
- sublimelinter-php
- Alignment  
- SublimeText-Nodejs
- laravel5 Snippets  
- phpfmt
- git  
- AllAutocomplete
- DocBlockr  
- BracketHighlighter
- SideBarEnhancements
- HTML-CSS-JS Prettify
- babel
- sublimeLinter-jsxhint (npm install -g jsxhint)
- JsFormat
- Git Gutter
- EditorConfig
```