<?php

/**
 * 1.pconnect 与 connect 的区别
 */
$arr = [
    'connect' => '脚本执行完立即释放连接资源',
    'pconnect' => '脚本执行完资源不立即释放,而是放在php-fpm进程中',
];

/**
 * 2.ordinary command
 */
$arr = <<<Command
exists key,
del key,
type key, //返回key的类型
randomkey, //从当前数据库返回随机key
rename oldkey newkey, //给key重命名(原子)

expire key seconds, //给key设定超时时间(秒)
ttl key, //查看剩余过期时间
persist key, //消除超时

setex key time value, //给key设置值和有效时长
mset key value [key1 value1], //给多个key设值
msetnx key value [key1 value1], //判断key是否存在并设值
mget key [key1], //获取多个key值
incr/decr key, //给键加一或减一,如果key不存在,则给key设为1/-1,
incrby/decrby key integer, //增加或减少指定值
incrbyfloat key floatnum, //增加浮点数,注:没有decrbyfloat
append key value, //追加字符串
strlen key, //返回key的长度

redis-cli --eval myscript.lua key1 key2,arg1 arg2 arg3 //执行lua脚本
Command;

/**
 * 3.set command
 * 无序，元素唯一不可重复，可用于去重
 */
$arr = <<<Set
smembers key, //返回集合中的所有成员
sadd key [member1] [member2], //集合中添加元素
scard key, //返回集合的成员数
srem key [member1] [member2], //集合中去除成员
substr key start end, //截取字符串,不改变字符串的值,下标从0开始
setrange key offset value, //改写字符串
getrange key start end, //getrange和substr功能类似

Set;

/**
 * 4.list command
 * 有序，元素可重复，可用作队列
 */
$arr = <<<List
lpush key string [string2], //江湖规矩:lpush,rpop
lpushx key string1 [string2], //该key存在时,才向key中插入值
linsert key before/after cc ccc, //在cc前/后插入ccc
llen key, //查看列表长度
lindex key index_value, //查看index对应的值
lrange key start end, //查看一段列表,lrange key 0 -1:查看全部数据
ltrim key start end, //截取元素(key值变为截取后的值)

lrem key count value, //count正负代表从左右去除值为value的count个元素
lpop/rpop,

lset key index value, //设定key[index]的值为value,index必须存在
blpop key1 [key2] timeout, //timeout设为0时,如果key1,key2不存在或者为空则一直处于堵塞状态,详情看第五点
List;

/**
 * 5.堵塞队列详解
 */
$arr = <<<Blocking
“blpop key1...keyN timeout 
从左到右扫描返回对第一个非空list进行lpop操作并返回，比如blpop list1 list2 list3 0 ,
如果list不存在list2,list3都是非空则对list2做lpop并返回从list2中删除的元素。如果所有的list都是空或不存在，
则会阻塞timeout秒，timeout为0表示一直阻塞。当阻塞时，如果有client对key1...keyN中的任意key进行push操作，
则第一在这个key上被阻塞的client会立即返回（返回键和值）。如果超时发生，则返回nil。有点像unix的select或者poll。

brpop
同blpop，一个是从头部删除一个是从尾部删除。

注意：不要采用其作为ajax的服务端推送，因为连接有限，遇到问题连接直接打满。

“BLPOP/BRPOP 的先到先服务原则 如果有多个客户端同时因为某个列表而被阻塞，那么当有新值被推入到这个列表时，
服务器会按照先到先服务（first in first service）原则，优先向最早被阻塞的客户端返回新值。举个例子，
假设列表 lst 为空，那么当客户端 X 执行命令 BLPOP lst timeout 时，客户端 X 将被阻塞。在此之后，
客户端 Y 也执行命令 BLPOP lst timeout ，也因此被阻塞。如果这时，客户端 Z 执行命令 RPUSH lst "hello" ，
将值 "hello" 推入列表 lst ，那么这个 "hello" 将被返回给客户端 X ，而不是客户端 Y ，因为客户端 X 的被阻塞
时间要早于客户端 Y 的被阻塞时间。”

“rpoplpush/brpoplpush：rpoplpush srckey destkey 从srckey对应list的尾部移除元素并添加到destkey对应
list的头部,最后返回被移除的元素值，整个操作是原子的.如果srckey是空或者不存在返回nil，注意这是唯一一个操作
两个列表的操作，用于两个队列交换消息。

应用场景：task + bak 双链表完成工作任务转交的安全队列，保证原子性。 
业务逻辑: 1: Rpoplpush task bak 2: 接收返回值,并做业务处理 3: 完成时用LREM消掉。
如不成功或者如果集群管理(如zookeeper)发现worker已经挂掉,下次从bak表里取任务”

“另一个应用场景是循环链表： 127.0.0.1:6379> lrange list 0 -1 
1) "c" 2) "b" 3) "a" 
127.0.0.1:6379> rpoplpush list list "a" 
127.0.0.1:6379> lrange list 0 -1 1) "a" 2) "c" 3) "b”

摘录来自: Pengcheng Huang. “Redis开发运维实践指南”。 iBooks. 
Blocking;


















