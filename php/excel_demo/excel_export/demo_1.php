<?php
/*
* desc:导出excel-demo-2
* author: liangxifeng
* Create time:2013-11-21
*/
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=Vipvisitor_info.xls"); 


//输出内容如下：   
echo iconv("utf-8", "GB2312", "序号")."\t";
echo iconv("utf-8", "GB2312", "姓名")."\t"; 
echo iconv("utf-8", "GB2312", "发布展商")."\t";
echo iconv("utf-8", "GB2312", "公司名称")."\t";
echo iconv("utf-8", "GB2312", "地址")."\t";   
echo iconv("utf-8", "GB2312", "职务")."\t";
echo iconv("utf-8", "GB2312", "部门")."\t";

echo iconv("utf-8", "GB2312", "邮编")."\t";
echo iconv("utf-8", "GB2312", "电话")."\t";
echo iconv("utf-8", "GB2312", "手机")."\t";
echo iconv("utf-8", "GB2312", "电子邮箱")."\t";
echo iconv("utf-8", "GB2312", "发布时间")."t";
echo iconv("utf-8", "GB2312", "处理结果备注")."\t";
echo "\n"; 
$n = 1;
foreach ($res as $value)
{
    $sql = "SELECT a.corpname_cn FROM te_corp_baseinfo a JOIN te_offlineex b ON a.id=b.bid AND b.id=".$value['oeid'];
    $arr = $Model->query($sql);
    $value['corpname_cn'] = $arr[0]['corpname_cn']; 
    $value['cTime'] = date('Y-m-d H:i:s',$value['cTime']);

    //输出表格内容
    echo $n."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['name']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['corpname_cn']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['corpname']))."\t"; 
    echo iconv("utf-8", "GB2312", addslashes($value['corpaddress']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['duties']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['department']))."\t";

    echo iconv("utf-8", "GB2312", addslashes($value['zipcode']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['phone']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['mobile']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['email']))."\t";
    echo iconv("utf-8", "GB2312", $value['cTime'])."\t";
    echo iconv("utf-8", "GB2312", addslashes($value['status_remark']))."\t"; 
    echo "\n"; 
    $n++;
}
