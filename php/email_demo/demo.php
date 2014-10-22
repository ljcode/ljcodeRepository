<?php
/*
* php发送email邮件的demo
* author:liangxifeng833@163.com
* date: 2014-10-21
 */
header("Content-Type:text/html; charset=utf-8");
	include '/include/email.class.php';//导入邮件发送类库
	include '/include/mail.config.php';//导入邮件参数配置文件
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass); //实例化邮件发送类
	$smtpemailto ='547096390@qq.com';										//接收邮件地址
	$mailsubject = '=?UTF-8?B?'.base64_encode('这里是发件标题描述').'?=';
	$mailshowname = '=?UTF-8?B?'.base64_encode('发件人张三').'?=';          //发件人姓名显示
	$mailbody = '<h1>发件正文内容:在这里添加邮件的正文内容</h1>';
	$smtp_status = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype, $mailshowname); //发送邮件
	if($smtp_status === true)
	{
		echo '发送成功';
	}else
	{
		echo '发送失败';
	} 
?>
