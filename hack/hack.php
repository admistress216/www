<?php
/**
 * 1.test
 * sql test
 */
$test = <<<Test
magic_quotes_gpc = off, //关闭过滤
$sql="select * from users where username='$name' and password=md5('$pwd')";
正常:
$sql = "select * from users where username='marcofly' and password=md5('test')"
注入(' or 1=1#,),:
$sql = "select * from users where username='marcofly' or 1=1#' and password=md5('')"
=>$sql = "select * from users where username='marcofly' or 1=1 "
#作用:防止and后面的语句生效干扰


char()
HEX()
Test;
