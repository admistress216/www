<?php
$install = <<<Install
1.不用编译,本身就是编译后的二进制文件(解压后直接移动到/usr/local/下即可)
2.bin目录各文件作用:
bsondump:导出bson结构
mongo:客户端(相当于mysql.exe)
mongod:服务端(相当于mysqld.exe)
mongodump:整体数据库导出(二进制,相当于mysqldump)
mongoexport:导出易识别的json文档或csv文档
mongorestore:数据库整体导入
mongos:路由器(分片时用,集群)
3.启动mongodb服务:
./bin/mongod --dbpath /path/to/database --logpath /path/to/log --fork --port 27017
./bin/mongo 启动客户端
解释:
--dbpath 数据库存储目录
--logpath 日志存储目录
--port 运行端口(默认27017)
--fork 后台进程进行
--smallfiles 小空间占用形式启动(用于虚拟机磁盘空间不够时)
4.mongodb数据库非常耗磁盘空间,一般刚安装占用3-4G(du -h [dbpath])

Install;

$command = <<<Command

Command;

