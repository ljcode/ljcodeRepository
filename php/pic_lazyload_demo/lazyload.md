#图片延时加载插件demo
##Load lazy 图片延时加载插件原理是：
修改目标img标签的src属性(占位图片)变为orginal属性(真实图片地址)，从而中断图片的加载。检测滚动状态，然后把可视网页中的img的 src 属性还原加载图片，制造缓冲加载的效果。通俗说就是img标签src(占位)，orginal(真实)，页面初始化时先加载src的占位图，根据右侧纵向导航条的滚动状态，智能化的将orginal地址还原给src。

##Load lazy 使用：
####注意：如使用此效果请严格按照以下范例，否则结果不可预知。
###第一步：加载插件／加载jquery
    
    <script src='/js/jquery-1.11.0.min.js'></script>
    <script src='/js/jquery.lazyload.js'></script>
###第二步：定义图片标签结构
修改 HTML 的结构，在 img 标签中添加新的属性，把 src 属性的值指向占位图片，添加 original 属性，让其指向真正的图像地址。例如：本例
```php
<img src="/js/loading.gif" original='/picture/1.jpg' width='1020' height='400'/>
```
####注意： !特殊图片不需按照lazyload.js官方格式。例如：
```php
<img class='noLazy' src='/picture/mao.jpg' width='70' height='60'/> 
```
###第三步：触发
```php
jQuery(document).ready(
    function($){
	$("img:not(.noLazy)").lazyload({
		 placeholder : "/js/loading.gif",/*预加载图片路径*/
		 effect      : "fadeIn",/*自定义效果,图片淡出*/
		 //threshold   : 200,   /*把阀值设置成200 意思就是当图片没有看到之前先load 200像素*/
		 //event : "click",       /*单击img标签触发加载图片*/ 
		 //container:$('#container')/*container,值为某容器*/
	});
})
```
#注意事项：
1.若想提前载入图片,则可使用threshold;threshold默认值为0(最优值);若想通过事件触发加载图片,可对event 进行设置。若两者同时设定则默认出现为预加载(占位)图片，点击对应图片才可实现加载。
          
2.默认图片实现效果,下载完成之后,直接显示出来。用户体验并不好,可设置effect属性,来控制显示图片的效果;例如
effect:'fadeIn'.effect(特效),值有show(直接显示),fadeIn(淡入),slideDown(下拉)等,常用fadeI.
3.需要延时加载的img标签中src属性的值，必须与placeholder参数的值一样，否则会导致延时加载异常，当前屏不能得到真实图片路径，只显示占位图片；
5.lazyload与ajax冲突, 因此在使用了comment-ajax的页面, lazyload是失效的, 建议择其一而使用.
6.如果使用智能手机的话，经常去应用网站下载应用，他们通常使用一个横着的容器，放一些手机截图。使用 container 属性，能很轻松在容器中实现缓冲加载。首先，我们需要用css定义这个容器，然后用这个插件进行加载。
```
#container { height: 600px; overflow: scroll; }
```
container: $("#container")；container,值为某容器.lazyload默认在拉动浏览器滚动条时生效,这个参数可以让你在拉动某DIV的滚动条时依次加载其中的图片

