<?php
//判断是否是https
function isHttps()
{
    if (!isset($_SERVER['HTTPS'])) return false;

    if ($_SERVER['HTTPS'] === 1 || $_SERVER['HTTPS'] === 'on' || $_SERVER['SERVER_PORT'] === 443) return true;

    return false;
}

function getDomain()
{
    $server_name = $_SERVER['SERVER_NAME'];
    return strpos($server_name, 'www.') !== false ? substr($server_name, 4) : $server_name;
}
$protocol = isHttps() ? 'https' : 'http';
$device = isset($_GET['device']) ? $_GET['device'] : '';
$appid = isset($_GET['appid']) ? $_GET['appid'] : '';
$state = isset($_GET['state']) ? $_GET['state'] : '';
$redirect_uri = isset($_GET['redirect_uri']) ? $_GET['redirect_uri'] : '';
$code = isset($_GET['code']) ? $_GET['code'] : '';
$scope = isset($_GET['scope']) ? $_GET['scope'] : 'snsapi_userinfo';

if (empty($code)) {
    $postfix = $device === 'pc' ? 'qrconnect' : 'oauth2/authorize';
    $authUrl = 'https://open.weixin.qq.com/connect/'. $postfix;

    $options = [
        'appid'         => $appid,
        'redirect_uri'  => urlencode($protocol. '://'. $_SERVER['HTTP_HOST']. $_SERVER['SCRIPT_FILENAME']),
        'response_type' => 'code',
        'scope'         => $scope,
        'state'         => $state
    ];
    //redirect_uri写入cookie
    header("Set-Cookie: redirect_uri=". urlencode($redirect_uri). "; path=/; domain=".
        getDomain(). "; expires=". gmstrftime("%A, %d-%b-%Y %H:%M:%S GMT", time() + 60). "; Max-Age=60; httponly");
    //请求wechat
    header('Location: '. $authUrl. http_build_query($options). '#wechat_redirect');
} else {
    $back_url = isset($_COOKIE['redirect_uri']) ? urldecode($_COOKIE['redirect_uri']) : '';
    if (!empty($back_url)) {
        header('Location: ' . implode('', [
                $back_url,
                strpos($back_url, '?') ? '&' : '?',
                'code=' . $code,
                '&state=' . $state
            ]));
    }
}