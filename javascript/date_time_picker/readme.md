### 时间控件说明

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
