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
