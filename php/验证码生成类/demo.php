<?php
include_once './Captcha.php';
$captcha = new Captcha();
$captcha->getAuthImage($captcha->make_rand(4));