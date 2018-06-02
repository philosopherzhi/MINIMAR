<?php

$base64 = isset($_GET['base64']) ? $_GET['base64']:"";
$id     = isset($_GET['id'])     ? $_GET['id']:"";
$path   = './images';

function base64_image_content($base64,$path,$id){
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)){
        print_r($result);
        $type = $result[2];
        $new_file = $path."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0777);
        }
        $new_file = $new_file.$id.".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64)))){
            echo '新文件保存成功：', $new_file;
            //return '/'.$new_file;
        }else{
            echo '新文件保存失败';
            return false;
        }
    }else{
        echo '新文件保存失败';
        return false;
    }
}
base64_image_content($base64,$path,$id);