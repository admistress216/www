<?php
/**
 * 1.下载,安装与启动
 */
$arr = [
    'addr' => 'nginx.org',
    './configure --prefix=/usr/local/nginx',
    'yum -y install pcre pcre-devel', //缺少pcre(用于正则)的情况
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
    '例子' => 'if ($remote_addr = 192.168.200.1) { return 403 }',
];

$arr = [ //条件写法
    '=' => '用来判断相等,用于字符串比较',
    '~' => '正则匹配,区分大小写',
    '~*' => '正则匹配,不区分大小写',
    '-f -d -e' => '判断是否为文件,为目录,是否存在',
];

$arr = [ //重写模式

];






























