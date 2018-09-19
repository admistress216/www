<?php
/**
 * 1.下载,安装与启动
 */
$arr = [
    'addr' => 'nginx.org',
    './configure --prefix=/usr/local/nginx',
    'yum -y install pcre pcre-devel zlib-devel', //缺少pcre(用于正则)和zlib(压缩算法)的情况
    'make && make install',
    './nginx', //启动
    'netstat -antp', //查看端口和占用程序
    'ps aux | grep nginx', //查看进程号
];

/**
 * 2.信号量
 */
$arr = [
    'wiki.nginx.org/CommandLine', //官方地址
    'kill+signal+pid', //格式
    'kill -INT/TERM +PID', //shutdown quickly
    'kill -QUIT +PID', //Graceful shutdown 优雅的关闭进程,等请求都结束后再关闭
    'kill -HUP +PID', //new processes,new config,and graceful shutdown old processes.
    'kill -USR1+PID', //用于日志分割
    'kill -HUP `cat logs/nginx.pid`', //不用输入pid的方式重启
    './nginx -h', //查看命令方式操作
];

/**
 * 3.1配置分析
 */
$arr = [
    'worker_processes', //工作进程个数配置(子进程),可设置,太大无意义,争夺cpu,一般设置为cpu数*核数(多了争夺cpu)
    'Event', //一般是配置nginx连接特性,如一个worker能同时允许多少连接
    'Event.worker_connections', //一个子进程允许的最大连接数
    'http', //主要是用来配置服务器(http大段内又包括各Server小段)
    'http.server', //用来配置虚拟主机
];

/**
 * 3.2虚拟主机配置
 * 分为基于域名,端口,ip的虚拟主机
 */
$arr = [
    'http.server' => [
        'listen' => 80, //监听端口数
        'server_name' => 'localhost', //所监听的域名,自主命名z.com等
        'location /' => [ //请求映射目录来响应请求
            'root' => 'pathname', //网站目录路径
            'index' => 'index.html', //默认访问文件名
        ],
    ],
];
$arr = [
    '
        server { //基于ip
          listen 80;
          server_name 192.168.1.200;
          location / {
                root ip;
                index test.html;
          }
        }
        server { //基于域名和端口的虚拟主机
          listen 80;
          server_name z.com;
          location / {
                root z.com;
                index test.html;
          }
        }
        server { //基于域名和端口的虚拟主机
            listen 2022;
            server_name z.com;
            location / {
                root /usr/local/nginx/2022.com;
                index test.html;
          }
        }
    '
];

/**
 * 4.logs日志管理
 */
$arr = [
    'nginx可以针对不同的server做不同的log',
    'access_log logs/host.accesss.log main' => '说明该server他的访问日志的文件是
        logs/host.access.log,使用的格式是main格式', //单个server内配置
    'log_format  main  \'$remote_addr - $remote_user [$time_local] "$request" \'
                       \'$status $body_bytes_sent "$http_referer" \'
                       \'"$http_user_agent" "$http_x_forwarded_for"\';',
    'main格式' => '用于记录以上选项',
    'main内选项解释' => [
        '$remote_addr' => '远程ip',
        '$remote_user[$time_local]' => '访问时间',
        '$request' => 'post/get',
        '$status' => '404,200等状态码',
        '$body_byte_sent' => 'body体字节数',
        '$http_referer' => '访问来源',
        '$http_user_agent' => '用户代理(浏览器类型等)信息',
        '$http_x_forwarded_for' => '中间代理x'
    ],
];

/**
 * 5.定时任务与日志切割
 */
$arr = [
    'date命令' => 'date -d yesterday +%y%m%d', //y:年份的后两位
    'crontab命令' => '分 时 日 月 周',
    'shell script' => '
        #!/bin/bash
        LOGPATH=/usr/local/nginx/logs/z.com.access.log
        BASEPATH=/data/$(date -d yesterday +%Y%m)
        
        mkdir -p $BASEPATH
        bak=$BASEPATH/$(date -d yesterday +%d%H%M).zcom.access.log
        mv LOGPATH $bak
        touch $LOGPATH //继续往$bak里写,与linux文件机制inode有关
        
        kill -USR1 $(cat /usr/local/nginx/logs/nginx.pid) //重写新的日志文件
    ',
    'crontab' => '*/1 * * * * sh /data/runlog.sh', //crontab命令
];

