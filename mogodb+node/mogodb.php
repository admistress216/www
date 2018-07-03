<?php
/**
 * 1.安装启动
 */
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
例如:./bin/mongod --dbpath /home/m17/ --logpath /home/mlog/m17.log --fork --port 27017 --bind_ip_all(mkdir /home/m17/ /home/mlog)
./bin/mongo 启动客户端
解释:
--dbpath 数据库存储目录
--logpath 日志存储目录
--port 运行端口(默认27017)
--fork 后台进程进行
--bind_ip_all 允许远程访问(默认绑定本机)
--smallfiles 小空间占用形式启动(用于虚拟机磁盘空间不够时)
4.mongodb数据库非常耗磁盘空间,一般刚安装占用3-4G(du -h [dbpath])

Install;

/**
 * 2.1命令相关
 */
$command = <<<Command
1.show dbs/databases:显示数据库
2.use databaseName:选库
3.show tables/collections:显示数据表
4.db.help():查看命令
5.只能隐式创建数据库
<1>use shop(选择没有的数据库)
<2>db.createCollection('user')
<3>show dbs; //发现创建成功
6.隐式创建collection
db.collectionName.insert(document)
7.删除collection
db.collectionName.drop()
8.删除数据库
db.dropDatabase()
Command;

/**
 * 2.2命令相关
 */
$command1 = <<<'Command'
1.db.user.insert({name:'lisi',age:22}) //插入数据
db.user.insert({_id:2,name:'poly',age:23})
db.user.insert({_id:3,name:'han',hobby:['basketball','football'],intro:{title:'My intro',content:'from china'}})
db.user.find() //查看数据
2.db.stu.insert([{_id:1,sn:'003',name:'xiaoming'},{sn:'004',name:'guanyu'},{sn:'005',name:'liu'}]) //插入多条
db.stu.remove({sn:'003'}) //删除学号为003的文档
db.stu.remove({},false) //删除所有 sb.collectionName.remove('查询表达式','选项'):选项含义:是否只删除一行,默认为true
db.stu.update({name:'xiaoming'},{name:'xiaoxiaoming'})  //替换全部字段
db.stu.update({name:'xiaoming'},{$set:{name:'xiaoxiaoming'}}) //替换条件字段

Command;

/**
 * 2.3js运算符
 */
$opr = <<<'Opr'
$inc //增长
$rename //重命名列
setOnInsert //当update时,设置字段的值
$set //设置字段的新值
$unset //删除指定的列
db.stu.insert({
    name:'wukong',
    jinggu: true,
    sex: 'm',
    age: 500
})
db.stu.update({name:'wukong'},{
    $set:{name:'xiaoxiaoming'},
    $unset:{jinggu:1},
    $rename:{sex:'gender'},
    $inc:{age:16}
})
//如果有name='wuyong'的文档,将被修改,如果没有,将添加此文档
db.stu.update({name:'wuyong'},{$set:{name:'junshiwuyong'}},{upsert:true});
//添加附加字段
db.stu.update({name:'wuyong'},{$set:{name:'junshiwuyong'},$setOnInsert:{gender:'male'}},{upsert:true});
Opr;

/**
 * 3.select
 */
$select = <<<Select
db.collectionName.find(查询表达式,列)
db.collectionName.find({},{gender:1,_id:0}) //显示带有gender的列,id不显示
db.collectionName.find({gender:'male'}, {name:1, _id:0}) //查询gender为male属性的name值,不显示id属性
Select;

/**
 * 4.深入查询表达式
 */
$query = <<<Query
db.goods.count() //统计条数

Query;





















