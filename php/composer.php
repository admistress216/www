<?php
/**
 * 1.composer下载
 */
$str = <<<Download
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
或者
wget https://getcomposer.org/composer.phar
mv composer.phar /usr/local/bin/composer
Download;

/**
 * 2.中国镜像全局配置
 */
$str = <<<Global
composer config -g repo.packagist composer https://packagist.phpcomposer.com
Global;



/**
 *
                       composer自动加载功能
二、

1.首选新建一个PHP项目文件夹

2.可以手动写一个composer.json，内容如下：

[plain] view plain copy
{
"autoload": {
"files": ["comm/functions.php"]
}
}

从上面json信息，我们可以大致猜测，这是要做文件的自动加载。
同时，我们新建好comm目录和functions.php文件。这个项目结构如图：



完成上面操作，我们打开终端，cd到 test目录下面，执行命令：

[plain] view plain copy
composer dump-autoload
然后在看我们的项目，多出来一个vendor目录，里边就是composer的东西：


至此，我们应该来测试一下，composer到底怎么做自动加载的？

我们在comm目录下的functions.php写了一个函数：

[php] view plain copy
function  showName() {
echo '我的名字';
}

然后我们要在index.php中，调用这个函数。
常规的方法是先要require 'comm/functions.php'， 然后才能调用funcitons.php中定义的函数。

下面我们看composer的方式：

[php] view plain copy
// 下面使用composer来做自动加载
// 1.第一步
require __DIR__.'/vendor/autoload.php';
// 2.使用
showName();
在浏览器访问index.php，我们可以看到成功调用了showName函数。

我们继续在comm目录下，新建一个test.php文件：

[php] view plain copy
<?php
function test(){
echo 'test';
}
这个时候，我们要想在index.php中能调用test()函数，
需要：在composer.json中增加：

[plain] view plain copy
"files": ["comm/functions.php","comm/test.php"]
然后到在终端，同样还是在项目目录下，执行：
[plain] view plain copy
composer dump-autoload
完成上面2步，我们就可以在index.php中，调用test()函数了。


下面，我们来看一下类是如何自动加载的？

我们新建一个Class目录，里面新建一个User.php：

[php] view plain copy
<?php
class User{

}
然后修改composer.json文件：
[plain] view plain copy
{
"autoload": {
"files": ["comm/functions.php","comm/test.php"],
"classmap": ["Class/"]
}
}
完成上面操作，同样是需要在终端下执行：composer dump-autoload

最后，我们在index.php中测试：
[php] view plain copy
$user = new User();
var_dump($user);
成功打印：object(User)#3 (0) { }

 *
 */