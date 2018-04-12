<?php
/**
 * 1.更改密码
 */
$arr = [
    'mysqladmin -uroot -proot password + 新密码', //更改密码
    'mysql -uroot -p +数据库 < +sql路径',//导入sql文件
    'mysqldump -uroot -p [-d] +数据库 > sql文件', //导出sql文件,-d:no data(仅结构)
];