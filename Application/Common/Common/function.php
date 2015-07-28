<?php
/**
 * 打印
 * @param $data
 * @param int $is_die
 */
function pr($data, $is_die = 0)
{
    echo '<pre>';
    print_r($data);
    echo '</pre><br>';
    if ($is_die == 1) {
        exit;
    }
}

/**
 * 转换跳转的URL地址
 * @param string $refurl  需要跳转到的地址
 * @param string $default 默认跳转地址
 * @return string
 */
function refurl($refurl = '', $default = 'index/index')
{
    if (empty($refurl)) {
        $refurl = $_SERVER['HTTP_REFERER'];
    } else {
        $refurl = urldecode($refurl);
    }

    $refurl = strtolower($refurl);
    $host = parse_url($refurl);
    if ($_SERVER['HTTP_HOST'] == $host['host']) { //在同一域名中
        if (strpos($host['path'], 'login') > 0) { //除 登录 注册
            $refurl = U($default);
        } elseif (strpos($host['path'], 'reg') > 0) {
            $refurl = U($default);
        } else if(strpos($host['path'], 'passwd') > 0){
        	$refurl = U($default);
        }
    } else {
        $refurl = U($default);
    }
    return $refurl;
}