<?php
error_reporting(E_ALL); // 开启所有错误报告，便于调试
header('Content-Type: text/json;charset=UTF-8');
date_default_timezone_set("Asia/Shanghai");

// 生成随机token
function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

// 检查token有效性，设置有效期为40分钟
session_start();
$token = $_GET["token"] ?? "";
$tokenValid = false;

// 检查token是否存在并且在有效期内
if ($token) {
    if (isset($_SESSION['token']) && $_SESSION['token'] === $token) {
        $tokenValid = true;
    } else {
        // 如果token不匹配，生成新的token
        $token = generateToken();
        $_SESSION['token'] = $token;
        $_SESSION['token_time'] = time();
    }
} else {
    // 生成新的token
    $token = generateToken();
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();
}

// 检查token是否过期（40分钟）
if (isset($_SESSION['token_time']) && (time() - $_SESSION['token_time']) > 2400) {
    // token过期，生成新的token
    $token = generateToken();
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();
}

// 继续执行其他逻辑
$name = $_GET["id"] ?? "";
$port = 'http://50.7.234.10:8278/';
$ts = $_GET["ts"] ?? "";

// 如果没有有效的token，则重定向到带有token的URL
if (!$tokenValid) {
    $redirectUrl = $_SERVER['PHP_SELF'] . "?id=" . urlencode($name) . "&token=" . $token;
    header("Location: $redirectUrl");
    exit();
}

// 下面的逻辑保持不变
$ip = '127.0.0.1';
$header = array(
    "CLIENT-IP:" . $ip,
    "X-FORWARDED-FOR:" . $ip,
);

if ($ts) {
    $host = $port . $name . "/";
    $url = $host . $ts;
    $data = curl_get($url, $header);
    echo $data;
} else {
    $url = $port . $name . "/playlist.m3u8";
    $seed = "tvata nginx auth module";
    $path = parse_url($url, PHP_URL_PATH);
    $tid = "mc42afe745533";
    $t = strval(intval(time() / 150));
    $str = $seed . $path . $tid . $t;
    $tsum = md5($str);
    $link = http_build_query(["ct" => $t, "tsum" => $tsum]);
    $url .= "?tid=$tid&$link";

    $parseUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

    $result = curl_get($url, $header);
    
    // 检查返回结果
    if (empty($result) || strpos($result, "404 Not Found") !== false) {
        header("Location: http://vjs.zencdn.net/v/oceans.mp4");
        exit();
    }

    if (strpos($result, "EXTM3U") !== false) {
        $m3u8s = explode("\n", $result);
        $result = '';
        foreach ($m3u8s as $v) {
            if (strpos($v, ".ts") !== false) {
                $result .= $parseUrl . "?id=" . $name . "&ts=" . $v . "&token=" . $token . "\n";
            } else {
                if ($v != '') {
                    $result .= $v . "\n";
                }
            }
        }
    }
    echo $result;
}
exit();

function curl_get($url, $header = array())
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    
    $data = curl_exec($curl);
    
    // 获取HTTP状态码
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if ($httpCode == 404) {
        // 如果返回404，则返回空数据
        $data = null;
    }

    if (curl_error($curl)) {
        return "Error: " . curl_error($curl);
    } else {
        curl_close($curl);
        return $data;
    }
}
?>
