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

/**
 * 5.配置实操
 */
$config = <<<'Config'
/usr/servers/nginx/conf/nginx.conf配置文件如下(此处我们最小化了配置文件):
#user  nobody;  
worker_processes  2;  
error_log  logs/error.log;  
events {  
    worker_connections  1024;  
}  
http {  
    include       mime.types;  
    default_type  text/html;  
  
    #lua模块路径，其中”;;”表示默认搜索路径，默认到/usr/servers/nginx下找  
    lua_package_path "/usr/example/lualib/?.lua;;";  #lua 模块  
    lua_package_cpath "/usr/example/lualib/?.so;;";  #c模块  
    include /usr/example/example.conf;  
}

/usr/example/example.conf配置文件如下:
server {  
    listen       80;  
    server_name  _;  
  
    location /lua {  
        default_type 'text/html';  
        lua_code_cache off;  #清除lua的缓存,防止每次都重启nginx,线上打开
        content_by_lua_file /usr/example/lua/test.lua;  
    }  
}  
Config;

