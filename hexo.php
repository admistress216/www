<?php
/**
 * 1.hexo启动
 */
$arr = <<<Start
hexo clean,
hexo generate,
hexo server //run server
Start;

/**
 * 2.创建文章
 */
$arr = <<<Create
hexo new <title>,

Create;

