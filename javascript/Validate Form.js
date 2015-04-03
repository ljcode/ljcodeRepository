/*
 * js公共函数 表单验证非空
 * 注意：在使用本文件中函数的时候需要在加载本文件之前先加载jquery库文件
 *
 * @author:nongfeidan
 * @date:2015-04-03
 */
// JavaScript Document

//把需要验证的input加上一个class，通过class获取需要验证的input，如下：
var aVerifi = $('.verification input');//获取所有的验证对象
var aPrompt = $('.verification span');//获取所有的提示信息对象

//获取焦点触发的事件，提示信息消失
aVerifi.each(function ( index ){
	$(this).focus(function (){
		aPrompt.eq(index).html('');
	})
	
})
//光标离开触发的事件，如为空提示信息
aVerifi.each(function ( index ){
	$(this).blur(function (){
		if(aVerifi.eq(index).val() == '')
		aPrompt.eq(index).html('请填写信息');
		aPrompt.eq(index).css('color','red');
	})
	
})

//表单提交事件，调用非空函数
$('#form').submit(function(){	
	return checkSubmit( aVerifi,aPrompt ); // 第一个参数是判断非空的对象 ，第二个是提示信息
})
//验证非空函数
function checkSubmit( obj1, obj2 ){
	var arr =[];		
	obj1.each(function ( index ){
		if(obj1.eq(index).val()==''){
			obj2.eq(index).html('请填写信息');
			obj2.eq(index).css('color','red');
		}
		if(obj1.eq(index).val() !==''){
			arr.push(1);
		}
		
	})
	if( arr.length !== obj1.length){
		return false;
	}	
}