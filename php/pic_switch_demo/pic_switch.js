/*
 * @author: ningyachao
 * @date:2015-01-06
 */

/*
* ҳ�������ɺ��Զ�����
*
* @param  -- i                 :ȫ�ֱ�������������ѭ��
*            banner_num        :ͼƬ��¼��������php�ļ��л�ȡ�����Է�������Ϊhidden��input����
*            banner_change_time:���ʱ�䣬���������Լ��趨 ����demo��ʱ����4s
* @return -- none
*/
$(function(){
    i=0;
    banner_num = 3;                                     //�ܹ���¼����  ���Դ�����Ϊhidden��input�����ȡ�� 
	var banner_change_time = '4000';					//���ʱ��   �Լ��趨
    if(banner_num>0){                                   //����һ����¼����ת
		//ʹ�ö�ʱ�� û���3�����һ��banner_change() ����
    	banner_timeid = setInterval("banner_change()",banner_change_time);
		$('#show_div').mouseover(function(){			//����Ƶ�ͼƬ���ߵ���ֹͣ��ת
			clearInterval(banner_timeid);           
		})
		$('#show_div').mouseout(function(){             //�ƿ�����ת����
			banner_timeid = setInterval("banner_change()",banner_change_time);
    	})
    }
});
	/*
	* ��һ��ul�У���ʾѡ�е�li ����li����
	* �ڶ���ul�У�ѡ�е�li �ӵ㣬�������ӵ�
	*
	* @param  -- banner_content:�����ȡ����ͼƬli����
	* 			 dotele        :�����ȡ����ͼƬ���½� ���li����
	* @return -- none
	*/
    function banner_change()
    { 
        var banner_content = $('#ContentBannerContentImg li').eq(i);   		//����banner_content����
        banner_content.show();												//�ö�����ʾ
        banner_content.siblings().hide();                                   //����ͬ������li
        var dotele = $('#show_div').find("ul:last").find("li");				//��ȡ�ڶ���ul���li
        dotele.eq(i).css('background','url(images/banner_img_09.png)');	    //ѡ�е�li �ӵ㣬����li���ӵ�
        for(var j=0;j<=banner_num;j++){
            if(j != i){
                dotele.eq(j).css('background','url(images/banner_img_07.png)');
            }
        }
        i++;																//����ѭ��
        if(i == 3){
            i=0;
        }
    }
	/*
	* ��������ϡ�ԭ�㡱ʱ ��ȫ�ֱ���i�óɽ������� num���� ������banner_change()����
	*
	* @param  -- num:��ǰ���½ǵ��λ�����磺num = 2 ���������½ǵڶ�����
	* @return -- none
	*/
    function fn_showdot(num){
        i=num;																//����ȫ�ֱ���i
        banner_change();
    }
    /*
	* ��ģ������������
	*
	* @param  -- name:������ɺ�ԭͼ��·��
	*            id  ����Ӧ����idΪ��ֵ��li
	* @return -- none
	*/
	function banner_img_change(name,id){
		var img = new Image();                                    		//�������� ע��onloadһ��Ҫд�ڶ���ĺ���  
		img.onload = function()                                         //img��ǩ���ع����е��ú���
		{	
			document.getElementById(id).src = this.src;
		}
		img.src = name;                                                 //������ɺ����·��
	}
