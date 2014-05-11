<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 上传文件函数
 *
 * @author : Liangxifeng
 * @date : 2014-05-10
 */

/*
 * 上传图片, 用于生成散列目录
 * 
 * @author: Liangxifeng
 * @date  : 2014-05-10
 * @param : $upimg       - string，文件空间的name
 *          $dirName     - string, 散列目录，如：/home/image/ljlj/diary/zhangsan
 *          $imgName     - string, 图片名称
 *          $width       - int,    图片处理后的宽度单位（px），默认1000px,原图如果大于该值以该值作为宽度处理图片，否则按着原图尺寸上传。 
 *          $height      - int,    图片处理后的高度
 *          $masterDim   - string, 缩略图以该值为基准，来做自动缩放比例，默认以width为基准进行缩略 
 *          $isThumb     - int,    是否生成缩略图 1:生成，0：不生成，默认:1   
 *          $thumbWidth  - int,    缩略图宽度
 *          $thumbheight - int,    缩略图高度
 * @return : mix int/array
 *          error:
 *          1:参数错误 
 *          -1:第一次上传失败，
 *          -2：如果原来图片宽度>1000,則以宽度为1000来处理失败，
 *          -3：生成缩略图失败
 *          success:上传后的图片信息 array
 */
function uploadImg($upimg,$dirName,$imgName,$width=1000,$height=1000,$masterDim='width',$isThumb=1,$thumbWidth=520,$thumbHeight=335)
{
    //未上传图片
    if( empty($_FILES[$upimg]['name']) || empty($dirName) || empty($imgName)) return 1;
    //重命名图片
    $config['file_name'] = $imgName;
    $config['upload_path'] = $dirName;
    //生成散列目录
    if( !file_exists($config['upload_path']) ) mkdir($config['upload_path']);
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size']    = '93600'; //93.6M
    $config['max_width']   = '4000';
    $config['max_height']  = '4000';
    $CI =& get_instance();
    //载入文件上传类，加入配置
    $CI->load->library('upload', $config);
    $upRes = $CI->upload->do_upload($upimg);
    //上传失败
    if ( true!=$upRes ) return -1;
    unset($config);

    $uploadData = $CI->upload->data();
    $CI->load->library('image_lib');
    //获取上传后图片属性
    $getImgInfo = getimagesize($uploadData['full_path']);
    //如果原来图片宽度>1000,則以宽度为1000来处理
    if($width<$getImgInfo[0])
    {
        $config['source_image'] = $uploadData['full_path'];
        $config['width'] = $width;
        $config['height'] = $height;
        $config['master_dim'] = $masterDim;
        $config['maintain_ratio'] = TRUE;
        $config['new_image'] = $uploadData['orig_name'];
        $config['quality'] = 90;
        $CI->image_lib->initialize($config);
        if(!$CI->image_lib->resize()) return -2;
        unset($config);
    }
    unset($getImgInfo);
    //生成缩略图
    if(1==$isThumb)
    {
        $getImgInfo = getimagesize($uploadData['full_path']);
        if($thumbWidth<$getImgInfo[0])
        {
            $config['source_image'] = $uploadData['full_path'];
            $config['width'] = $thumbWidth;
            $config['height'] = $thumbHeight;
            $config['master_dim'] = $masterDim;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = 90;
            $newImg = $uploadData['raw_name'].'_thumb'.$uploadData['file_ext'];
            $config['new_image'] = $newImg;
            $CI->image_lib->initialize($config);
            //缩略图生成失败
            if (!$CI->image_lib->resize()) return -3;
            unset($config);
        }
        //否则复制原图片
        else
        {
           copy($uploadData['full_path'],$uploadData['file_path'].$uploadData['raw_name'].'_thumb'.$uploadData['file_ext']);
        }
    }
    //$CI->image_lib->clear();
    return $uploadData;
}

