<?php
/*
 *用excel类导出excel。导出性能相比前两种方法：速度慢，可支持数据量小
 * @author:liyiyang
 * @date : 2016-06-06
 */
header("Content-Type:text/html;charset=utf-8");
//载入PHPExcel类
require_once "Classes/PHPExcel.php";
//用于输出.xls的
require_once 'Classes/PHPExcel/Writer/Excel5.php';
// 或者require_once 'Classes/PHPExcel/Writer/Excel2007.php';
set_time_limit(0);//设置程序执行时间，0为没有时间上的限制
ini_set("memory_limit", "-1");//取消内存限制

/*-----------------声明变量--------------------------*/
$host = '127.0.0.1';//要链接的服务器
$username = 'root';//数据库用户名
$password = '123456';//数据库密码
$dbname = 'db_zou';//数据库
$charset = 'set names utf8';//设置字符集
$filename = 'a.xls';//文件名
$path = './'.$filename;//保存excel文件的位置

//创建一个excel对象实例
$objPHPExcel = new PHPExcel();
//缺省情况下，PHPExcel会自动创建第一个sheet被设置SheetIndex=0
$objPHPExcel->setActiveSheetIndex(1);
//设置当前活动sheet的名称
$objPHPExcel->getActiveSheet()->setTitle('测试Sheet');

/*------设置excel的属性(非必要属性)-----------------*/
//创建人
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
//最后修改人
$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
//标题
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
//题目
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
//描述
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
//关键字
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
//种类
$objPHPExcel->getProperties()->setCategory("Test result file");


/*--------链接数据库查询--------------------------*/

//链接数据库
$con = mysql_connect($host,$username,$password) or die ('database connect failed');
//链接数据库
mysql_select_db($dbname,$con);
//设置字符集
mysql_query($charset);
$sql = "select * from excel_demo limit 1";
$result = mysql_query($sql);
//设置第一行的名称
$objPHPExcel->getActiveSheet()->SetCellValue('A1', '字符串形式数字');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', '日期');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', '数字');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', '货币');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', '百分比');
$n = 2;
while($row = mysql_fetch_assoc($result)) 
{
    //设置单元格的值
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$n, $row['string'],PHPExcel_Cell_DataType::TYPE_STRING);//字符串(防止数值型字符串科学计数法)
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$n,$row['date']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$n,$row['number']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$n,$row['money']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$n,$row['percent']);
    //设置单元格值的形式
    $objPHPExcel->getActiveSheet()->getStyle('D'.$n)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);//设置金额格式 11,333.00
    $objPHPExcel->getActiveSheet()->getStyle('E'.$n)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);//设置百分比格式 0.30 30.00%
    $n++;
}
/*------------------设置单元格属性(可以将某些属性写入上面的循环里)---------------------*/
/*
//合并单元格：
$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
//设置单元格宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
//设置表头行高
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);//第一行 : 字符串形式数字
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(22);//第二行 : 日期
//设置字体样式
//'A1:E3' 表示从A1到E3所有单元格
http://www.cnblogs.com/freespider/p/3284828.html
$objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getFont()->setName('黑体');// 黑体/宋体
$objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getFont()->setBold(true);//加粗
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);//设置下划线
$objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);//设置字体颜色:红色
//设置居中
$objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//所有垂直居中
$objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//设置自动换行
$objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getAlignment()->setWrapText(true); 
*/
//输出文档
 $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
 //或者$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);//保存excel—2007格式
 if(1 == 1)
 {
     //保存文件位置
    $objWriter->save($path);//保存文件 参数为文件目录及文件名
 }
 //直接输出到浏览器（输出时会把文件保存到一个默认的路径，用户无法选择路径）
 header("Pragma: public");
 header("Expires: 0");
 header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
 header("Content-Type:application/force-download");
 header("Content-Type:application/vnd.ms-execl");
 header("Content-Type:application/octet-stream");
 header("Content-Type:application/download");
 header("Content-Disposition:attachment;filename=".$filename);
 header("Content-Transfer-Encoding:binary");
 $objWriter->save("php://output");
?>