/**
 * 6.location
如何发挥作用?:
首先看有没有精准匹配,如果有,则停止匹配过程.
location = patt {
config A
}
如果 $uri == patt,匹配成功，使用configA
location = / {
root   /var/www/html/;
index  index.htm index.html;
}

location / {
root   /usr/local/nginx/html;
index  index.html index.htm;
}

如果访问　　http://xxx.com/
定位流程是　
1: 精准匹配中　”/”   ,得到index页为　　index.htm
2: 再次访问 /index.htm , 此次内部转跳uri已经是”/index.htm” ,
根目录为/usr/local/nginx/html
3: 最终结果,访问了 /usr/local/nginx/html/index.htm


再来看,正则也来参与.
location / {
root   /usr/local/nginx/html;
index  index.html index.htm;
}

location ~ image {
root /var/www/image;
index index.html;
}

如果我们访问  http://xx.com/image/logo.png
此时, “/” 与”/image/logo.png” 匹配
同时,”image”正则 与”image/logo.png”也能匹配,谁发挥作用?
正则表达式的成果将会使用.

图片真正会访问 /var/www/image/logo.png



location / {
root   /usr/local/nginx/html;
index  index.html index.htm;
}

location /foo {
root /var/www/html;
index index.html;
}
我们访问 http://xxx.com/foo
对于uri “/foo”,   两个location的patt,都能匹配他们
即 ‘/’能从左前缀匹配 ‘/foo’, ‘/foo’也能左前缀匹配’/foo’,
此时, 真正访问 /var/www/html/index.html
原因:’/foo’匹配的更长,因此使用之.;
 */

/**
 * 7.rewrite 模块
 */

$arr = [ //重写中用到的指令
    'if (条件){重写模式}', //设定条件再进行重写
    '例子' => [
        'if ($remote_addr = 192.168.200.1) { return 403 }',
        'if ($http_user_agent ~ Chrome){
                        rewrite ^.*$ /ie.html;  //只要是谷歌浏览器,无论是任何内容都跳转到ie.html下(所在目录为root定)
                        break; //防止一直重定向
                }
        ',
        ///usr/local/nginx/html/abc.html
        'fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;', //fastcgi.conf文件中查询各个变量的含义
        'if (!-e $document_root$fastcgi_script_name){ //脚本文件不存在,重写到404.html
                        rewrite ^.*$ /404.html;
                        break;
                }
',
    ],
];

$arr = [ //条件写法
    '=' => '用来判断相等,用于字符串比较',
    '~' => '正则匹配,区分大小写',
    '~*' => '正则匹配,不区分大小写',
    '-f -d -e' => '判断是否为文件,为目录,是否存在',
];

$arr = [ //set是设置变量用的,可以用来达到多条件判断时作标志用,达到apache下的rewrite_condition的效果
    'if ($http_user_agent ~* msie) {
        set $isid 1;
    }
    if ($fastcgi_script_name = ie.html) {
        set $isie 0;
    }
    if ($isie 1) {
        rewrite ^.*$ ie.html
    }
    ',
];

$arr = [
    'location /ecshop {
                root html/;
                rewrite "goods-(\d{1,7})\.html" /ecshop/goods.php?id=$1; //对/ecshop文件夹下的goods-12.html进行重写,写为html目录下/ecshop/goods.php?id=12
        }'
];

