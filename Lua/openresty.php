<?php
/**
 * 参照地址:https://www.cnblogs.com/wangxusummer/p/4309007.html
 */

/**
 * 1.接收参数与三元表达式
 */
$arr = ['
local args = ngx.req.get_uri_args()
local page = args["page"] and tonumber(args["page"]) or 1
'];

/**
 * 2.指令和API
 */
$arr = [
    'lua_shared_dict' => '创建全局共享的table（多个worker进程共享）',
    'ngx.md5()' => '返回16进制MD5',

];

/**
 * 3.json化
 */
$arr = ['
local cjson = require("cjson")
local arr = {"liyi", "test"}
local data = cjson.encode(arr)
ngx.say(data)
cjson.decode(data) --json反序列化
'];

/**
 * 4.方法和常量
 */
$arr = ['
ngx.config.prefix(), //编译时prefix选项
ngx.config.nginx_configure(), //编译时./configure命令选项

'];

/**
 * 5.API中的方法
 */
$arr = ['
local file, err = io.open(ngx.config.prefix().."data.db", "r")
ngx.log(ngx.ERR, "open file err", err), //错误日志
ngx.req.get_headers(), //返回一个包含当前请求头信息的lua table.

ngx.exit(http-status), //结束请求并输出状态码,ngx.HTTP_SERVICE_UNAVAILABLE:503错误码
ngx.flush(), //将缓冲区内容输出至页面

'];

/**
 * 6.nginx server配置
 */
$arr = ["
lua_code_cache off; //lua代码缓存,这里off为了避免每次修改重新reload的麻烦,生产环境为on
lua_package_path '$prefix/lua/?.lua;/blah/?.lua;;'; //$prefix:指nginx的安装目录,两个;;指默认寻址目录(用于require寻址)
content_by_lua_file content_by_lua_file /Users/cctv/Documents/project/cctvnews_api/newscctv/$path.lua; //逻辑处理
access_by_lua_file /Users/cctv/Documents/project/cctvnews_api/newscctv/api_2_5_0/common/common.lua; //验证文件,做ip限制/格式转化等
"];

/**
 * 7.内置绑定变量访问
 */
$arr = [' //地址:http://wiki.jikexueyuan.com/project/openresty/openresty/inline_var.html
ngx.var.remote_addr //客户端ip
ngx.var.server_addr //服务器ip
ngx.var.nginx_version //nginx版本号

//例子(限制ip):
local black_ips = {["127.0.0.1"] = true}
local ip = ngx.var.remote_addr
if true == black_ips[ip] then
    ngx.exit(ngx.HTTP_FORBIDDEN)
end
'];

/**
 * 8.限制网速
 */
$arr = ['
location /download {
            access_by_lua_block {
                ngx.var.limit_rate = 1000
            };
        }
'];


































