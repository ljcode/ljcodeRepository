<?php
/**
 *
 * 获取最佳天数
 *
 *  @param  Array  : 需要判断的二维数组
 *  @return String : 提示文字
 *  @author yyg
 * 
 */
class getDay
{
   /**
    * 获取日期中间值
    * 
    * @param  $array Array    入参为分组后二维数组格式的具体日期 如: 
    *         array('date1'=>array('start_date'=>'2000-01-01','end_date;=>'2000-01-31'),'date2'=>array(...))
    * 
    * @return String or Array 返回具体时期提示文字 或者 返回具体日期数组（可选）
    *  
    */  
  	function doGetDay($array)
    {
        // 用于储存用来执行的参数字符串
      	$param = '';
        // 提示文字
        $days  = '最佳还款日期为:'.'<br/>';
      	// 声明变量用于记录 日期数组名称
        $num   = 0;
      	foreach ($array as $value) 
        {
          // 拼接数组名称
      		$time  ='time_'.$num;
          // 循环储存 每一组日期对应的具体天数
      		$$time = $this->_prDates($value[0],$value[1]);
          // 拼接参数字符串
      		$param .= '$'.$time.',';
      		$num++;
      	}
        // 去掉末尾的逗号
      	$param = rtrim($param,',');
        // 拼接用于执行的代码
      	$param = '$over=array_intersect('.$param.');';
        // 执行交集函数代码 产生结果数组为 $over
      	eval($param);
        // 循环拼接提示文字
        foreach($over as $day)
        {
          $days .= $day.'<br/>';
        }
        // 返回具体日期 
      	return $days; 
        // 返回具体日期数组 (可选)
        // return $over
  	}
   /**
    * 获取具体日期
    * 
    * @param $start : 开始时期
    *        $end   : 结束日期
    */
  	function _prDates($start, $end) 
    { 
      // 开始日期
      $dt_start = strtotime($start); 
      // 结束日期
      $dt_end   = strtotime($end); 
      // 将日期存入数组
      do 
      { 
        $arr[] = date('Y-m-d', $dt_start);
      } while(($dt_start += 86400) <= $dt_end);
      // 返回结果
      return $arr;
  	}
}
