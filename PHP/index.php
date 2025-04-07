<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('/TVBox|okhttp/i', $user_agent)) {
    // 返回 TV 配置文件
    header('Content-Type: application/json');
    echo file_get_contents('tv.json');
} else {
    // 跳转到其他页面
	header('Location: https://google.com');
    exit;
}
?>
