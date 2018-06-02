<?php
include_once 'Snoopy.class.php';
$snoopy=new Snoopy();
$id       = isset($_POST['id'])     ? $_POST['id']:"";
$base64   = isset($_POST['base64']) ? $_POST['base64']:"";
$authurl  = "https://weixin.sky31.com/mima/VoteAdmin/pages/DataVisualization/authentication.php?operate=identify&id=".$id;
//echo $authurl;
$path     = './images';
preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result);
$name=$id.".{$result[2]}";
$base64_body = substr(strstr($base64,','),1);
$data= base64_decode($base64_body);
$imgSrc=  $path."/". $name;  //图片名字
//echo $imgSrc;
$r = file_put_contents($imgSrc, $data);//返回的是字节数
//echo $r;
if ($r) {
    //echo "true";
    $snoopy->fetch($authurl);
    $d1=$snoopy->results;
    $d1=json_decode($d1,true);
    //print_r($d1);
    $ans1=$d1['code'];
    $msgurl   = "https://weixin.sky31.com/mima/VoteAdmin/pages/DataVisualization/authentication.php?operate=sendMsg&id=".$id."&pic_url=".$imgSrc;
    $snoopy->fetch($msgurl);
    $d2=$snoopy->results;
    $d2=json_decode($d2,true);
    //print_r($d2);
    $ans2=$d2['code'];
    //echo $ans1.$ans2;
    if((!$ans1||$d1['msg']=="已认证")&&!$ans2) {
        $arr = array(
            'code'=>0,
            'msg'=>urlencode('认证成功'),
            'data'=>null
        );
        //echo "true";
        $jsonData = json_encode($arr);
        $jsonData = urldecode($jsonData);
        print_r($jsonData);
    }
    else {
        $arr = array(
            'code'=>1,
            'msg'=>urlencode('认证失败'),
            'data'=>null
        );
        //echo "true";
        $jsonData = json_encode($arr);
        $jsonData = urldecode($jsonData);
        print_r($jsonData);
    }
}else{
    $arr = array(
        'code'=>1,
        'msg'=>urlencode('认证失败'),
        'data'=>null
    );
    //echo "true";
    $jsonData = json_encode($arr);
    $jsonData = urldecode($jsonData);
    print_r($jsonData);
}
