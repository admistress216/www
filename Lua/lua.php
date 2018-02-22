<?php
/**
 * 1.setup
 */
$arr = ['
curl -R -O http://www.lua.org/ftp/lua-5.3.0.tar.gz
tar zxf lua-5.3.0.tar.gz
cd lua-5.3.0
yum install libtermcap-devel ncurses-devel libevent-devel readline-devel(linux环境安装)
make linux test(linux)make macosx test(mac)
make install
'];