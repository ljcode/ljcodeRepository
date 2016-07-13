<?php
//处理图片上传
if($_FILES['file']['error'] > 0){  
   echo '!problem:';  
   switch($_FILES['file']['error'])  
   {  
     case 1: echo '文件大小超过php.ini中upload_max_filesize限制的值';  
             break;  
     case 2: echo '上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值';  
             break;  
     case 3: echo '文件只有部分被上传';  
             break;  
     case 4: echo '文件加载失败，没有文件被上传！';  
             break;  
   }  

   exit;  
}  
if($_FILES['file']['size'] > 2*1024*1024){ //文件大小限制2M
   echo '文件过大！';  
   exit;  
}  
if($_FILES['file']['type']!='image/jpeg' && $_FILES['file']['type']!='image/png'){  
   echo '文件不是JPG或者PNG图片！';  
   exit;  
}  
$today = date("YmdHis");  
$filetype = $_FILES['file']['type'];  //文件类型
if($filetype == 'image/jpeg'){  
  $type = '.jpg';  
}  
if($filetype == 'image/png'){  
  $type = '.png';  
}  
$upfilePath = '/img/img_group/' . $today . $type;  //文件上传路径
if(is_uploaded_file($_FILES['file']['tmp_name']))  //文件上传
{  
   if(!move_uploaded_file($_FILES['file']['tmp_name'], $upfilePath))  
   {  
     echo '移动文件失败！';  
     exit;  
    }  
}  
else  
{  
   echo 'problem!';  
   exit;  
} 
//页面上图片输出路径
$path = 'http://img.ljlj.loc/img_group/'.$today . $type;
?>
<!-- 这是iframe的内连框架，主要目的是把上传完的图片路径输出，html接收到这个路径，获取到不跳页面立即显示 -->
<!DOCTYPE html>
<html>
    <head>
        <meta name ="viewport" content= "initial-scale=1.0, user-scalable=no" >
        <meta http-equiv ="Content-type" content= "text/html;charset:utf-8" >
        <script type ="text/javascript" src= "jquery-1.7.2.min.js"></script>
    </head>
    <body >
		<div id= "pic" style = "diplay:none;" ><?php echo $path; ?></div>
    </body>
</html>
