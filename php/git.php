<?php
$str = <<<Str
git commit -a //可以省略git add把文件加入暂存区,从而直接提交(只针对已经修改的文件,新文件还得用git add)

Str;

$str = <<<Amend
git commit --amend -m "" ////提交但没有push,修改commit提交信息
git commit --amend --author "authorName <authorname@mail.com>"
git commit --amend //将暂存区(index)内容合并到上次提交
Amend;


$str = <<<Log
git log --grep='' //对标题进行关键词筛选
git log -p [-n][commit_id]//对最近n条提交进行详细查看,没有n时展示所有,有commit_id时对单挑commit进行查看
git log --author=str //对某人进行查看,str可以是正则
git log --oneline //每个commit禁展示一行(标题)

Log;

$str = <<<Rm
git rm -r --cached test //递归删除index内文件及文件夹
git commit -m "rm test"
git push lzc_test HEAD //lzc_test:远程仓库名 HEAD:当前分支名(master/dev等-)

git reset HEAD^ --hard //删除commit
git push -f [remote] [branch] //强推远程
git reset --soft HEAD@{1} //没有推远程
--soft: 重置HEAD
--hard: 重置HEAD,index,workspace
Rm;

$str = <<<Remote
git remote -v //查看远程仓库(含url)

Remote;

$str = <<<Branch
git branch -a //显示所有分支(remote-tracking and local)
Branch;
