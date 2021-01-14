## tp.test
```nginx
server {
    listen 80;
    server_name www.pp.test pp.test;
    root /home/vagrant/Code/tp5/public;

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        # try_files \$uri \$uri/ /index.php?\$query_string;
        if (!-e $request_filename) {
            rewrite  ^(.*)$  /index.php?s=/$1  last;
            break;
        }
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log /var/log/pp.test-access.log combined;
    error_log /var/log/pp.test-error.log;

    error_page 404 /index.php;

    sendfile off;

    location ~ \.php$ {
        # fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_split_path_info ^((?U).+.php)(/?.+)$;

        fastcgi_param PATH_INFO $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        # include fastcgi.conf;
    }

    location ~ /\.ht {
        deny all;
    }
}
````
