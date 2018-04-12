<?php
/**
 * 1.rsync同步命令
 * 类似的命令scp,赋值目录/文件(scp -r ....)
 */
$arr = [
    '-e + ssh/rsh' => '指定使用rsh或ssh传输数据',
    '--rsh=command' => '等同于-e',
    '--partial 保留那些因故没有完全传输的文件，以是加快随后的再次传输。',
    '-P' => '等同于--partial',
    'example' => 'rsync -P --rsh=ssh cnk_tujun@103.240.246.145:/home/cnk_tujun/cnk.sql /users/tujun',
];

/**
 * 2.df与du
 */
$arr = [
    'du -sh + 目录/档案' => '统计目录或档案的总大小', //-h:human -s:sum(自己理解)
    'df -h' => '磁盘利用情况',
];

/**
 *3.安装mysql
 */
$arr1 = <<<Install
groupadd mysql
useradd -g group -s /sbin/nologin -M mysql, //-s:定义shell,-M : 不建立根目录,-g:指定组
mkdir -p /data/mysql/data,
chown -R mysql:mysql /data/mysql,

yum -y install gcc gcc-c++ cmake ncurses-devel bison,
wget --no-check-certificate https://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.39.tar.gz, //下载
'];
Install;

$arr2 = <<<Cmake
//编译安装cmake+make+make install
# cmake ./

# -DCMAKE_INSTALL_PREFIX=/usr/local/mysql          \    #安装路径

# -DMYSQL_DATADIR=/usr/local/mysql/data            \    #数据文件存放位置

# -DSYSCONFDIR=/etc                                \    #my.cnf路径

# -DWITH_MYISAM_STORAGE_ENGINE=1                   \    #支持MyIASM引擎

# -DWITH_INNOBASE_STORAGE_ENGINE=1                 \    #支持InnoDB引擎

# -DWITH_MEMORY_STORAGE_ENGINE=1                   \    #支持Memory引擎

# -DWITH_READLINE=1                                \    #快捷键功能(我没用过)

# -DMYSQL_UNIX_ADDR=/tmp/mysqld.sock               \    #连接数据库socket路径

# -DMYSQL_TCP_PORT=3306                            \    #端口

# -DENABLED_LOCAL_INFILE=1                         \    #允许从本地导入数据

# -DWITH_PARTITION_STORAGE_ENGINE=1                \    #安装支持数据库分区

# -DMYSQL_USER=mysql                                \   #mysqld运行用户

# -DEXTRA_CHARSETS=all                             \    #安装所有的字符集

# -DDEFAULT_CHARSET=utf8                           \    #默认字符

# -DDEFAULT_COLLATION=utf8_general_ci
# make && make install

cmake ./ \
-DCMAKE_INSTALL_PREFIX=/usr/local/mysql         \
-DMYSQL_DATADIR=/data/mysql/data                \
-DSYSCONFDIR=/etc                                \
-DWITH_MYISAM_STORAGE_ENGINE=1                   \
-DWITH_INNOBASE_STORAGE_ENGINE=1                 \
-DMYSQL_UNIX_ADDR=/data/mysql/mysqld.sock        \
-DMYSQL_TCP_PORT=3306                            \
-DENABLED_LOCAL_INFILE=1                         \
-DWITH_PARTITION_STORAGE_ENGINE=1                \
-DMYSQL_USER=mysql                               \
-DEXTRA_CHARSETS=all                             \
-DDEFAULT_CHARSET=utf8                           \
-DDEFAULT_COLLATION=utf8_general_ci

make&&make install,

chown -R mysql:mysql /usr/local/mysql/,
mv /usr/local/src/mysql-5.6.39/support-files/my-default.cnf /etc/my.cnf //选择覆盖

mv /usr/local/src/mysql-5.6.39/support-files/mysql.server /etc/init.d/mysqld //服务端启动放入服务中service mysqld start
chmod a+x /etc/init.d/mysqld,
chkconfig --level 345 mysqld on, //开机启动

echo "export PATH=/usr/local/mysql/bin/:$PATH" >> /etc/profile
source /etc/profile //设置环境变量,方便客户端启动

//初始化设置(user,配置文件,基础目录,数据目录)
/usr/local/mysql/scripts/mysql_install_db \
--user=mysql \
--defaults-file=/etc/my.cnf \
--basedir=/usr/local/mysql \
--datadir=/data/mysql/data

vim /etc/my.cnf
user=mysql
basedir=/usr/local/mysql
default-storage-engine=Innodb
datadir=/data/mysql/data //放置于mysql模块
service mysqld reload
service mysqld start

/usr/bin/mysqladmin -u root password \'z\' //修改密码
mysql -u root -p  -P port //登录

说明:
参数说明:
-DCMAKE_INSTALL_PREFIX=/usr/local/mysql //安装目录
-DMYSQL_DATADIR=/usr/local/mysql/data //数据库存放目录
-DWITH_MYISAM_STORAGE_ENGINE=1 //安装myisam存储引擎
-DWITH_INNOBASE_STORAGE_ENGINE=1 //安装innodb存储引擎
-DWITH_ARCHIVE_STORAGE_ENGINE=1 //安装archive存储引擎
-DWITH_BLACKHOLE_STORAGE_ENGINE=1 //安装blackhole存储引擎
-DENABLED_LOCAL_INFILE=1 //允许从本地导入数据
-DDEFAULT_CHARSET=utf8 　　//使用utf8字符
-DDEFAULT_COLLATION=utf8_general_ci //校验字符
-DEXTRA_CHARSETS=all 　　//安装所有扩展字符集
-DMYSQL_TCP_PORT=3306 //MySQL监听端口
-DMYSQL_USER=mysql //MySQL用户名
其他参数:
-DWITH-EMBEDDED_SERVER=1 //编译成embedded MySQL library (libmysqld.a)
-DSYSCONFDIR=/etc //MySQL配辑文件
-DMYSQL_UNIX_ADDR=/tmp/mysqld.sock //Unix socket 文件路径
-DWITH_READLINE=1 //快捷键功能
-DWITH_SSL=yes //SSL
-DWITH_MEMORY_STORAGE_ENGINE=1 //安装memory存储引擎
-DWITH_FEDERATED_STORAGE_ENGINE=1 //安装frderated存储引擎
-DWITH_PARTITION_STORAGE_ENGINE=1 //安装数据库分区
-DINSTALL_PLUGINDIR=/usr/local/mysql/plugin //插件文件及配置路径
Cmake;

/**
 * 4.设置自动登录
 */
$arr = <<<Login
方法一(先生成.ssh(ssh-keygen -t rsa -P '')再执行一下命令):
ssh-copy-id -i ~/.ssh/id_rsa.pub 用户名@对方机器IP (注意不要忘记了参数-i)

方法二:
将公钥直接拷贝到~/.ssh/authorized_keys(先用方法一生成,搞权限配置太麻烦)
Login;
