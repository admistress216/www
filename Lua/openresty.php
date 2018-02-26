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
 * 4.
 */