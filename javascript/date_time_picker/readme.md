### 时间控件说明
####调用方式
将这些文件down下来放在同一目录下,然后执行index.html,并能看到效果.
####调用实例说明
1.首先写入input框:
```php
//对账开始时间input框,设置默认值(默认值可以通过php程序传递过来)
<input class="Wdate" type="text"  id="starttime" name="starttime" value="2014-12-12"/>
```
2.触发js事件
```php
/*
*单击对账开始文本框弹出时间控件
*起始时间:自定(可从文本框中获取)
*终止时间:当天
*/
$("#starttime").click(function(){
    var start = $('#starttime').val();
    var obj = {
        el:'starttime',      //所要显示日期的input框的id值
        isShowClear:false,   //是否显示清空按钮
        readOnly:true,       //输入框只读
        minDate:start,       //日期控件的最小日期
        maxDate:now,         //日期控件的最大日期
        dateFmt: 'yyyy-MM-dd'  //默认设置,日期控件的显示格式,如2013-04-04
        };
    WdatePicker(obj);          //调用控件
});
```
3.经过js事件后,input框的value值被改变
####注意事项：
1.My97DatePicker目录是一个整体,不可破坏里面的目录结构,也不可对里面的文件改名,可以改目录名

2.My97DatePicker.htm是必须文件,不可删除

3.各目录及文件的用途:

4.WdatePicker.js 配置文件,在调用的地方仅需使用该文件,可多个共存,以xx_WdatePicker.js方式命名

5.config.js 语言和皮肤配置文件,无需引入

6.calendar.js 日期库主文件,无需引入

7.My97DatePicker.htm 临时页面文件,不可删除

8.目录lang 存放语言文件,你可以根据需要清理或添加语言文件

9.目录skin 存放皮肤的相关文件,你可以根据需要清理或添加皮肤文件包

10.当WdatePicker.js里的属性:$wdate=true时,在input里加上class="Wdate"就会在选择框右边出现日期图标,如果您不喜欢这个样式,可以把class="Wdate"去掉,另外也可以通过修改skin目录下的WdatePicker.css文件来修改样式
