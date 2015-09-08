<?php
/**
 * 一个人有多张信用卡，获取这个人每月最佳还款日期是哪天
 *
 * 入参POST: array dayStr : 由账单日组成数组,如：array('2015-01-15','2015-01-02','2015-01-20')
 *           array dayEnd : 由还款日组成数组,如：array('2015-02-15','2015-01-22','2015-02-18')
 * sulong
 * 2015/1/18
 */

//获取传递进来的日期
$dayStr = $dayEnd = array();
$dayStr = array_filter($_POST['dayStr']);//账单日
$dayEnd = array_filter($_POST['dayEnd']);//还款日

//获取账单日最大值
$strMax = getStrMax($dayStr);
//获取还款日最小值
$strMin = getStrMin($dayEnd);

//返回结果
if($strMax > $strMin)
{
	echo '无法获取有效日期,请确定输入';
}
else if($strMax == $strMin)
{
	echo '最佳还款日期：'.date('Y-m-d', $strMax);
}
else//存在多个可一次还清还款时间
{
	echo '开始日期：'.date('Y-m-d', $strMax);
	echo '<br/>';
	echo '结束日期：'.date('Y-m-d', $strMin);
	echo '<br/>在这个日期范围内任意一天还款即可';
}

//传递时间数组获取最大值
function getStrMax($arr=array())
{
	$strMax = '';
	foreach($arr as $val)
	{
		if($strMax < strtotime($val)) $strMax = strtotime($val);
	}
	return $strMax;
}

//传递时间数组获取最小值
function getStrMin($arr=array())
{
	$strMin = '9421712000';
	foreach($arr as $val)
	{
		if($strMin > strtotime($val)) $strMin = strtotime($val);
	}
	return $strMin;
}
?>