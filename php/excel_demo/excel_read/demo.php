<?php
/*
 * 读取excel-demo
 * date:2014-10-19
 * author:liangxifeng 
 */
header("Content-Type:text/html; charset=utf-8");
require_once('Classes/PHPExcel.php');
set_time_limit(0);
ini_set("memory_limit","-1");
function touft8($content)
{
	return iconv("GBK","UTF-8",$content);
}
//excel日期转换函数
function excelTime($days){
	if(is_numeric($days)){
		//based on 1900-1-1
		$jd = GregorianToJD(1, 1, 1970);
		$gregorian = JDToGregorian($jd+intval($days)-25569);
		$myDate = explode('/',$gregorian);
		$myDateStr = str_pad($myDate[2],4,'0', STR_PAD_LEFT)
		."-".str_pad($myDate[0],2,'0', STR_PAD_LEFT)
		."-".str_pad($myDate[1],2,'0', STR_PAD_LEFT);
		return $myDateStr;
	}
	return $days;
}
$phpreader = new PHPExcel_Reader_Excel5();
$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;   
$cacheSettings = array('memoryCacheSize'=>'200MB'); 
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
$excel = $phpreader->load('data.xls');
$cursheet = $excel->getSheet(0);
$col = PHPExcel_Cell::columnIndexFromString($cursheet->getHighestColumn());
$row = $cursheet->getHighestRow();

$file_write = fopen('excel.sql','a');
for($currow=2;$currow<=$row;$currow++)
{
	//$pro_model = addslashes(trim($cursheet->getCellByColumnAndRow(1,$currow)->getValue()));
	$enterprice		= $cursheet->getCellByColumnAndRow(0,$currow)->getValue();//企业名称
	$category_name	= $cursheet->getCellByColumnAndRow(1,$currow)->getValue();//产品类别
	$division_name	= $cursheet->getCellByColumnAndRow(2,$currow)->getValue();//细分类别
	$pro_brand		= $cursheet->getCellByColumnAndRow(3,$currow)->getValue();//产品品牌
	$pro_model		= $cursheet->getCellByColumnAndRow(4,$currow)->getValue();//产品型号
	$pro_price		= sprintf('%.2f',$cursheet->getCellByColumnAndRow(5,$currow)->getValue());//明码实价价格
	$merchant_name	= $cursheet->getCellByColumnAndRow(6,$currow)->getValue();//生产企业或厂家
	$remark			= $cursheet->getCellByColumnAndRow(7,$currow)->getValue();//备注
	$start_time		= excelTime($cursheet->getCellByColumnAndRow(8,$currow)->getValue());//起始时间
	$end_time		= excelTime($cursheet->getCellByColumnAndRow(9,$currow)->getValue());//结束时间
	$inset_sql = 'INSERT INTO csv_2 (enterprice,category_name,division_name,pro_brand,pro_model,pro_price,merchant_name,remark,start_time,end_time) VALUES(\''.$enterprice.'\',\''.$category_name.'\',\''.$division_name.'\',\''.$pro_brand.'\',\''.addslashes($pro_model).'\',\''.$pro_price.'\',\''.$merchant_name.'\',\''.$remark.'\',\''.$start_time.'\',\''.$end_time.'\');';
	fwrite($file_write,$inset_sql."\n");
	//var_dump($enterprice,$category_name,$division_name,$pro_brand,$pro_model,$pro_price,$start_time,$end_time);exit;
}
fclose($file_write);
