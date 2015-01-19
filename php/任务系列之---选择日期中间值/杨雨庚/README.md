###获取若干组数据的起始结束日期的交集部分###

######待完善:判断参数是否为数组 元素是否为空#######



// 声明测试数组<br/>
$arr['credit_1'][] = '2015/01/15';<br/>
$arr['credit_1'][] = '2015/02/15';<br/>


$arr['credit_2'][] = '2015/01/02';<br/>
$arr['credit_2'][] = '2015/01/22';<br/>

$arr['credit_3'][] = '2015/01/20';<br/>
$arr['credit_3'][] = '2015/02/18';<br/>


/* 打印结果如下<br/>
array(4) {<br/>
&nbsp;&nbsp;["credit_1"]=><br/>
&nbsp;&nbsp;array(2) {<br/>
&nbsp;&nbsp;&nbsp;[0]=><br/>
&nbsp;&nbsp;&nbsp;string(10) "2015/01/15"<br/>
&nbsp;&nbsp;[1]=><br/>
&nbsp;&nbsp;&nbsp;string(10) "2015/02/15"<br/>
&nbsp;&nbsp;}<br/>
&nbsp;&nbsp;["credit_2"]=><br/>
&nbsp;&nbsp;array(2) {<br/>
&nbsp;&nbsp;&nbsp;[0]=> <br/>
&nbsp;&nbsp;&nbsp;string(10) "2015/01/02"<br/>
&nbsp;&nbsp;[1]=><br/>
&nbsp;&nbsp;&nbsp;string(9) "2015/01/22"<br/>
&nbsp;&nbsp;}<br/>
&nbsp;&nbsp;["credit_3"]=><br/>
&nbsp;&nbsp;&nbsp;array(2) {<br/>
&nbsp;&nbsp;&nbsp;[0]=><br/>
&nbsp;&nbsp;&nbsp;string(10) "2015/01/20"<br/>
&nbsp;&nbsp;[1]=><br/>
&nbsp;&nbsp;&nbsp;string(10) "2015/02/18"<br/>
&nbsp;&nbsp;}<br/>
}<br/>
*/

<b>调用 getDay 类</b>

$l = new getDay;<br/>
echo $l->doGetDay($arr);<br/>

-------------------------------------------------------------------------
<b>显示结果如下</b>


最佳还款日期为:<br/>
2015-01-20<br/>
2015-01-21<br/>
2015-01-22<br/>