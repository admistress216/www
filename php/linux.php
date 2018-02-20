<?php
/**
 * 1.rsync同步命令
 */
$arr = [
    '-e + ssh/rsh' => '指定使用rsh或ssh传输数据',
    '--rsh=command' => '等同于-e',
    '--partial 保留那些因故没有完全传输的文件，以是加快随后的再次传输。',
    '-P' => '等同于--partial',
];

/**
 * 2.df与du
 */
$arr = [
    'du -sh + 目录/档案' => '统计目录或档案的总大小', //-h:human -s:sum(自己理解)
    'df -h' => '磁盘利用情况',
];