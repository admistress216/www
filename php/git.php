<?php
$str = <<<Str
git commit -a //可以省略git add把文件加入暂存区,从而直接提交(只针对已经修改的文件,新文件还得用git add)
git commit --amend //提交但没有push,修改commit提交信息

Str;
