// JavaScript Document

$(function(){
	/*nav*/
	$(".ljljHeaderNavClassify > a:not(:first)").click(function(){
		$(this).addClass("curState").siblings().removeClass("curState");
	})
})


/*left nav logo*/
var sum=23;
function showBg(id)
{
	var url_bath = $('#url_bath').val();
	var bg=document.getElementById("logo"+id);
	for(var i=1;i<=sum;i++){
		if(i==id){
			bg.style.background="url("+url_bath+"/static/images/home_page/left_nav_06.png) no-repeat";
		}
	}
}
function leaveBg(id)
{
	var url_bath = $('#url_bath').val();
	var bg=document.getElementById("logo"+id);
	for(var i=1;i<=sum;i++){
		if(1<=id && id<=5){
			bg.style.background="url("+url_bath+"/static/images/home_page/left_nav_03.png)";
		}else if(6<=id && id<=9){
			bg.style.background="none";
		}else if(10<=id && id<=14){
			bg.style.background="url("+url_bath+"/static/images/home_page/left_nav_03.png)";
		}else if(15<=id && id<=18){
			bg.style.background="none";
		}else if(19<=id && id<=23){
			bg.style.background="url("+url_bath+"/static/images/home_page/left_nav_03.png)";
		}
	}
}
/*left nav*/

function showNav(id){
	
	var nav=document.getElementById("nav"+id);
	var hide=document.getElementById("hide"+id);
	nav.style.borderLeft="#990066 solid 3px";
	$(hide).show();
}

function hideNav(id){

	var nav=document.getElementById("nav"+id);
	if(id%2!=0){
		nav.style.borderLeft="#fff solid 3px";
	}else
	{
		nav.style.borderLeft="#EBEBEB solid 3px";
	}
	$('#hide'+id).hide();
}
/*吸顶*/
$(window).scroll(function(){
	var top=$(document).scrollTop();
	if(top >=150){
		$(".ContentBannerContentLeft").addClass("autoTop");
	}else{
		$(".ContentBannerContentLeft").removeClass("autoTop")
	}
	
})
/*名品家具处的幻灯片*/
var show1=document.getElementById("showSmallImg");
var point=$(show1).find("ul:last").find("li").length;
function showSmall(id){
	var url_bath = $('#url_bath').val();
	for(i=0;i<point;i++){
		if(i==id){
			$(show1).find("ul:first").find("li").eq(i).show();
			$(show1).find("ul:last").find("li").eq(i).css("background","url("+url_bath+"/static/images/home_page/shop_index_67.png)");
		}else{

			$(show1).find("ul:first").find("li").eq(i).hide();
			$(show1).find("ul:last").find("li").eq(i).css("background","url("+url_bath+"/static/images/home_page/shop_index_65.png)");
		}
	}
}
var id1=0;
function smallDiv(){
	showSmall(id1);
	id1++;
	if(id1==point){
			id1=0;
	}
}
smallDiv();
$(function(){
var speedTime=6000;
var hour=setInterval(smallDiv,speedTime);
$("#showSmallImg").mouseenter(function(){clearInterval(hour);});
$("#showSmallImg").mouseleave(function(){hour=setInterval(smallDiv,speedTime);});
})

