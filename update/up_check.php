<?php

    // $url = "https://api.github.com/repos/zhufenghua1998/bp3/releases/latest";
    $url = "http://bp3-fc.52dixiaowo.com/";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT,"zhufenghua1998");
    
    $fp = curl_exec($ch); 
    
    echo $fp;
?>