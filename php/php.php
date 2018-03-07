<?php
/**
 * 1.substr与mb_substr的区别
 */

$arr = ["
substr($str,$start, $len);
mb_substr($str, $start, $len, $charset); //$str可以是中文字符,以字为单位截取
mb_substr('中文', 0, 1, 'utf-8');
"];

/**
 * 2.curl模拟put/delete发送,并用php接收,jquery也可实现put/delete发送(更改method参数)
 */
$arr = ["
curl -v -X PUT http://composer.com/test.php -d 'a=b&c=d' //-v:显示请求信息 -X:指定发送方式 -d:参数
$_SERVER\['REQUEST_METHOD'] //接收请求方式,如put/delete/post
file_get_contents('php://input') //接收put参数
curl -v -X DELETE http://composer.com/test.php?a=b
$_SERVER\['QUERY_STRING'] //接收delete数据

parse_str($str_param, $array) //解析参数字符串为数组,并赋值给$array
"];