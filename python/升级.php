<?php
$update = <<<Update
查看python的版本

[plain] view plain copy
#python  -V    
Python 2.6.6  

1.下载Python-2.7.3
[plain] view plain copy
#wget http://python.org/ftp/python/2.7.3/Python-2.7.3.tar.bz2  

2.解压
[plain] view plain copy
#tar -jxvf Python-2.7.3.tar.bz2  

3.更改工作目录
[plain] view plain copy
#cd Python-2.7.3  

4.安装
[plain] view plain copy
#./configure  
#make all             
#make install  
#make clean  
#make distclean  

5.查看版本信息
[plain] view plain copy
#/usr/local/bin/python2.7 -V  

6.建立软连接，使系统默认的 python指向 python2.7
[plain] view plain copy
#mv /usr/bin/python /usr/bin/python2.6.6  
#ln -s /usr/local/bin/python2.7 /usr/bin/python  

7.重新检验Python 版本
[plain] view plain copy
#python -V  

8解决系统 Python 软链接指向 Python2.7 版本后，因为yum是不兼容 Python 2.7的，所以yum不能正常工作，我们需要指定 yum 的Python版本
[plain] view plain copy
#vi /usr/bin/yum  


将文件头部的
#!/usr/bin/python

改成
#!/usr/bin/python2.6.6


Update;
