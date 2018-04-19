<?php
/**
 * 1.安装apache
 */
$install = <<<Install
//缺少apr(可一直运行库)
wget http://archive.apache.org/dist/apr/apr-1.4.5.tar.gz 
tar -zxvf apr-1.4.5.tar.gz && cd apr....
./configure --prefix=/usr/local/apr
make && make install

//缺少apr-util
wget http://archive.apache.org/dist/apr/apr-util-1.3.12.tar.gz
tar -zxvf apr-util-1.3.12.tar.gz && cd apr-util....
./configure --prefix=/usr/local/apr-util --with-apr=/usr/local/apr
make && make install

//缺少pcre
wget http://jaist.dl.sourceforge.net/project/pcre/pcre/8.10/pcre-8.10.zip 
unzip -o pcre-8.10.zip && cd pcre....
./configure --prefix=/usr/local/pcre
make && make install

./configure --prefix=/usr/local/httpd --with-apr=/usr/local/apr \
--with-apr-util=/usr/local/apr-util \
--with-pcre=/usr/local/pcre
make && make install
/usr/local/apache/bin/apachectl start
Install;
