/*jquery实现隔行换色
 *   *author:hanshaobo
 *   *date:2013.12.05
 *   *入参:
 *   *integer:是奇数偶数,奇数:odd;偶数:even
 *   *tableId:隔行换色所在的table的id
 *   *trClass:隔行换色所在的table下tr的class名
 *   */
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

