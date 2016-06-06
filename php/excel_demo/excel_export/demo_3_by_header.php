<?php 
/*
* demo : 导出excel 几种常见格式处理
* 1）  文本：vnd.ms-excel.numberformat:@
* 2）  日期：vnd.ms-excel.numberformat:yyyy/mm/dd
* 3）  数字：vnd.ms-excel.numberformat:#,##0.00
* 4）  货币：vnd.ms-excel.numberformat:￥#,##0.00
* 5）  百分比：vnd.ms-excel.numberformat: #0.00%
*
* @author:zlp
* @date:2016-05-08
*/
//模拟数据
$data[0] = array('id'=>1,'string'=>'1234567890123456781','date'=>'2016-05-06','number'=>312312,'money'=>'199.80','percent'=>0.33);
$data[1] = array('id'=>2,'string'=>'1234567890123456782','date'=>'2016-05-06','number'=>312312,'money'=>'199.80','percent'=>0.44);
$data[2] = array('id'=>3,'string'=>'1234567890123456783','date'=>'2016-05-06','number'=>312312,'money'=>'199.80','percent'=>0.55);
$data[3] = array('id'=>4,'string'=>'1234567890123456784','date'=>'2016-05-06','number'=>312312,'money'=>'199.80','percent'=>0.66);
$data[4] = array('id'=>5,'string'=>'1234567890123456785','date'=>'2016-05-06','number'=>312312,'money'=>'199.80','percent'=>0.77);
//开始导出
header("Content-Type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=".iconv("utf-8",   "GB2312",  'excel_测试').".xls");
            header("Content-type: text/html; charset=utf-8");
            echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html xmlns='http://www.w3.org/1999/xhtml'>
        <head>
        <meta http-equiv='Content-Type' content='text/html;  charset=UTF-8' />    
            <style>
            td{text-align:left;margin:10px;font-size:14px;font-family:Arial, Helvetica, sans-serif;border:#1C7A80 1px solid;color:#152122;}
            table,tr{border-style:none;}
            .title{background:#7DDCF0;color:#FFFFFF;font-weight:bold;}
            </style>
        </head>
        <title>".'数字测试'."</title>
        <body>
        <div class='ticket_viewList'>
        <form class='viewList'>
        <table class='list' cellpadding='0' cellspacing='0' width='100%'>
            <thead>
                <tr>
                <td  colspan='8'>".'几种常见excel格式处理,第一行是未作处理的数据'."</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                        <td width='5%'>序号</td>
                        <td width='20%'>文本</td>
                        <td width='15%''>日期</td>
                        <td width='15%'>做完处理的数字</td>
                        <td width='15%'>未做处理的数字</td>
                        <td width='15%'>货币</td>
                        <td width='15%'>百分比</td>
                </tr>";
                  echo "<tr>
                    <td>".$data[0]['id']." </td>
                    <td>".$data[0]['string']." </td>
                    <td>".$data[0]['date']." </td>
                    <td>".$data[0]['number']." </td>
                    <td>".$data[0]['number']." </td>
                    <td>".$data[0]['money']." </td>
                    <td>".$data[0]['percent']." </td>
                    </tr>";
                    foreach ($data as $k => $v)
                    {
                   echo "<tr>
                              <td >".$v['id']." </td>
                              <td style='vnd.ms-excel.numberformat:@'>".$v['string']." </td>
                              <td style='vnd.ms-excel.numberformat:yyyy-mm-dd  &nbsp;HH\:mm\:ss' >".$v['date']."</td>
                              <td style='vnd.ms-excel.numberformat:#,##0.00'>".$v['number']." </td>
                              <td style='vnd.ms-excel.numberformat:###0'>".$v['number']." </td>
                              <td style='vnd.ms-excel.numberformat:￥#,##0.00'>".$v['money']." </td>
                              <td style='vnd.ms-excel.numberformat: #0.00%'>".$v['percent']." </td>
                              </tr>";
                    };
                    echo "</tbody></table></body></html>";exit;
 ?>