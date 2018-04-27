<?php
/**
 * 1.py安装
 *
 */
$install = <<<Install
1.安装环境
yum -y groupinstall "Development tools"
yum -y install zlib-devel bzip2-devel openssl-devel ncurses-devel sqlite-devel readline-devel tk-devel gdbm-devel db4-devel libpcap-devel xz-devel
2.下载
wget https://www.python.org/ftp/python/3.6.2/Python-3.6.2.tar.xz
3.建文件夹
mkdir /usr/local/python3 
4.解压编译安装
tar -xvJf  Python-3.6.2.tar.xz
cd Python-3.6.2
./configure --prefix=/usr/local/python3
make && make install
5.创建软连接
ln -s /usr/local/python3/bin/python3 /usr/bin/python3
ln -s /usr/local/python3/bin/pip3 /usr/bin/pip3
Install;

/**
 * 2.py引包
 */
$packadge = <<<Package
import math
print(math.pi)
等价于
from math import pi
print(pi)
Package;


