<?php
/*
* desc:导出excel-demo-1
* author: liangxifeng
* Create time:2013-11-21
*/

if(!isset($_GET['year']) || empty($_GET['year']))
{
    echo 'Please input year!';exit;
}

header("Content-Type:application/vnd.ms-excel");
//excel 文件名
header("Content-Disposition:attachment;filename=".$month."月份以旧换新合同信息.xls");	
header("Content-type: text/html; charset=utf-8");
//输出内容如下：
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />    
		<title>以旧换新合同数据</title>
		<style>
			td{text-align:center;font-size:12px;font-family:Arial, Helvetica, sans-serif;border:#1C7A80 1px solid;color:#152122;width:100px;}
			table,tr{border-style:none;}
			.title{background:#7DDCF0;color:#FFFFFF;font-weight:bold;}
		</style>
		</head>
		<body>
				<table width='1200'>
					<tr>
						<td>序号</td>
						<td>展位号--公司名称</td>
						<td>".$_GET['year']."未使用的合同数量</td>
					</tr>  
		"; 
$mysql_url_233 = 'localhost';
$mysql_user_233 = 'common111';
$mysql_password_233 = 'common123';
$con_233 = mysql_connect($mysql_url_233,$mysql_user_233,$mysql_password_233) or die('数据库连接失败');
mysql_select_db('db_ljlj', $con_233);
mysql_query('set names latin1');
if('all'==$_GET['year'])
{
    $where = '';
}else
{
    $where = " WHERE contract_date>='".$_GET['year']."-01-01' AND contract_date<= '".$_GET['year']."-12-31'";
}
//$excel_log_sql = "SELECT contract_id,merchant_name,merchant_property,merchant_id FROM merchant_contract WHERE contract_date >='2013-01-01' and contract_date <= '2013-12-31'";
$excel_log_sql = "SELECT contract_id,merchant_name,merchant_property,merchant_id FROM merchant_contract ".$where; 
//echo $excel_log_sql;
$excel_log_res = mysql_query($excel_log_sql);
$merchant=array();
$merchantNum = array();
while($excel_log = mysql_fetch_assoc($excel_log_res))
{
    if(!empty($merchant[$excel_log['merchant_property'].'--'.$excel_log['merchant_name']]))
    {
        $merchant[$excel_log['merchant_property'].'--'.$excel_log['merchant_name']] = $merchant[$excel_log['merchant_property'].'--'.$excel_log['merchant_name']].','.$excel_log['contract_id']; 
    }else
    {
        $merchant[$excel_log['merchant_property'].'--'.$excel_log['merchant_name']] = $excel_log['contract_id'];
    }
	
}
//print_r($merchant);
$merchants = array();
foreach($merchant as $key=>$val)
{
    if(!empty($val))
    {
        $sqlA = "SELECT count(*) as sum FROM merchant_pact_list WHERE contract_id IN ($val) AND contract_id!='' AND state=0 AND ljyun_id=0"; 
        $resA = mysql_fetch_assoc(mysql_query($sqlA));
        if($resA['sum']!=0) $merchants[$key] = $resA['sum'];
    }
}
asort($merchants);
$i=1;
foreach($merchants as $k=>$v)
{
        echo ' <tr>
            <td>'.$i.'</td>
            <td>'.$k.'</td>
            <td>'.$v.'</td>
        </tr>  ';
        $i++;
}
/*
echo count($merchants);
echo '<pre>';
print_r($merchants);
echo '</pre>';
*/
echo ' </table></div></body></html> ';
