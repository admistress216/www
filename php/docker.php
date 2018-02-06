<?php
/*
 * 1.镜像命令
 */
$arr = [
    'docker info' => '查看docker的详细信息',
    'docker search + 软件镜像', //在仓库内搜索镜像
    'docker pull + 镜像名称', //下载镜像
    'docker images', //查看镜像
    'docker rmi + imageid', //删除镜像

];

/**
 * 2.根据镜像操作容器
 */
$arr = [
    'docker run --imageName -h hostname' => [
        '例子' => 'docker run centos /bin/echo \'hello world\''
    ], //启动容器
    'docker stop containerid', //停止容器
    'docker ps' => [
        'docker ps -a', //查看所有容器
    ], //查看容器
    'docker exec|attach', //进入容器
    'docker rm', //删除容器
];