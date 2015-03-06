<?php
// 接收 图片数量  与index.html 中boxParam: 'num',对应
$num = $_GET["num"];
// 接收最大页数参数 与index.html 中maxPage:0,对应
$page = $_GET["page"];
$data = array();
// demo演示效果 预设最大页数为10页$page<11
if($page < 11){
	for($i=0;$i<$num;$i++)
	{
		$pNum=rand(1,44);
		$data[$i]["img"] = "images/P".$pNum.".jpg";
		$data[$i]["title"] = "时间：".date("Y-m-d H:i:s")."<br />".($i+1)."、WindsWaterFlow(第".$page."页)";
		$data[$i]["href"] = "http://www.baidu.com"; 
	}
}
echo json_encode($data);

?>