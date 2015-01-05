/*
 * js公共函数
 * 注意：在使用本文件中函数的时候需要在加载本文件之前先加载jquery库文件
 *
 * @author:Liangxifeng
 * @date:2014-02-03
 */

/*
* 表单中默认值的处理
*
* @author -- Liangxifeng
* @date   -- 2014-02-03
* @param  -- sureValue:input框中必填值,比如：必填
*            optionValue:input框中选添值,比如：选填
*            inputClass:input输入正确内容的class值,比如：xnInputColor
* @return -- none
* @example -- defaultValue('必填','选填','xnInoputColor')
*/
function defaultValue(sureValue,optionValue,inputClass)
{
    var flag = 1;
    $(":text,textarea").bind({
        focus:function(){
            if($(this).val() == sureValue || $(this).val() == optionValue) 
            {
                flag = $(this).val() == optionValue ? 0 : 1;
                $(this).val('').removeClass(inputClass);
            }
        },  
        blur:function(){
            var  value = 0==flag ? optionValue : sureValue;
            if($(this).val() == '') $(this).val(value).addClass(inputClass);
        }
    });
}

/*jquery实现隔行换色
 *
 * @author -- hanshaobo
 * @date -- 2013.12.05
 * #param -- integer:是奇数偶数,奇数:odd;偶数:even
 *           tableId:隔行换色所在的table的id
 *           trClass:隔行换色所在的table下tr的class名
*/
function getColor(integer,tableId,trClass){
	//奇数行换色
	if(integer=='odd'){
		//判断奇数行是否有class,如果没有添加class
		var len = $("#"+tableId+" tr:odd").hasClass(trClass);
        if(len == false){
	        $("#"+tableId+" tr:odd").addClass(trClass);
	    }else{
	        return false;
		}
		//偶数行换色
	}else if(integer='even'){
		//判断偶数行是否有class,如果没有添加class
	    var len = $("#"+tableId+" tr:even").hasClass('class');
	    if(len == false){
	    	$("#"+tableId+" tr:even").attr('class',trClass);
			$("#"+tableId+" tr:first").attr('class','');
	    }else{
	        return false;
	    }
	}
	     
}

/*JS实现验证金额格式，最大：七位整数，两位小数，小数点不算位数；整数前不可加0，如：002.22,是不行的
 *
 * @author -- 张欢
 * @date -- 2014.6.18
 *
 * #param -- inputId:针对input框的ID
*/
function regPrice(inputId)
{	//判断是否有值，无值的话，返回False
	var price = document.getElementById(inputId).value; 
	if(price > 0)
	{	//判断金额格式
		teseprice = /^(0|[1-9][0-9]{0,6})(\.[0-9]{1,2})?$/;
		return teseprice.test(price);
	}
	return false;   
}

/*javascript实现验证字符长度
 *
 * @author -- zhanghuan
 * @date -- 2014.6.18
 * #param -- inputId:针对input框的ID
 *           number:字符个数
*/
function stringLength(inputId,number)
{
	var inputValue = document.getElementById(inputId).value; 
	var returnValue = inputValue.length > number ? false : true;
	return returnValue;
}

/*javascript实现列表页跳页功能
 *
 * @author -- zhanghuan
 * @data -- 2014.07.08
 * @param -- jumpid: jumpid针对跳页input框 
 * @param -- urlone: 组成跳转链接的第一部分,例如:index.php/data/ceshi/index/goodsname=&goodsstatus=
 * @param -- totalpage: 获取分页的总页数 例如：totalpage为25页
 * @param -- per_page:
 */
function jumpGo(jumpId,urlone,totalpage,per_page)
{
	var jumpval = parseInt($('#'+jumpId+'').val());
	reg = /^\d+$/;
	//获取总页数
	var totalpage = parseInt(totalpage);
	//当输入页码格式正确，输入页码大于0同时满足 输入页码小于最大页码
	if(reg.test(jumpval) && jumpval > 0 )
	{
		var offerset = 0;
		if(jumpval <= totalpage)
		{
		     offerset = (jumpval-1)*10;
		}
		else
		{
		     offerset = (totalpage-1)*10;
		}
		window.location.href=""+urlone+"&"+per_page+"="+offerset+"&go="+jumpval;
	}
}