/*环保建材处的幻灯片*/
var show2=document.getElementById("showSmallImg2");
var point2=$(show2).find("ul:last").find("li").length;
function showSmall2(id){
	var url_bath1 = $('#url_bath').val();
	for(i=0;i<point2;i++){
		if(i==id){
			$(show2).find("ul:first").find("li").eq(i).show();
			$(show2).find("ul:last").find("li").eq(i).css("background","url("+url_bath1+"/static/images/home_page/shop_index_67.png)");
		}else{
			$(show2).find("ul:first").find("li").eq(i).hide();
			$(show2).find("ul:last").find("li").eq(i).css("background","url("+url_bath1+"/static/images/home_page/shop_index_65.png)");
		}
	}
}
var id2=0;
function smallDiv2(){
	showSmall2(id2);
	id2++;
	if(id2==point2){
		id2=0;
	}
}
smallDiv2();
$(function(){
var speedTime1=6000;
var hour2=setInterval(smallDiv2,speedTime1);
$("#showSmallImg2").mouseenter(function(){clearInterval(hour2);});
$("#showSmallImg2").mouseleave(function(){hour2=setInterval(smallDiv2,speedTime1);});
})
/*家装饰品处的幻灯片*/
var show3=document.getElementById("showSmallImg3");
var speedTime2=6000;
var point3=$(show3).find("ul:last").find("li").length;
function showSmall3(id){
	var url_bath2 = $('#url_bath').val();
	for(i=0;i<point3;i++){
		if(i==id){
			$(show3).find("ul:first").find("li").eq(i).show();
			$(show3).find("ul:last").find("li").eq(i).css("background","url("+url_bath2+"/static/images/home_page/shop_index_67.png)");
		}else{
			$(show3).find("ul:first").find("li").eq(i).hide();
			$(show3).find("ul:last").find("li").eq(i).css("background","url("+url_bath2+"/static/images/home_page/shop_index_65.png)");
		}
	}
}
var id3=0;
function smallDiv3(){
	showSmall3(id3);
	id3++;
	if(id3==point3){
		id3=0;
	}
}
smallDiv3();
$(function(){
var speedTime1=6000;
var hour3=setInterval(smallDiv3,speedTime2);
$("#showSmallImg3").mouseenter(function(){clearInterval(hour3);});
$("#showSmallImg3").mouseleave(function(){hour3=setInterval(smallDiv3,speedTime2);});
})

/*生活家电处的幻灯片*/
var show4=document.getElementById("showSmallImg4");

var point4=$(show4).find("ul:last").find("li").length;
function showSmall4(id){
	var url_bath3 = $('#url_bath').val();
	for(i=0;i<point4;i++){
		if(i==id){
			$(show4).find("ul:first").find("li").eq(i).show();
			$(show4).find("ul:last").find("li").eq(i).css("background","url("+url_bath3+"/static/images/home_page/shop_index_67.png)");
		}else{
			$(show4).find("ul:first").find("li").eq(i).hide();
			$(show4).find("ul:last").find("li").eq(i).css("background","url("+url_bath3+"/static/images/home_page/shop_index_65.png)");
		}
	}
}
var id4=0;
function smallDiv4(){
	showSmall4(id4);
	id4++;
	if(id4==point4){
		id4=0;
	}
}
smallDiv4();
$(function(){
var speedTime3=6000;
var hour4=setInterval(smallDiv4,speedTime3);
$("#showSmallImg4").mouseenter(function(){clearInterval(hour4);});
$("#showSmallImg4").mouseleave(function(){hour4=setInterval(smallDiv4,speedTime3);});
})

/*家居用品处的幻灯片*/
var show5=document.getElementById("showSmallImg5");

var point5=$(show5).find("ul:last").find("li").length;
function showSmall5(id){
	var url_bath3 = $('#url_bath').val();
	for(i=0;i<point5;i++){
		if(i==id){
			$(show5).find("ul:first").find("li").eq(i).show();
			$(show5).find("ul:last").find("li").eq(i).css("background","url("+url_bath3+"/static/images/home_page/shop_index_67.png)");
		}else{
			$(show5).find("ul:first").find("li").eq(i).hide();
			$(show5).find("ul:last").find("li").eq(i).css("background","url("+url_bath3+"/static/images/home_page/shop_index_65.png)");
		}
	}
}
var id5=0;
function smallDiv5(){
	showSmall5(id5);
	id5++;
	if(id5==point5){
		id5=0;
	}
}
smallDiv5();
$(function(){
var speedTime4=6000;
var hour5=setInterval(smallDiv5,speedTime4);
$("#showSmallImg5").mouseenter(function(){clearInterval(hour5);});
$("#showSmallImg5").mouseleave(function(){hour5=setInterval(smallDiv5,speedTime4);});
})

function left_slid(adv_slid, pro_slid)
{
	$('#'+pro_slid).stop(true,true).show();
	$('#'+pro_slid).stop(true,true).animate({left:'-1000px'},'slow');
	$("#"+adv_slid).stop(true,true).animate({right:'1000px'},"slow");
}
function right_slid(adv_slid, pro_slid)
{
	$("#"+adv_slid).stop(true,true).animate({right:'0px'},"slow");
	$('#'+pro_slid).stop(true,true).animate({left:'0px'} ,'slow').fadeOut('slow');
}

