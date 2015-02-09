##Load lazy 图片延时加载插件原理是：
修改目标 img 的 src 属性为 orginal 属性，从而中断图片的加载。检测滚动状态，然后把可视网页中的 img 的 src 属性还原加载图片，制造缓冲加载的效果。
一个在线编辑markdown文档的编辑器

##Load lazy 使用：

###第一步：加载插件／加载jquery
    
    <script src='/js/jquery-1.11.0.min.js'></script>
    <script src='/js/jquery.lazyload.js'></script>
###第二步：定义图片标签结构
修改 HTML 的结构，在 img 标签中添加新的属性，把 src 属性的值指向占位图片，添加 data-original 属性，让其指向真正的图像地址。
```php
<img src="/js/loading.gif" original='/picture/1.jpg' width='1020' height='400'/>
```
注意： 特殊图片不需按照lazyload.js官方格式。
###第三步：触发
```php
jQuery(document).ready(
    function($){
	$("img:not(.noLazy)").lazyload({
		 placeholder : "/js/loading.gif",/*预加载图片*/
		 effect      : "fadeIn"/*自定义效果*/
	});
})
```
