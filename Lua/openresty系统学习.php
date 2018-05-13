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

-- 获取请求头,可以用for pairs do和if then循环判断得出,默认获取前100,获取全部用get_headers(0)
ngx.req.get_headers()
ngx.req.get_uri_args() //获取get请求的uri参数
-- 获取post数据
-- 另外在读取post内容体时根据实际情况设置
-- client_body_buffer_size和client_max_body_size来保证内容在内存而不是在文件中。
ngx.req.read_body() //也可以在nginx配置文件中使用lua_need_request_body on;开启(官方不推荐)
ngx.req.get_post_args()
-- http协议版本
ngx.req.http_version()
-- 请求方法
ngx.req.get_method()
-- 请求的body内容体
ngx.req.get_body_data()

-- 更改响应头及状态码
ngx.header.a = "1"
ngx.header.b = {"2","3"}
ngx.say()
ngx.print() //say调用print并输出一个换行符
return ngx.exit(200) //更改状态码,其前有say输出会导致状态更改失败
-- 重定向
ngx.redirect("http://jd.com", 302/301/307)

-- 未解码的请求uri
ngx.var.request_uri
-- 解码
ngx.unescape_uri(ngx.var.request_uri)
-- md5
ngx.md5("abc")
-- http time(server time)
ngx.http_time(ngx.time())
-- 总结
ngx.escape_uri/ngx.unescape_uri ： uri编码解码；
ngx.encode_args/ngx.decode_args：参数编码解码；
ngx.encode_base64/ngx.decode_base64：BASE64编码解码；
ngx.re.match：nginx正则表达式匹配；
更多Nginx Lua API请参考 http://wiki.nginx.org/HttpLuaModule#Nginx_API_for_Lua。

-- 共享全局变量，在所有worker间共享(http部分)  
lua_shared_dict shared_data 1m; --其中shared_data为共享名称
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

