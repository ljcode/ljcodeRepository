## 瀑布流DEMO

`
注: 为方便快捷了解demo请参考index.html  data.php等具体演示文件
`

来源:网络搜索
**### Demo文件组成**
>**1.文件夹:**
>> (1).image : 存放示例图片
>> (2).js :    存放jQuery以及瀑布流js文件

>**2.文件:**
>>　(1).data.php : Ajax请求文件
>>　(2).index.html: demo演示页面

　　

**加载jQuery**
```
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
```

**加载瀑布流js文件**

```
<script type="text/javascript" src="js/jquery.windswaterflow.js"></script>
```

**在页面中设置相关参数(index.html)**

```
<script type="text/javascript">
$(document).ready(function() {
$(".container").windswaterflow({
            //图片div选择器 <div class="pin">
            itemSelector: '.pin',
            //显示'加载中' 选择器 <div id="loading">正在加载中……</div>
            loadSelector: '#loading',
           //无图片加载(图片末尾) 选择器 <div id="noshow">亲，已经没有了！</div>
            noSelector: '#noshow',
            //图片模板
            boxTemplate: '<div class="pin hide"><a href="{href}"><div class="img"><img src="{img}" alt="" /></div></a><div class="title">{title}</div><div class="like btn">喜欢</div><div class="comments btn">评论</div></div>',
            //图片div宽度
            columnWidth: 210,
            //图片x轴间距
            marginWidth: 14,
            //图片y轴间距
            marginHeight: 16,
            //ajax页面路径
            ajaxServer: './data.php',
            //图片数量参数 指定url所带参数 num值 对应 scrollBoxNumber:10 例				如:www.demo.com? num = 10 & page = 1 
            boxParam: 'num',
             //分页参数 指定url所带参数 page值对应 maxPage:0 例如:www.demo.com? 			num = 10 & page = 1
            pageParam: 'page',
            //设置最大加载页数 0:不限制
            maxPage:0,
            //是否显示html页面默认图片 true :显示加载图片 false :显示页面默认图片
            init: true,
            //默认加载图片数量
            initBoxNumber: 20,
            //是否开启瀑布流 
            scroll: true,
            //每次加载的图片数量
            scrollBoxNumber: 10,
            callback: function() {
                $(".pin").mouseover(function() {
                    $(this).find(".btn").show();
                }).mouseout(function() {
                    $(this).find('.btn').hide();
                });
            }
        });
});
</script>
```
            
**5.Data.php(用于向前台提供图片信息)**

可以通过:

```
// 接收 图片数量  与index.html 中boxParam: 'num',对应
$ num = $_GET["num"];
// 接收最大页数参数 与index.html 中maxPage:0,对应
$ page = $_GET["page"];
$ data = array();
// demo演示效果 预设最大页数为10页$page<11

	$ data[$i]["img"] = "images/P".$pNum.".jpg";
	$ data[$i]["title"] = "时间：".date("Y-m-d H:i:s")."<br />".( $i+1 )."、WindsWaterFlow(第".$page."页)";
	$ data[$i]["href"] = "http://www.baidu.com";

 
```

`设置将要向index.html传递的信息`
