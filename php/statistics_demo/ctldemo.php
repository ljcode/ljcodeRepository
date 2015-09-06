<?php
/**
 *2015投票统计柱图生成
 *
 *@author liuzhifeng
 *@date   2015-01-14
 */

$countData  = array();
$statisHtml = "";       //拼接列表字串
$totalCount = 284;      //总投票数 模拟从数库里取出的数据 0 表示没有/284 是二维数组$countData里num值的总和
if($totalCount == 0)    //没有投票记录时
{
    $optionsName = array("儿童功能床选购要点", "多样创意 懒人沙发", "记忆枕有何优点", "电源板安装注意事项");
    foreach($optionsName as $value)
    {
        $statisHtml .= "<li><span class='statistics-content-text'>" . $value . "</span>";
        $statisHtml .= "<span class='statistics-content-progress'><span style='width:0'></span></span><span></span>";
        $statisHtml .= "<span class='statistics-content-ticket'>0<small>票</small></span></li>"; 
    }
}
else     //取到投票数据时
{
    $countData  = array(                       //模拟从数库里取出的数据  num的总和等于上面$totalCount
        array("id" => 1, "num" => 75, "options" => "儿童功能床选购要点"),
        array("id" => 2, "num" => 69, "options" => "多样创意 懒人沙发"),
        array("id" => 3, "num" => 98, "options" => "记忆枕有何优点"),
        array("id" => 4, "num" => 42, "options" => "电源板安装注意事项")
    );
    $countData = array_sort($countData, "num");       //降序排列数组
    foreach ($countData as $value)       //拼接排序列表字串
    {
        $perent      = round(($value['num']/$totalCount)*100) . "%";        //计算该选项所占总投票数的百分比 四舍五入 不保留小数
        $statisHtml .= "<li><span class='statistics-content-text'>" . $value['options'] . "</span>";
        $statisHtml .= "<span class='statistics-content-progress'><span style='width:" . $perent . "'></span></span><span>" . $perent . "</span>";
        $statisHtml .= "<span class='statistics-content-ticket'>" .$value['num'] ."<small>票</small></span></li>"; 
    }
}

/**
 *二维数组按指定的键值排序 功能函数
 *@author :  liuzhifeng
 *@date   :  2015-01-12
 *$param  :    - array  ,$arr  要处理的数组名
 *        :    - mixed  ,$keys 指定的排序键值
 *        :    - string ,$type 排序方式 默认是降序
 *$return :    - array  ,$new_array 返回数组
 */
function array_sort($arr = array(), $keys = "", $type = 'desc') 
{
    $keysvalue = $new_array = array();
    foreach ($arr as $k => $v)      //取出二维数组中指定列的值 拼成一个数组 
    {
        $keysvalue[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($keysvalue);      //升序排列 上面拼成的数组
    } 
    else 
    {
        arsort($keysvalue);     //降序排列 上面接成的数组
    }
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

include("./viewdemo.html");

