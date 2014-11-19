<?php
/*
 * 常用函数文件
 *
 * @author:liangxifeng<liangxifeng833@163.com>
 * @date  : 2014-11-19
 */

/*
 * 生成指定长度的随机字符串(包含大写英文字母, 小写英文字母, 数字)
 * @demo  ：生成4位随机数的demo，randomStr(4); 结果：12RT
 *
 * @author: web
 * @date  : 2014-11-19
 * @param : [int] - $length - 需要生成的字符串的长度
 * @return: [string] - 指定长度包含大小写英文字母 和 数字 的随机字符串
 */
function randomStr($length)
{
    //生成一个包含 大写英文字母, 小写英文字母, 数字 的数组
    $arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    $str = '';
    $arr_len = count($arr);
    for ($i = 0; $i < $length; $i++)
    {
        $rand = mt_rand(0, $arr_len-1);
        $str.=$arr[$rand];
    }
    return $str;
}
