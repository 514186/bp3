<?php
    session_start();
    $config = require_once("../config.php");
    require_once("../functions.php");
    
    
    // 1.获取state
    $state = $_SESSION['state'];
    if($state!=$_GET['state']){
        echo '{"error":"invalid state"}';
        die;
    }
    // 2.获取基础连接信息
    
    $code = $_GET['code'];
    $app_id = $config['inner']['app_id'];
    $secrect_key = $config['inner']['secret_key'];
    $redirect_uri = $config['inner']['redirect_uri'];
    
    // 3.callback请求
    $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=authorization_code&code=$code&client_id=$app_id&client_secret=$secrect_key&redirect_uri=$redirect_uri&state=$state";
    
    $opt = easy_build_http("GET");
    $result = easy_file_get_content($url,$opt);
    
    
    // 4.结果处理，存入session并重定向
    // 动态增加授权地址grant_url和刷新地址refresh_url
    $grant_url = get_dir_url(basename(__FILE__));
    $refresh_url = $grant_url.'refresh.php';
    
    $json = json_decode($result);
    $json->grant_url=$grant_url;
    $json->refresh_url=$refresh_url;
    $result = json_encode($json);
    
    $_SESSION['result'] = $result;
    if($_SESSION['display']=='display'){
        header("Location: ./display.php");
    }else{
        $display = urldecode($_SESSION['display']);
        $encode_result = urlencode($result);
        // 重定向并携带参数
        $redirect_param = $display.'?param='.$encode_result;
        header("Location: $redirect_param");
    }
?>
    