<?php
/**
 * 1.更改密码
 */
$arr = [
    'mysqladmin -uroot -proot password + 新密码', //更改密码
    'mysql -uroot -p +数据库 < +sql路径',//导入sql文件

];