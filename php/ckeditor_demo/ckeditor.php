<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>CKEDITOR</title>
</head>
<body>
</body></html>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<textarea rows="30" cols="50" name="Content" id="myEditor"></textarea>
<input type="button" value="点击我添加到编辑器内容" id="select_btn">
<script type="text/javascript">
$(function(){
	//如果实例已存在
	if(CKEDITOR.instances['Content']){
		CKEDITOR.remove(CKEDITOR.instances['Content']);
	}
	CKEDITOR.replace('Content');//实例化
	$('#select_btn').click(function(){
		CKEDITOR.instances.myEditor.insertHtml('要添加到编辑器的内容是....');
	})
})
</script>
