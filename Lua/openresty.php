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

ngx.exit(http-status), //结束请求并输出状态码,ngx.HTTP_SERVICE_UNAVAILABLE:503错误码
ngx.flush(), //将缓冲区内容输出至页面

'];