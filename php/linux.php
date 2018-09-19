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
 * 4.设置自动登录
 */
$arr = <<<Login
方法一(先生成.ssh(ssh-keygen -t rsa -P '')再执行一下命令):
ssh-copy-id -i ~/.ssh/id_rsa.pub 用户名@对方机器IP (注意不要忘记了参数-i)

方法二:
将公钥直接拷贝到~/.ssh/authorized_keys(先用方法一生成,搞权限配置太麻烦)
Login;

/**
 * 5.yum初始化环境安装
 */
$arr = <<<Yum
yum -y install gcc automake autoconf libtool make
 
yum -y install gcc gcc-c++ glibc
 
yum -y install libmcrypt-devel mhash-devel libxslt-devel 
libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel libxml2 libxml2-devel 
zlib zlib-devel glibc glibc-devel glib2 glib2-devel bzip2 bzip2-devel 
ncurses ncurses-devel curl curl-devel e2fsprogs e2fsprogs-devel 
krb5 krb5-devel libidn libidn-devel openssl openssl-devel
Yum;
