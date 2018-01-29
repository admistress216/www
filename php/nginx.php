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

