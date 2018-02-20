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
 * 2.
 */