$arr = ['
例：http://localhost:88/test1/test2/test.php?k=v
$host：localhost
$server_port：88
$request_uri：/test1/test2/test.php?k=v
$document_uri：/test1/test2/test.php
$document_root：D:\nginx/html
$request_filename：D:\nginx/html/test1/test2/test.php
$1:匹配正则表达式匹配的第一个值,$2..以此类推
$host:访问域名或ip,curl "http://localhost/lua_request/1/2":localhost,curl "http://127.0.0.1/lua_request/1/2":127.0.0.1, 浏览器访问http://192.168.200.130/lua_request/1/2:显示192.168.200.130
'];

/**
 * 8.nginx+php编译
 */
$arr = [
    'apache与nginx的区别' => 'apache一般是把php当做自己的模块来启动的
                                而nginx则是把http请求变量(如get,user_agent等)转发给
                                php独立进程,即php独立进程与nginx进行通信.称为fastcgi
                                运行方式',
    'location ~ \.php$ {
            root           html;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }' => '
            1.碰到php文件,
            2.把根目录定位到html,
            3.把请求上下文转交给9000端口的php进程,
            4.并告诉php进程,当前的脚本是$document_root(定位的html目录)$fastcgi_scriptname
        ',
    '
准备:
yum -y install mysql mysql-devel mysql-server //装mysql
yum -y install gd gd-devel freetype libxml2-devel
wget https://curl.haxx.se/download/curl-7.60.0.tar.gz --no-check-certificate
tar zxvf curl-7.60.0.tar.gz && cd curl-7.60.0
./configure --prefix=/usr/local/curl && make && make install

编译php(连接mysql,gd,ttf并以fpm/fastcgi方式运行)[nginx方式]:
./configure --prefix=/usr/local/php \
--with-config-file-path=/usr/local/php/etc \
--enable-mysqlnd \
--enable-pdo \
--with-pdo-mysql \
--with-mysqli \
--with-gd \
--with-openssl \
--with-zlib \
--enable-zip \
--with-freetype-dir=/usr/include/freetype2/freetype \
--with-curl=/usr/local/curl \
--enable-gd-jis-conv \
--enable-fpm  #作用:产生php-fpm进程管理器以及配置文件

参数说明:
--with-config-file-path: 指定php.ini位置
--with-openssl: openssl的支持，https加密传输时用到的
--with-zlib: 打开zlib支持
--enable-bcmath: 允许使用高精度数学函数 

[apache方式]:
./configure --prefix=/usr/local/fastphp --with-mysql=mysqlnd \
--enable-mysqlnd \
--enable-pdo \
--with-pdo-mysql \
--with-mysqli \
--with-gd \
--enable-gd-native-ttf \
--enable-gd-jis-conv \
--with-apxs2=/usr/local/httpd/bin/apxs //作用:将php作为apache子模块

make && make install
cp /usr/local/src/php-5.6.36/php.ini-development /usr/local/php/etc/php.ini
cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf
/usr/local/php/sbin/php-fpm && ps aux | grep php
service mysqld start #启动mysql
pkill -9 php-fpm #杀死php进程',

];

/**
 * 9.localhost与127.0.0.1的区别
 */
$arr = [
    'localhost' => '是用socket连接数据库的,所以需配置php.ini中mysql.default_socket=/var/lib/mysql/mysql.sock',
    '127.0.0.1' => '是用tcp连接的'
];

/**
 * 10.gzip compress
 */
$arr = ['
gzip on; #打开gzip
gzip_buffers 32 4k; #压缩在内存中缓冲32块,每块4k
gzip_comp_level 6; #压缩级别6
gzip_min_length 4000; #最少四千字节开始压缩
gzip_types text/css text/xml application/javascript application/x-javascript text/javascript image/jpeg image/gif image/png; #压缩的格式,都是header头中的Content-type
'];

/**
 * 11. expires设置
 */
$arr = ['
location ~ image {
    root html;
    expires 1d; //缓存1天
}
'];

/**
 * 12. 304原理
 */
$arr = ['
服务器相应文件内容时,同时响应etag标签(内容的签名,内容一变,他也变)和last_modified_since标签,
浏览器下次去请求时,头信息发送这两个标签,服务器检查文件有没有发生变化,如无,则直接头信息返回etag,last_modified_since.
'];

/**
 * 13. 防盗链和禁止访问
 */
$arr = ['
        valid_referers none www.baidu.com; //只允许无referer和百度访问
        if ($invalid_referer) {
          return 403;
        }
        deny all; //禁止访问
'];

/**
 * 14.反向代理
 */
$arr = ['
proxy_pass http://127.0.0.1:8080
'];

/**
 * 15.域名重定向
 */
$arr = ['
server { //在server内写
    server_name www.example.com;
    return 301 $scheme://example.com$request_uri;
}
'];
/**
 * 16.负载均衡
 * proxy_pass不允许写多个,需要把多台服务器用upstream指令绑定在一起,并起一个组名
 * 然后用proxy_pass指向改组
 */
$arr = ['
    log_format  main  \'$remote_addr - $remote_user [$time_local] "$request" \'
                      \'$status $body_bytes_sent "$http_referer" \'
                      \'"$http_user_agent" "$http_x_forwarded_for"\';
    upstream imgserver {
                server 192.168.200.130:81 weight=1 max_fails=2 fail_timeout=3;
                server 192.168.200.130:82 weight=1 max_fails=2 fail_timeout=3;
        }
    server {
            listen 81;
            server_name localhost;
            root html;
            access_log logs/81-access.log main;
    }
    server {
            listen 82;
            server_name localhost;
            root html;
            access_log logs/82-access.log main;
    }
    location ~* \.(jpg|jpeg|gif|png) {
                proxy_set_header X-Forwarded-For $remote_addr; //设置(传递)访问ip
                proxy_pass http://imgserver;
        }

'];


























