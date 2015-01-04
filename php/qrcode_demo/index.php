<?php
define(APP_PATH, dirname(__FILE__));
require_once(APP_PATH . "/library/phpqrcode.php");  //引入二维码工具类
define(QRCODE_PATH, APP_PATH . '/img/');            //生存的二维码图片存放路径 不生成图片文件 可以省略
$id = 123456;                                       //虚拟文章ID 自定义
$qrValue = 'http://localhost/' . $id . '.html';     //二维码存储内容  URL
$qrPath  = QRCODE_PATH . $id . '.png';              //二维码生成路径+文件名
/*
	静态方法
	public static function png($text, $outfile=false, $level=QR_ECLEVEL_L, $size=3, $margin=4, $saveandprint=false)
	参数$text表示生成二位的的信息文本
	参数$outfile表示是否输出二维码图片文件，默认否
	参数$level表示容错率，也就是有被覆盖的区域还能识别：
	           分别是 L（QR_ECLEVEL_L，7%），M（QR_ECLEVEL_M，15%），Q（QR_ECLEVEL_Q，25%），H（QR_ECLEVEL_H，30%）
	参数$size表示生成图片大小，默认是3
	参数$margin表示二维码周围边框空白区域间距值
	参数$saveandprint表示是否保存二维码并显示
*/
QRcode::png($qrValue, $qrPath, 'L', 5, 4,false);      //注意  这里的生成路径变量默认是false 直接输出二维码图片
$str = '<img src= http://localhost/qrcode_demo/img/' . $id . '.png />';
echo $str;
