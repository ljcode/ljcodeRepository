//添加上传域
function addimg()
{
	 //文件域
	var updiv ='<div class="upchoose_div"><div class="upchoose_choose"><input type="file" name="libimg[]"/></div><span class="ztdemo_shop_table choose_mar"><a href="#" name="rmlink">删除</a></span></div>';
	$('#ztdemo_omar').append(updiv);	
   bindListener();	
}
//删除上传域
function bindListener()
{
	$("a[name=rmlink]").unbind().click(function(){
		$(this).parent().parent().remove();
	})
}


function back_ifa()
{
	$("#mainFrame")[0].contentWindow.close_dialog();
}
function popup(html_div,div_name,url)
{	
		var strlg = url.length;
		var str = url.substring(strlg-1,strlg);
		if(str=='1')
		{
			var rid=$('#radio_img').val();
			url=url+'&id='+$('#radio_img').val();
		}
		//	document.getElementById(html_div).innerHTML="<div id='"+div_name+"' style='height=700px width='800px'><div class='data_tite'><p>选择资料库图片</p><a href='javascript:easyDialog.close();' title='关闭窗口' ><p class='data_titlean'><input type='image' src='/static/images/data_close.gif' /></p></a></div><div class='ztdemo_an data_an'><div class='save_button'><span><img src='/static/images/button_03.png' /></span><input type='button'  class='save_text' id='sub' onclick='ifa("+str+")' value='确定'><span><img src='/static/images/button_05.png' /></span></div><div class='back_button'><span><img src='/static/images/button_07.png' /></span><button type='button' class='back_text' id='back_text2' onclick='back_ifa()'>返回</button><span><img src='/static/images/button_09.png' /></span> </div></div> <iframe class='data_content' src='"+url+"' id='mainFrame' name='mainFrame' frameborder='0' width='800px' height='700px'/></div>";
	document.getElementById(html_div).innerHTML="<div class='dis' id ='"+div_name+"'><iframe src='"+url+"' id='mainFrame' name='mainFrame' frameborder='0' width='816px' height='448px' scrolling='no'/></div>";
	easyDialog.open({container : div_name});
	return false;

}



















