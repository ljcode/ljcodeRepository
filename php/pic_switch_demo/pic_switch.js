/*
 * @author: ningyachao
 * @date:2015-01-06
 */

/*
* 页面加载完成后自动调用
*
* @param  -- i                 :全局变量，用来控制循环
*            banner_num        :图片记录条数，从php文件中获取到可以放在类型为hidden的input框里
*            banner_change_time:间隔时间，根据需求自己设定 ，本demo里时间间隔4s
* @return -- none
*/
$(function(){
    i=0;
    banner_num = 3;                                     //总共记录条数  可以从类型为hidden的input框里获取到 
	var banner_change_time = '4000';					//间隔时间   自己设定
    if(banner_num>0){                                   //超过一条记录才轮转
		//使用定时器 没间隔3秒调用一次banner_change() 函数
    	banner_timeid = setInterval("banner_change()",banner_change_time);
		$('#show_div').mouseover(function(){			//鼠标移到图片或者点上停止轮转
			clearInterval(banner_timeid);           
		})
		$('#show_div').mouseout(function(){             //移开后轮转继续
			banner_timeid = setInterval("banner_change()",banner_change_time);
    	})
    }
});
	/*
	* 第一个ul中：显示选中的li 其他li隐藏
	* 第二个ul中：选中的li 加点，其他不加点
	*
	* @param  -- banner_content:定义获取到的图片li对象
	* 			 dotele        :定义获取到的图片左下角 点的li对象
	* @return -- none
	*/
    function banner_change()
    { 
        var banner_content = $('#ContentBannerContentImg li').eq(i);   		//定义banner_content对象
        banner_content.show();												//该对象显示
        banner_content.siblings().hide();                                   //隐藏同胞对象li
        var dotele = $('#show_div').find("ul:last").find("li");				//获取第二个ul里的li
        dotele.eq(i).css('background','url(images/banner_img_09.png)');	    //选中的li 加点，其他li不加点
        for(var j=0;j<=banner_num;j++){
            if(j != i){
                dotele.eq(j).css('background','url(images/banner_img_07.png)');
            }
        }
        i++;																//控制循环
        if(i == 3){
            i=0;
        }
    }
	/*
	* 当鼠标移上“原点”时 将全局变量i置成接受来的 num参数 并调用banner_change()函数
	*
	* @param  -- num:当前左下角点的位数。如：num = 2 ，代表左下角第二个点
	* @return -- none
	*/
    function fn_showdot(num){
        i=num;																//重置全局变量i
        banner_change();
    }
    /*
	* 先模糊再清晰函数
	*
	* @param  -- name:加载完成后原图的路径
	*            id  ：对应属性id为该值的li
	* @return -- none
	*/
	function banner_img_change(name,id){
		var img = new Image();                                    		//建立对象 注意onload一定要写在对象的后面  
		img.onload = function()                                         //img标签加载过程中调用函数
		{	
			document.getElementById(id).src = this.src;
		}
		img.src = name;                                                 //加载完成后更换路径
	}
