<?php
/**
 * 1.nginx请求处理所经阶段
 */
$arr = <<<Stage
执行前后顺序:
rewrite阶段(set指令等)->access阶段->content阶段(echo指令等)
Stage;

/**
 * 2.变量插值,过滤
 */
$arr = <<<'Lv'
set $a "hello%20world";
set_unescape_uri $b $a;
set $c "$b!"; //hello world!
Lv;

/**
 * 3.lua相关
 */
$lua = <<<'Lua'
content_by_lua_file /path/to/lua; //引入lua文件
set_by_lua $c lua_code; //引入lua代码,并把值赋给$c

Lua;

/**
 * 4.ngx.lua相关
 */
$ngxLua = <<<'ngxLua'
ngx.var.x //获取参数x的值
ngx.var[2] //获取nginx location中正则捕获组

ngxLua;


