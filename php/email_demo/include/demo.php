<?php
// 会员服务中心模块
class MemberAction extends Action
{	
    /**
    +----------------------------------------------------------
    * 加载首页
    +----------------------------------------------------------
    */
    public function index()
    {
		if(!empty($_SESSION["mid"])){
			//已经登录的话，直接跳到相应会员中心首页
			if($_SESSION["mtype"] == 1){
				$this->redirect('offlineexInfo');
			}else{
				$this->redirect('Memberper/index');
			}
		}else{
			$this->redirect('login');
		}
    }
		
	/**
    +----------------------------------------------------------
    * 会员登录
    +----------------------------------------------------------
    */
    public function login()
    {
		header("Content-Type:text/html;charset=utf-8");
		
		if($_POST["submit1"]){
			$corpuser = intval($_POST["corpuser"]);
			$corppass = trim($_POST["corppass"]);
				
			$Corp_user_obj = M("corp_user"); //实例化企业用户对象
			$row = $Corp_user_obj->where('status = 1 AND account = "'.$corpuser.'"')->find();
			$us = is_array($row);
			$ps = $us ? md5($corppass.MEMBER_PS) == $row["password"] : FALSE;
	
			if($ps){
				$_SESSION["mid"] = $row["id"];
				$_SESSION["mtype"] = 1;
				$_SESSION["member_shell"] = md5($row["account"].$row["password"].MEMBER_PS);
				$_SESSION["lang"] = intval($_GET["lg"]);                              //将语言版本信息保存在session中
					
				$Corp_user_obj->where('id = '.$row["id"])->setField('uTime',time());  //登录成功修改最近登录时间
				$Corp_user_obj->setInc('login_view','id = '.$row["id"]);              //更新登录次数
					
				$this->redirect('offlineexInfo'); //登录成功，跳转到后台首页
			}else{
				$this->success('登录账号或密码错误！');
			}
			
		}else if($_POST["submit2"]){
			$peremail = trim(strtolower($_POST["peremail"]));
			$perpass  = trim($_POST["perpass"]);
			
			$Personal_obj = M("personal_user");				    //实例化个人会员表
			$row = $Personal_obj->where('status = 1 AND email = "'.$peremail.'"')->find();
			$email = is_array($row);
			$ps = $email ? md5($perpass.MEMBER_PS) == $row["password"] : FALSE;
			
			if($ps){
				$_SESSION["mid"]   = $row["id"];
				$_SESSION["mtype"] = 2;
				$_SESSION["member_shell"] = md5($row["email"].$row["password"].MEMBER_PS);
				$_SESSION["lang"]  = intval($_GET["lg"]);                             //将语言版本信息保存在session中
					
				$Personal_obj->where('id = '.$row["id"])->setField('uTime',time());  //登录成功修改最近登录时间
				$Personal_obj->setInc('login_view','id = '.$row["id"]);              //更新登录次数
				
				$this->redirect('Memberper/index','',2,'登录成功，页面跳转中~~~~');    //登录成功，跳转到后台首页
			}else{
				$this->success("登录email账号或密码错误！");
			}

		}else{
			$mtype = empty($_GET['mtype']) ? 1 : $_GET['mtype']; 
			$this->assign('pagetitle',"会员登录 - cippe会员服务中心");
			$this->assign('mtype',$mtype);
			$this->display();
		}
		
    }
	
	/**
    +----------------------------------------------------------
    * 弹出层中会员登录
    +----------------------------------------------------------
    */
    public function popuplogin()
    {
		$curpageurl = $_POST['curpageurl'];
		$return['name'] = $jump['name'] = '会员登录';
		$return['urlcon'] = '<a href="javascript:history.back();">【返回上一步】</a>';
		
		if($_POST["submit1"]){
			$corpuser = intval($_POST["corpuser"]);
			$corppass = trim($_POST["corppass"]);
				
			$Corp_user_obj = M("corp_user"); //实例化企业用户对象
			$row = $Corp_user_obj->where('status = 1 AND account = "'.$corpuser.'"')->find();
			$us = is_array($row);
			$ps = $us ? md5($corppass.MEMBER_PS) == $row["password"] : FALSE;
	
			if($ps){
				$_SESSION["mid"] = $row["id"];
				$_SESSION["mtype"] = 1;
				$_SESSION["member_shell"] = md5($row["account"].$row["password"].MEMBER_PS);
				$_SESSION["lang"] = intval($_GET["lg"]);                              //将语言版本信息保存在session中
					
				$Corp_user_obj->where('id = '.$row["id"])->setField('uTime',time());  //登录成功修改最近登录时间
				$Corp_user_obj->setInc('login_view','id = '.$row["id"]);              //更新登录次数
				
				//登录成功，进行跳转操作
				$jump['time'] = 3;                    //自动跳转时间
				$jump['url'] = $curpageurl;           //跳转地址
				$jump['status'] = '1';                //成功1、 失败2
				$jump['msg']    = '登录成功！ '.$jump['time'].'秒后自动跳转...';        //提示信息内容
				$this->assign('jump',$jump);
				$this->display('Public/popupjump');                                         
			}else{
				$return['status'] = '2';                  	   //成功1、 失败2
				$return['msg']    = '登录账号或密码错误！';       //提示信息内容
				$this->assign('return',$return);
				$this->display('Public/popupreturn');
			}
			
		}else if($_POST["submit2"]){
			$peremail = trim(strtolower($_POST["peremail"]));
			$perpass  = trim($_POST["perpass"]);
			
			$Personal_obj = M("personal_user");				    //实例化个人会员表
			$row = $Personal_obj->where('status = 1 AND email = "'.$peremail.'"')->find();
			$email = is_array($row);
			$ps = $email ? md5($perpass.MEMBER_PS) == $row["password"] : FALSE;
			
			if($ps){
				$_SESSION["mid"]   = $row["id"];
				$_SESSION["mtype"] = 2;
				$_SESSION["member_shell"] = md5($row["email"].$row["password"].MEMBER_PS);
				$_SESSION["lang"]  = intval($_GET["lg"]);                             //将语言版本信息保存在session中
					
				$Personal_obj->where('id = '.$row["id"])->setField('uTime',time());  //登录成功修改最近登录时间
				$Personal_obj->setInc('login_view','id = '.$row["id"]);              //更新登录次数
					
				//登录成功，进行跳转操作
				$jump['time'] = 3;                    //自动跳转时间
				$jump['url'] = $curpageurl;           //跳转地址
				$jump['status'] = '1';                //成功1、 失败2
				$jump['msg']    = '登录成功！ '.$jump['time'].'秒后自动跳转...';        //提示信息内容
				$this->assign('jump',$jump);
				$this->display('Public/popupjump');
			}else{
				$return['status'] = '2';                  	        //成功1、 失败2
				$return['msg']    = '登录email账号或密码错误！';       //提示信息内容
				$this->assign('return',$return);
				$this->display('Public/popupreturn');
			}
		}
		
    }
	
	/**
    +----------------------------------------------------------
    * 个人会员注册
    +----------------------------------------------------------
    */
    public function register()
    {	
		$this->redirect('registPersonal');
    }
	
	/**
    +----------------------------------------------------------
    * 个人会员注册
    +----------------------------------------------------------
    */
    public function registPersonal()
    {	
		$userinfo = $this->public_check();
		require '../include/basearray.inc.php';   //引入公共数组文件
		$this->assign('country',$country);
		$this->assign('province',$province);
		$this->assign('mid',$_SESSION["mid"]);
		$this->assign('userinfo',$userinfo);
		$this->display();

    }
	
	/**
    +----------------------------------------------------------
    * 企业参观会员注册
    +----------------------------------------------------------
    */
    public function registCompany()
    {
		$userinfo = $this->public_check();
		$this->assign('mid',$_SESSION["mid"]);
		$this->assign('userinfo',$userinfo);
		$this->display();
    }
	
	/**
    +----------------------------------------------------------
    * 参展商会员注册
    +----------------------------------------------------------
    */
    public function registExhibitor()
    {
		$userinfo = $this->public_check();
		$this->assign('mid',$_SESSION["mid"]);
		$this->assign('userinfo',$userinfo);
		$this->display();
    }
	
	/**
    +----------------------------------------------------------
    * 会员注册提交处理
    +----------------------------------------------------------
    */
    public function registerDo()
    {
    	$Personal_obj = M("personal_user");    		//实例化个人用户对象		    
	    if($_GET){									//异步传输验证email和验证码
	    	if($_GET['email']){
	    		$check_email = $Personal_obj->where("(status = 1 OR status = 2) AND email = '".trim(strtolower($_GET['email']))."'")->getField('email');
	    		if($check_email){
		    		echo 'email_1';			       //该提示异步传输到页面,判断邮箱被注册过了
		   			exit();
		   		}
	    	}
	    	if($_GET['verify1']){
		 		if($_SESSION['verify'] != md5($_GET['verify1'])){
					echo 'verify1_1';			
					exit();
				}
	    	}        
	    }else{
			$regtype = $_POST['regtype'];     		  //获取注册类型：个人参观/参观商/参展商
			$http_host = 'http://'.$_SERVER['HTTP_HOST'];

			if($regtype){
				//个人参观用户注册
				if($regtype == 1){					  
					if(!empty($_POST['name']) && !empty($_POST['email'])){
		    			if(preg_match('/^[_\.\w-]+@([\w-]+\.)+[\w-]+$/',trim($_POST['email']))){  //正则匹配email
		    				$data['email'] = trim(strtolower(Input::getVar($_POST["email"])));
		    				$check_email   = $Personal_obj->where("(status = 1 OR status = 2) AND email = '".$data['email']."'")->getField('email');
		    				if($check_email){				  //判断email的唯一性
		    					$this->success('此邮箱已经被注册过了，请查证！'); 
		    					exit();
		    				}else{
								$data['password'] = trim(Input::getVar($_POST["password"]));
								$data['name'] 	  = trim(Input::getVar($_POST["name"]));
								$data['corpname'] = trim(Input::getVar($_POST["corpname"]));
								$data['title']	  = Input::getVar($_POST['title']);
								$data['cTime'] 	  = time();	
								$data['uTime'] 	  = time();	
								$data['password'] = md5($data['password'].MEMBER_PS);
								$data['status']   = 2;
								$person_add = $Personal_obj->add($data);
							
								if($person_add){
									//发送一封激活邮件给用户；
									require_once (VENDOR_PATH.'SendMail/email.class.php'); 					//导入邮件发送类库
									require_once (CONFIG_PATH.'mail.config.php');         					//导入邮件参数配置文件
									$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass); //实例化邮件发送类
									
									$smtpemailto = $data['email'];											//接收邮件地址
									$activation_link = base64_encode($data['password'].$person_add);		//组合用户激活码
									$mailsubject = '=?UTF-8?B?'.base64_encode('恭喜，您已成为cippe网上展览的个人参观会员，请激活您的账号！').'?=';
									$mailshowname = '=?UTF-8?B?'.base64_encode('cippe网上展览会员中心').'?=';        //发件人姓名显示
									
									$mailbody = "
										<html>
										<head>
										<title>cippe网上展览个人参观会员注册成功</title>
										<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
										</head>
										
										<body style=\"font-size:14px; line-height:150%;\">
										尊敬的 ".$data['name']." ".$data['title']."：<br>
										<h3 style=\"color:#f08200; font-size:18px; font-weight:bold;\">恭喜，您已成功注册为cippe网上展览个人参观会员！</h3>
										<h4 style=\"font-size:14px; font-weight:normal;\">请点击激活链接: <a href=\"".$http_host."/cn/Member/login</a>，成功激活账号后即可登录网上展览会员中心！</h4><br>
										
										<div style=\"font-size:14px; color:#333; line-height:150%; padding:10px; background-color:#F2F2F2;\">
											<h4 style=\"font-size:14px; font-weight:normal;\">“cippe网上展览个人参观会员” 免费享有以下特色服务：</h4>
											1、在线发布求购、咨询、关注等商情信息，让海量供应商自动找上门来！<br />
											2、最新贸易动态，第一时间了解最新的行业资讯、亮点产品技术、供应信息及最新加入的优质供应商！<br />
											3、在线咨询，一对一直接和感兴趣的供应商网上交流，沟通不再受时空限制！<br /><br />
											
											在线收藏夹、线下展会参观预登记、好友邀请、礼品兑换等更多应用服务，敬请关注...<br />
										</div>
																				
										</body>
										</html>
										";
									$smtp_status = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype, $mailshowname); //发送邮件
									
									$msg  = '个人会员注册成功！ ';
									$msg .= $smtp_status ? '我们已发送一封激活邮件到您的电子邮箱('.$data['email'].')，请确认！<br>如未收到激活邮件，请联系客服人员帮您激活账号，电话：010-58236521 ' : '抱歉，激活邮件发送失败，请联系我们的客服人员 010-58236521 ';
									$this->success($msg);
								}else{
									$this->success('个人会员数据建立失败，请联系我们的客服人员 010-58236521 查证！');
								}
								
		    				}
		    			}else{
		    				$this->success('email地址格式输入错误！');
		    			}
		    		}else{
		    			$this->success('必填项不能为空！');
		    		}
					
				//企业参观商注册
				}else if($regtype == 2){
				
				
				
				//企业参展商注册
				}else if($regtype == 3){
					
				}else{
					
				}
			}else{
				$this->assign('pagetitle',"会员注册成功");
				$this->display();    		
			}
	    }
		
    }
    /**
    +----------------------------------------------------------
    * 激活个人会员
    +----------------------------------------------------------
    */
    public function audit(){
    	$Personal_obj   = M("personal_user");				    	//实例化个人会员表
		$http_host = 'http://'.$_SERVER['HTTP_HOST'];
    	
    	if($_GET['active']){
    		$act = md5($_GET['active']);							//获取激活码激活码规则是：base64_encode(password+id)
    		$password = substr(base64_decode($_GET['active']),0,32);
    		$id = substr(base64_decode($_GET['active']),32);
    		$personal_row = $Personal_obj->field('password,status')->where('id = '.$id)->find();
    		
    		header("Content-Type:text/html;charset=utf-8");
    		if($personal_row['status'] == 1){    			
				echo "<script>alert('您在cippe网上展览注册的个人参观会员已经审核通过了,请直接登录！');window.location.href='".$http_host."/cn/member/login'</script>";
			}else if($password == $personal_row['password']){
    			$personal_active = $Personal_obj->where('id = '.$id)->setField('status',1);
    			$msg = $personal_active ? "恭喜，您的cippe网上展览个人参观会员激活成功，请登录！" : "抱歉，激活失败，请联系客服人员处理！ 电话：010-58236521";
    			echo "<script>alert('".$msg."');window.location.href='".$http_host."/cn/member/login/mtype/2'</script>";
    		}else{
    			echo "<script>alert('激活码错误，请联系我们的客服人员：010-58236521');</script>";
    		}
    		
    	}else{
    		echo "<script>alert('参数传递错误，请联系我们的客服人员：010-58236521');</script>";
    	}  
    } 
    

	
	/**
    +----------------------------------------------------------
    * 会员退出登陆
    +----------------------------------------------------------
    */
    public function loginout()
    {
		Session::destroy();
		$this->redirect('login');
    }
	
    /**
    +----------------------------------------------------------
    * 会员找回密码
    +----------------------------------------------------------
    */    
    public function getPassword(){
    	if($_POST['submit1']){										//企业用户

    	}else if($_POST['submit2']){								//个人用户
    		$Personal_obj = M('personal_user'); 					//实例化个人会员表
    		$peremail = trim(Input::getVar($_POST['peremail']));
    		
    		if(!empty($peremail)){   			
 				$perrow = $Personal_obj->field('id,email,title,name')->where("status = 1 AND email = '{$peremail}'")->find();  				
 				if(is_array($perrow)){
 					$code = rand_string(8,3,'23456789');    		//产生8位随机字母数字组合
					$pass_edit = $Personal_obj->where('id = '.$perrow['id'])->setField('password',md5($code.MEMBER_PS));
					if($pass_edit){
						//将初始化密码发送到对应用户邮箱中；
						require_once (VENDOR_PATH.'SendMail/email.class.php'); 					//导入邮件发送类库
						require_once (CONFIG_PATH.'mail.config.php');         					//导入邮件参数配置文件
						$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass); //实例化邮件发送类
						
						$smtpemailto = $perrow['email'];										//接收邮件地址
						$activation_link = base64_encode($data['password'].$person_add);		//组合用户激活码
						$mailsubject = '=?UTF-8?B?'.base64_encode('恭喜，您在cippe网上展览的个人参观会员密码已成功找回！').'?=';
						$mailshowname = '=?UTF-8?B?'.base64_encode('cippe网上展览会员中心').'?=';        //发件人姓名显示
						$http_host    = 'http://'.$_SERVER['HTTP_HOST'];			
						$mailbody = "
							<html>
							<head>
							<title>cippe网上展览个人参观会员密码找回成功</title>
							<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
							</head>
										
							<body style=\"font-size:14px; line-height:150%;\">
							尊敬的 ".$perrow['name']." ".$perrow['title']."：<br>
							<h3 style=\"color:#f08200; font-size:18px; font-weight:bold;\">恭喜，您已成功找回cippe网上展览个人参观会员登陆密码！</h3>
							<h4 style=\"font-size:14px; font-weight:normal;\">您的密码是：&nbsp; <font style=\"color:#f08200; font-size:16px; font-weight:bold;\">".$code."</font> ；请点击登陆链接: <a href=\"".$http_host."/cn/Member/cn/Member/login.html\">".$http_host."/cn/Member/cn/Member/login.html</a>，直接登录网上展览会员中心！</h4><br>
										
							<div style=\"font-size:14px; color:#333; line-height:150%; padding:10px; background-color:#F2F2F2;\">
							<h4 style=\"font-size:14px; font-weight:normal;\">“cippe网上展览个人参观会员” 免费享有以下特色服务：</h4>
							1、在线发布求购、咨询、关注等商情信息，让海量供应商自动找上门来！<br />
							2、最新贸易动态，第一时间了解最新的行业资讯、亮点产品技术、供应信息及最新加入的优质供应商！<br />
							3、在线咨询，一对一直接和感兴趣的供应商网上交流，沟通不再受时空限制！<br /><br />
											
							在线收藏夹、线下展会参观预登记、好友邀请、礼品兑换等更多应用服务，敬请关注...<br />
							</div>
																				
							</body>
							</html>
							";
						$smtp_status = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype, $mailshowname); //发送邮件
									
						$msg .= $smtp_status ? '我们已把初始化的密码发送到您的电子邮箱('.$perrow['email'].')，请确认！<br>如未收到激活邮件，请联系客服人员，电话：010-58236521 ' : '抱歉，邮件发送失败，请联系我们的客服人员 010-58236521 ';						
						$this->success($msg);
						
					}else{
						$this->success('密码修改失败！');
					}
 				}else{
 					$this->success('电子邮箱地址不存在或输入错误，请查证！');
 				}			
    		}else{
    			$this->success('电子邮箱地址不能为空，请查证！');
    		}
    	}else{
	    	$mtype = empty($_GET['mtype']) ? 1 : $_GET['mtype']; 
			$this->assign('pagetitle',"找回密码 - cippe会员服务中心");
			$this->assign('mtype',$mtype);
			$this->display();
    	}
    }
	
	/**
    +----------------------------------------------------------
    * 会员更改登录密码
    +----------------------------------------------------------
    */
    public function userpassEdit()
    {
		$user_info = $this->login_check();
		
		if($_POST["submit"]){
			if($_POST["nuserpass"] == $_POST["ruserpass"]){
				if($_SESSION["mtype"] == 1){
					$Member_user_obj = M("corp_user");        //实例化企业用户对象
				}else if($_SESSION["mtype"] == 2){
					$Member_user_obj = M("personal_user");    //实例化个人用户对象	
				}	
					
				$rps = $Member_user_obj->where('id = '.$_SESSION["mid"])->setField('password',md5($_POST["nuserpass"].MEMBER_PS));
				if($rps){
					$row = $Member_user_obj->where('id = '.$_SESSION["mid"])->find();				
					$_SESSION["member_shell"] = md5($row["account"].$row["password"].MEMBER_PS);  //更新session shell
					
					//更新企业用户密码编码表；
					$Corp_usercode_obj = M("crop_usercode");            //实例化编码表
					$Corp_usercode_obj->where('uid = '.$row["id"])->delete(); //如已有数据则先删除
					$usercode['uid'] = $row["id"];
					$usercode['content'] = base64_encode($_POST["nuserpass"]);
					$usercode['uTime'] = time();			
					$res_usercode = $Corp_usercode_obj->add($usercode);
				
					$rps_msg = "密码修改成功！";
				}else{
					$rps_msg = "密码修改失败，请返回重试！";
				}
				$this->success($rps_msg);
			}else{
				$this->success('两次输入的密码不一致！');
			}
		}else{
			$this->assign('flag',2);                  //导航选择
			$userinfo['username'] = $user_info[2]['corpname_cn'];
			$this->assign('mid',$_SESSION["mid"]);
			$this->assign('userinfo',$userinfo);
			$this->assign('pagetitle',"更改登录密码");
			$this->display();
		}
    }
	

    /**
    +----------------------------------------------------------
    * 企业会员中心首页
    +----------------------------------------------------------
    */
    public function corpindex()
    {
		$user_info = $this->login_check();
		$this->redirect('corpInfo');		
		
		//$userinfo['username'] = $user_info[2];
		//$this->assign('mid',$_SESSION["mid"]);
		//$this->assign('userinfo',$userinfo);
		//$this->assign('pagetitle',"企业会员服务中心");
		//$this->display();
    }
	
	/**
    +----------------------------------------------------------
    * 企业会员中心企业基本信息维护
    +----------------------------------------------------------
    */
    public function corpInfo()
    {
		$user_info = $this->login_check();
		$Corp_baseinfo_obj = M("corp_baseinfo"); //实例化Corp_baseinfo对象
		
		
		if($_POST["submit"]){
			$data['corpname_cn'] 	 = trim(addslashes($_POST["corpname_cn"]));
			$data['corpname_en'] 	 = trim(addslashes($_POST["corpname_en"]));
			$upinfo = $this->uplogo(); //调用上传logo方法获取图片上传情况
			if($upinfo[0]){
				$data['corplogo_cn'] 	 = $upinfo[1][0]["savename"];
				$data['corplogo_en'] 	 = $upinfo[1][0]["savename"];	
			}
			$data['introduct_cn'] 	 = $_POST["introduct_cn"];
			$data['introduct_en'] 	 = $_POST["introduct_en"];
			$data['license'] 		 = trim(addslashes($_POST["license"]));			
			$data['address_cn'] 	 = trim(addslashes($_POST["address_cn"]));
			$data['address_en'] 	 = trim(addslashes($_POST["address_en"]));
			$data['zip'] 			 = trim(addslashes($_POST["zip"]));
			$data['phone'] 			 = trim(addslashes($_POST["phone"]));
			$data['fax'] 			 = trim(addslashes($_POST["fax"]));
			$data['email'] 			 = trim(addslashes($_POST["email"]));
			$data['website'] 		 = trim(addslashes($_POST["website"]));
			if(intval($_POST["country"]) != 0){
				$data['country'] 	 = intval($_POST["country"]);
			}
			if(intval($_POST["province"]) != 0){
				$data['province'] 	 = intval($_POST["province"]);
			}
			if(intval($_POST["corptype"]) != ""){
				$data['corptype'] 	 = intval($_POST["corptype"]);
			}			
			$data['uTime'] 			 = time();
			
			$res = $Corp_baseinfo_obj->where('id = '.$_GET['id'])->save($data);
				
			if($res){					
				$msg = '企业信息更新成功！ ';				
				$this->success($msg);				
			}else{
				$this->success('操作失败，请重试，或咨询客服人员！');	
			}
			
			/*
			if($data['corpname_cn'] != '' && $data['corpname_en'] != '' && $data['introduct_cn'] != '' && $data['address_cn'] != '' && $data['zip'] != '' && $data['phone'] != '' && $data['email'] != '' && $data['country'] != 0 && $data['province'] != 0 && $data['corptype'] != ''){			
				$res = $Corp_baseinfo_obj->where('id = '.$_GET['id'])->save($data);
				
				if($res){					
					$msg = '企业信息更新成功！ ';
					
					$this->success($msg);				
				}else{
					$this->success('操作失败，请重试，或咨询客服人员！');	
				}
			}else{
				$msg  = $data['corpname_cn'] != '' ? '' : '企业中文名不能为空！ ';
				$msg .= $data['corpname_en'] != '' ? '' : '企业英文名不能为空！ ';
				$msg .= $data['introduct_cn'] != '' ? '' : '企业中文简介不能为空！ ';
				$msg .= $data['address_cn'] != '' ? '' : '中文地址不能为空！ ';
				$msg .= $data['zip'] != '' ? '' : '邮编不能为空！ ';
				$msg .= $data['phone'] != '' ? '' : '公司电话不能为空！ ';
				$msg .= $data['email'] != '' ? '' : '公司邮箱不能为空！ ';
				$msg .= $data['country'] != 0 ? '' : '所属国家未选择！ ';
				$msg .= $data['province'] != 0 ? '' : '所属省份未选择！ ';
				$msg .= $data['corptype'] != '' ? '' : '企业类型未选择！ ';

				$this->success($msg);
			}*/
			
		}else{
			require '../include/basearray.inc.php';   //引入公共数组文件
			$corpinfo = $user_info[2];
			
			$this->assign('corpinfo',$corpinfo);
			$this->assign('country',$country);
			$this->assign('province',$province);
			
			$this->assign('flag',1);                  //导航选择
			$userinfo['username'] = $corpinfo['corpname_cn'];
			$this->assign('mid',$_SESSION["mid"]);		
			$this->assign('userinfo',$userinfo);
			$this->assign('pagetitle',"企业基本信息维护");
			$this->display();
		}

    }
	
	/**
    +----------------------------------------------------------
    * 参展商类别选择
    +----------------------------------------------------------
    */
    public function excategoryEdit()
    {
		$user_info = $this->login_check();
		
		$Category_obj = M("category");             //实例化匹配类别类
		$Relatecate_obj = M("relatecate_ex");      //实例化参展商-匹配类别关系表

		$exid       = $user_info[1]['id'];
				
		if($_POST["submit"]){
			$excate1['cid'] = intval($_POST["excate1"]);
			$excate2['cid'] = intval($_POST["excate2"]);
			$excate3['cid'] = intval($_POST["excate3"]);
			$excate1['eid'] = $excate2['eid'] = $excate3['eid'] = $exid;
			$Relatecate_obj->where('eid = '.$exid)->delete();
			$addcate1 = $excate1['cid'] > 0 ? $Relatecate_obj->add($excate1) : 1; 
			$addcate2 = $excate2['cid'] > 0 ? $Relatecate_obj->add($excate2) : 1;
			$addcate3 = $excate3['cid'] > 0 ? $Relatecate_obj->add($excate3) : 1;
			
			if($addcate1 && $addcate2 && $addcate3){
				$this->success('参展商类别修改成功！');		
			}else{
				$this->success('参展商类别修改失败，请重试！');	
			}
			
		}else{
			//查询匹配分类
			$hcate_row = $Category_obj->where('status = 1 AND hid = 0')->order('catetype desc')->select();
			$relatecate_count = $Relatecate_obj->where('eid = '.$exid)->count();			
			$relatecate = $Relatecate_obj->where('eid = '.$exid)->order('id asc')->select();
			$n = 1;
			foreach ($relatecate as $cate){
				$hcate = $Category_obj->where('id = '.$cate['cid'])->find();
				$cate['num'] = $n;
				$n++;
				
				//语言版本选择处理
				if($_SESSION["lang"] == 2){
					$cate['catename'] = $hcate['catename_en'];
				}else{
					$cate['catename'] = $hcate['catename_cn'];
				}
				$catelist[] = $cate;
			}
			$this->assign('hcatelist',$hcate_row);
			$this->assign('catecount',$relatecate_count);
			$this->assign('catelist',$catelist);
			
			$this->assign('flag',1);                  //导航选择
			$userinfo['username'] = $user_info[2]['corpname_cn'];
			$this->assign('mid',$_SESSION["mid"]);
			$this->assign('userinfo',$userinfo);
			$this->assign('pagetitle',"参展商类别选择");
			$this->display();
		}
    }
	
	/**
    +----------------------------------------------------------
    * 参展商发布展品
    +----------------------------------------------------------
    */
    public function productAdd()
    {
		$user_info = $this->login_check();             //调用检查登录会员中心登录状态方法
		
		$Category_obj = M("category");                 //实例化匹配类别类
		$Product_obj = M("product");                   //实例化展品类
		$Product_img_obj = M("product_img");           //实例化展品图片类
		$Relatecate_pro_obj = M("relatecate_pro");     //实例化展品-匹配类别关系表
		
		//语言版本选择处理
		if($_SESSION["lang"] == 2){
			require '../include/basearray_en.inc.php';        //引入英文公共数组文件
		}else{
			require '../include/basearray.inc.php';        //引入中文公共数组文件
		}
		$exid = $user_info[1]['id'];
				
		if($_POST["submit"]){
			
			$data['eid']             = $exid;
			$data['proname_cn'] 	 = trim(addslashes($_POST["proname_cn"]));
			$data['proname_en'] 	 = trim(addslashes($_POST["proname_en"]));
			$data['prodetails_cn'] 	 = $_POST["prodetails_cn"];
			$data['prodetails_en'] 	 = $_POST["prodetails_en"];
			$data['protype']         = intval($_POST["protype"]);
			$data['uTime']           = time();
			$data_procate['cid']     = intval($_POST["procate1"]);
			
			if($data['proname_cn'] != '' && $data['proname_en'] != '' && $data_procate['cid'] != 0 && $data['protype'] != 0 && $data['prodetails_cn'] != ''){			
				$res = $Product_obj->add($data);
				
				if($res){
					$msg = '展品添加成功！ ';
					
					$upinfo = $this->upProduct();          //调用上传产品图片方法获取图片上传情况
					if($upinfo[0]){
						$data_proimg['img_url'] = $upinfo[1][0]["savename"];
						$data_proimg['pid'] = $res;
					}
					$res_proimg = $Product_img_obj->add($data_proimg);
					$msg .= $res_proimg ? '' : '展品图片未能上传成功，请查证！';
					
					//创建展品-匹配类关系数据				
					$data_procate['pid'] = $res;
					$res_procate = $Relatecate_pro_obj->add($data_procate);
					$msg .= $res_procate ? '' : '展品大类未能选择，请查证！';
					
					$this->success($msg);				
				}else{
					$this->success('操作失败，展品未能添加成功，请重试，或咨询客服人员！');	
				}
			}else{
				$msg  = $data['proname_cn'] != '' ? '' : '展品中文名不能为空！ ';
				$msg .= $data['proname_en'] != '' ? '' : '展品英文名不能为空！ ';
				$msg .= $data_procate['cid'] != 0 ? '' : '展品大类未选择！ ';
				$msg .= $data['prodetails_cn'] != '' ? '' : '展品中文简介不能为空！ ';
				$msg .= $data['protype'] != 0 ? '' : '展品类型未选择！ ';
				$this->success($msg);
			}
		}else{
			//查询匹配分类
			$hcate_row = $Category_obj->where('status = 1 AND hid = 0')->order('catetype desc')->select();
			//传递变量
			$this->assign('hcatelist',$hcate_row);
			$this->assign('protype',$protype);
			
			$this->assign('flag',1);                  //导航选择
			$userinfo['username'] = $user_info[2]['corpname_cn'];
			$this->assign('mid',$_SESSION["mid"]);
			$this->assign('userinfo',$userinfo);
			$this->assign('pagetitle',"发布展品");
			$this->display();
		}	
		
	}
	
	/**
    +----------------------------------------------------------
    * 参展商展品删除
    +----------------------------------------------------------
    */
    public function productDel()
    {
		$user_info = $this->login_check();
		$pid = intval($_GET["id"]);
		
		$Product_obj = M("product");                   //实例化展品类
		$Product_img_obj = M("product_img");           //实例化展品图片类
		$Relatecate_pro_obj = M("relatecate_pro");     //实例化展品-匹配类别关系表
		
		$Product_obj->where('id = '.$pid)->delete();         // 删除展品表中记录
		$Product_img_obj->where('pid = '.$pid)->delete();    // 删除展品图片表中记录
		$Relatecate_pro_obj->where('pid = '.$pid)->delete(); // 删除关系表表中记录
		
		$this->redirect('productManage');
	}
	
	/**
    +----------------------------------------------------------
    * 参展商展品修改
    +----------------------------------------------------------
    */
    public function productEdit()
    {
		$user_info = $this->login_check();             //调用检查登录会员中心登录状态方法
		
		$Category_obj = M("category");                 //实例化匹配类别类
		$Product_obj = M("product");                   //实例化展品类
		$Product_img_obj = M("product_img");           //实例化展品图片类
		$Relatecate_pro_obj = M("relatecate_pro");     //实例化展品-匹配类别关系表

		//语言版本选择处理
		if($_SESSION["lang"] == 2){
			require '../include/basearray_en.inc.php';        //引入英文公共数组文件
		}else{
			require '../include/basearray.inc.php';        //引入中文公共数组文件
		}
		$exid = $user_info[1]['id'];
		$pid  = intval($_GET["id"]);
				
		if($_POST["submit"]){
			
			$data['eid']             = $exid;
			$data['proname_cn'] 	 = trim(addslashes($_POST["proname_cn"]));
			$data['proname_en'] 	 = trim(addslashes($_POST["proname_en"]));
			$data['prodetails_cn'] 	 = $_POST["prodetails_cn"];
			$data['prodetails_en'] 	 = $_POST["prodetails_en"];
			$data['protype']         = intval($_POST["protype"]);
			$data['uTime']           = time();
			$data_procate['cid']     = intval($_POST["procate1"]);
			
			if($data['proname_cn'] != '' && $data['proname_en'] != '' && $data_procate['cid'] != 0 && $data['protype'] != 0 && $data['prodetails_cn'] != ''){			
				$res = $Product_obj->where('id = '.$pid)->save($data);
				
				if($res){
					$msg = '展品修改成功！ ';
					
					$upinfo = $this->upProduct();          //调用上传产品图片方法获取图片上传情况
					if($upinfo[0]){
						$data_proimg['img_url'] = $upinfo[1][0]["savename"];
						$data_proimg['pid'] = $pid;
					}
					$res_proimg = $Product_img_obj->where('id = '.$_POST['imgid'])->save($data_proimg);
					$msg .= $res_proimg ? '' : '展品图片没有更新！';
					
					//修改展品-匹配类关系数据									
					$Relatecate_pro_obj->where('pid = '.$pid)->delete(); // 删除关系表表中记录	
					$data_procate['pid'] = $pid;
					$res_procate = $Relatecate_pro_obj->add($data_procate);
					$msg .= $res_procate ? '' : '展品大类未能选择，请查证！';
					
					$this->success($msg);				
				}else{
					$this->success('操作失败，展品未能修改成功，请重试，或咨询客服人员！');	
				}
			}else{
				$msg  = $data['proname_cn'] != '' ? '' : '展品中文名不能为空！ ';
				$msg .= $data['proname_en'] != '' ? '' : '展品英文名不能为空！ ';
				$msg .= $data_procate['cid'] != 0 ? '' : '展品大类未选择！ ';
				$msg .= $data['prodetails_cn'] != '' ? '' : '展品中文简介不能为空！ ';
				$msg .= $data['protype'] != 0 ? '' : '展品类型未选择！ ';
				$this->success($msg);
			}
		}else{
			//查询匹配分类
			$hcate_row = $Category_obj->where('status = 1 AND hid = 0')->order('catetype desc')->select();
			$res_pro = $Product_obj->where('id = '.$pid)->find();
			$res_proimg = $Product_img_obj->where('pid = '.$pid)->order('id asc')->find();
			$res_procate = $Relatecate_pro_obj->where('pid = '.$pid)->find();
			$res_category = $Category_obj->where('id = '.$res_procate['cid'])->find();
			
			$res_pro['imgid'] = $res_proimg['id'];
			$res_pro['img'] = $res_proimg['img_url'];
			$res_pro['thumbimg'] = substr($res_proimg['img_url'], 9);
			$res_pro['procateid'] = $res_procate['cid'];
			//语言版本选择处理
			if($_SESSION["lang"] == 2){
				$res_pro['procatename'] = $res_category['catename_en'];
			}else{
				$res_pro['procatename'] = $res_category['catename_cn'];
			}
			
			//传递变量
			$this->assign('respro',$res_pro);
			$this->assign('hcatelist',$hcate_row);
			$this->assign('protype',$protype);
			
			$this->assign('flag',1);                  //导航选择
			$userinfo['username'] = $user_info[2]['corpname_cn'];
			$this->assign('mid',$_SESSION["mid"]);
			$this->assign('userinfo',$userinfo);
			$this->assign('pagetitle',"展品修改");
			$this->display();
		}	
		
	}

	/**
    +----------------------------------------------------------
    * 参展商展品管理
    +----------------------------------------------------------
    */
    public function productManage()
    {
		$user_info = $this->login_check();
		
		//语言版本选择处理
		if($_SESSION["lang"] == 2){
			require '../include/basearray_en.inc.php';        //引入英文公共数组文件
		}else{
			require '../include/basearray.inc.php';        //引入中文公共数组文件
		}
		$Category_obj = M("category");                 //实例化匹配类别类
		$Relatecate_pro_obj = M("relatecate_pro");     //实例化展品-匹配类别关系表
		$Product_obj = M("product");                   //实例化展品类
		$Product_img_obj = M("product_img");           //实例化展品图片类
		$exid       = $user_info[1]['id'];
		
		$row_pro = $Product_obj->where('eid = '.$exid)->order('uTime desc')->select();
		$n = 1;
		foreach ($row_pro as $value){
			$row_proimg = $Product_img_obj->where('pid = '.$value['id'])->order('id asc')->find();
			$row_procate = $Relatecate_pro_obj->where('pid = '.$value['id'])->find();
			$row_category = $Category_obj->where('id = '.$row_procate['cid'])->find();
			
			$value['num'] = $n;
			$n++;
			$value['img'] = $row_proimg['img_url'];
			$value['thumbimg'] = substr($row_proimg['img_url'], 9);
			//语言版本选择处理
			if($_SESSION["lang"] == 2){
				$value['catename'] = $row_category['catename_en'];
			}else{
				$value['catename'] = $row_category['catename_cn'];
			}
			$value['protype'] = $protype[$value['protype']];
			$value['uTime'] = date('Y-m-d H:i:s',$value['uTime']);		
			$productlist[] = $value;
		}
		
		$this->assign('productlist',$productlist);
		
		$this->assign('flag',1);                  //导航选择
		$userinfo['username'] = $user_info[2]['corpname_cn'];
		$this->assign('mid',$_SESSION["mid"]);
		$this->assign('userinfo',$userinfo);
		$this->assign('pagetitle',"展品管理");
		$this->display();
	}
	
	
	/*--------------------- 线下展会 cubo117 ---------------------------------------------------------------------------------------------------------------------*/
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会 - 服务状态信息公共获取方法
    +----------------------------------------------------------
    */
    public function offlineexStatus()
    {
		$Offlineex_obj = M("offlineex");         //实例化offlineex对象
		$Exproject_obj = M("exproject");         //实例化展会项目类
		
		$Is_exproject = $Exproject_obj->where('status = 1')->find();   //查询当前有效的线下展会项目
		$Is_offlineex = $Offlineex_obj->where('status = 1 and uid = '.$_SESSION["mid"].' and epid = '.$Is_exproject['id'])->order('cTime desc')->find();  //查询当前有效的线下展会项目下，此用户是否开通了参展记录；
		if(!empty($Is_offlineex)){
			return $Is_offlineex;   //如果通过，则返回所参加的线下展会主表信息
		}else{
			return 0;
		}
	}
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，参展信息及展品范围设置
    +----------------------------------------------------------
    */
    public function offlineexInfo()
    {
		$user_info = $this->login_check();                   //企业会员登录检测
		$offlineex_status = $this->offlineexStatus();        //线下展会初始状态信息检测及获取
		
		//通用信息传递
		$this->assign('flag',1);  //导航选择
		$this->assign('pagetitle',"参展信息及展品范围");
		
		if($offlineex_status == 0){
			$this->assign('memberMsg',"您目前没有有效的线下展会参展记录，不能操作此项功能！");
			$this->display('memberMsg');
		}else{
			$Offlineex_obj = M("offlineex");         //实例化offlineex对象
			$Exproject_obj = M("exproject");         //实例化展会项目类
						
			if($_POST["submit"]){
				$data['exrange_cn'] 	 = Input::getVar($_POST["exrange_cn"]);
				$data['exrange_en'] 	 = Input::getVar($_POST["exrange_en"]);
				$data['uTime'] 			 = time();
	
				if($data['exrange_cn'] != '' || $data['exrange_en'] != ''){			
					$res = $Offlineex_obj->where('id = '.$_GET['id'])->save($data);
					
					if($res){					
						$msg = '参展信息更新成功！';					
						$this->success($msg);				
					}else{
						$this->success('操作失败，请重试，或咨询客服人员！');	
					}
				}else{
					$msg  = $data['exrange_cn'] != '' ? '' : '展品及范围中文不能为空！ ';
					$msg .= $data['exrange_en'] != '' ? '' : '展品及范围英文不能为空！ ';
					$this->success($msg);
				}
				
			}else{			
				$exproject = $Exproject_obj->where('id = '.$offlineex_status['epid'])->find();
				$offlineexInfo = $offlineex_status;
				$offlineexInfo['epname_cn'] = $exproject['name_cn'];
				$offlineexInfo['epname_en'] = $exproject['name_en'];
				
				$this->assign('offlineex',$offlineexInfo);
				$this->display();
			}		
		}
		
    }
		
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，参展商会刊资料维护
    +----------------------------------------------------------
    */
    public function offlineexCatalogue()
    {
		//语言版本选择处理
		if($_SESSION["lang"] == 2){
			require '../include/basearray_en.inc.php';        //引入英文公共数组文件
		}else{
			require '../include/basearray.inc.php';        //引入中文公共数组文件
		}
		$user_info = $this->login_check();                   //企业会员登录检测
		$offlineex_status = $this->offlineexStatus();        //线下展会初始状态信息检测及获取
		$Corp_baseinfo_obj = M("corp_baseinfo");             //实例化Corp_baseinfo对象
		$Offlineex_scinfo_obj = M("offlineex_scinfo");       //实例化Offlineex_scinfo线下展会会刊基本资料对象
		
		//通用信息传递
		$this->assign('flag',1);  //导航选择
		$this->assign('pagetitle',"参展商会刊资料维护");
				
		if($offlineex_status == 0){
			$this->assign('memberMsg',"您目前没有有效的线下展会参展记录，不能操作此项功能！");
			$this->display('memberMsg');
		}else{
								
			if($_POST["submit"]){
				$data['corpname_cn'] 	 = Input::getVar($_POST["corpname_cn"]);
				$data['corpname_en'] 	 = Input::getVar($_POST["corpname_en"]);
				$upinfo = $this->uplogo(); //调用上传logo方法获取图片上传情况
				if($upinfo[0]){
					$data['corplogo_cn'] 	 = $upinfo[1][0]["savename"];
					$data['corplogo_en'] 	 = $upinfo[1][0]["savename"];	
				}
				$data['introduct_cn'] 	 = Input::getVar($_POST["introduct_cn"]);
				$data['introduct_en'] 	 = Input::getVar($_POST["introduct_en"]);
				$data['license'] 		 = Input::getVar($_POST["license"]);			
				$data['address_cn'] 	 = Input::getVar($_POST["address_cn"]);
				$data['address_en'] 	 = Input::getVar($_POST["address_en"]);
				$data['zip'] 			 = Input::getVar($_POST["zip"]);
				$data['phone'] 			 = Input::getVar($_POST["phone"]);
				$data['fax'] 			 = Input::getVar($_POST["fax"]);
				$data['email'] 			 = Input::getVar($_POST["email"]);
				$data['website'] 		 = Input::getVar($_POST["website"]);				
				$data['country']         = intval($_POST["country"]) != 0 ? intval($_POST["country"]) : 0;
				$data['province']        = intval($_POST["province"]) != 0 ? intval($_POST["province"]) : 0;
				$data['corptype']        = intval($_POST["corptype"]) != 0 ? intval($_POST["corptype"]) : 0;		
				$data['uTime'] 			 = time();
				
				$res = $Offlineex_scinfo_obj->where('id = '.$_GET['id'])->save($data);
					
				if($res){					
					$msg = '企业信息更新成功！ ';				
					$this->success($msg);				
				}else{
					$this->success('操作失败，请重试，或咨询客服人员！');	
				}
				
			}else{
				$resCorpinfo = $Offlineex_scinfo_obj->where('oeid = '.$offlineex_status['id'])->find();
				$resCorpbaseinfo = $Corp_baseinfo_obj->where('id = '.$offlineex_status['bid'])->find();
				$resCorpinfo['corpname_cn'] = $resCorpinfo['corpname_cn'] == '' ? $resCorpbaseinfo['corpname_cn'] : $resCorpinfo['corpname_cn'];
				$resCorpinfo['corpname_en'] = $resCorpinfo['corpname_en'] == '' ? $resCorpbaseinfo['corpname_en'] : $resCorpinfo['corpname_en'];
				$resCorpinfo['corplogo_cn'] = $resCorpinfo['corplogo_cn'] == '' ? $resCorpbaseinfo['corplogo_cn'] : $resCorpinfo['corplogo_cn'];
				$resCorpinfo['license'] = $resCorpinfo['license'] == '' ? $resCorpbaseinfo['license'] : $resCorpinfo['license'];
				$resCorpinfo['introduct_cn'] = $resCorpinfo['introduct_cn'] == '' ? $resCorpbaseinfo['introduct_cn'] : $resCorpinfo['introduct_cn'];
				$resCorpinfo['introduct_en'] = $resCorpinfo['introduct_en'] == '' ? $resCorpbaseinfo['introduct_en'] : $resCorpinfo['introduct_en'];
				$resCorpinfo['address_cn'] = $resCorpinfo['address_cn'] == '' ? $resCorpbaseinfo['address_cn'] : $resCorpinfo['address_cn'];
				$resCorpinfo['address_en'] = $resCorpinfo['address_en'] == '' ? $resCorpbaseinfo['address_en'] : $resCorpinfo['address_en'];				
				$resCorpinfo['zip'] = $resCorpinfo['zip'] == '' ? $resCorpbaseinfo['zip'] : $resCorpinfo['zip'];
				$resCorpinfo['phone'] = $resCorpinfo['phone'] == '' ? $resCorpbaseinfo['phone'] : $resCorpinfo['phone'];
				$resCorpinfo['fax'] = $resCorpinfo['fax'] == '' ? $resCorpbaseinfo['fax'] : $resCorpinfo['fax'];
				$resCorpinfo['email'] = $resCorpinfo['email'] == '' ? $resCorpbaseinfo['email'] : $resCorpinfo['email'];
				$resCorpinfo['website'] = $resCorpinfo['website'] == '' ? $resCorpbaseinfo['website'] : $resCorpinfo['website'];				
				$resCorpinfo['country'] = $resCorpinfo['country'] == 0 ? $resCorpbaseinfo['country'] : $resCorpinfo['country'];
				$resCorpinfo['province'] = $resCorpinfo['province'] == 0 ? $resCorpbaseinfo['province'] : $resCorpinfo['province'];				
				$resCorpinfo['corptype'] = $resCorpinfo['corptype'] == 0 ? $resCorpbaseinfo['corptype'] : $resCorpinfo['corptype'];
				
				$this->assign('corpinfo',$resCorpinfo);
				$this->assign('country',$country);
				$this->assign('province',$province);
				$this->assign('corptype',$corptype);			
				$this->display();
			}	
		}
		
    }
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，楣板设置
    +----------------------------------------------------------
    */
    public function offlineexBoard()
    {
		$user_info = $this->login_check();                   //企业会员登录检测
		$offlineex_status = $this->offlineexStatus();        //线下展会初始状态信息检测及获取
		
		//通用信息传递
		$this->assign('flag',1);  //导航选择
		$this->assign('pagetitle',"楣板设置");
		
		if($offlineex_status == 0){
			$this->assign('memberMsg',"您目前没有有效的线下展会参展记录，不能操作此项功能！");
			$this->display('memberMsg');
		}else{			
			$Offlineex_obj = M("offlineex");         //实例化offlineex对象
			
			if($_POST["submit"]){
				$data['board_cn'] 	 = Input::getVar($_POST['board_cn']);
				$data['board_en'] 	 = Input::getVar($_POST["board_en"]);
				$data['uTime'] 		 = time();
			
				$res = $Offlineex_obj->where('id = '.$_GET['id'])->save($data);
					
				if($res){					
					$msg = '楣板信息更新成功！';					
					$this->success($msg);				
				}else{
					$this->success('操作失败，请重试，或咨询客服人员！');	
				}
	
			}else{
				$this->assign('offlineex',$offlineex_status);
				$this->display();
			}
		}
	}
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，展商胸卡申请
    +----------------------------------------------------------
    */
    public function offlineexBadge()
    {
		$user_info = $this->login_check();                   //企业会员登录检测
		$offlineex_status = $this->offlineexStatus();        //线下展会初始状态信息检测及获取
		
		//通用信息传递
		$this->assign('flag',1);  //导航选择
		$this->assign('pagetitle',"展商胸卡申请");
		
		if($offlineex_status == 0){
			$this->assign('memberMsg',"您目前没有有效的线下展会参展记录，不能操作此项功能！");
			$this->display('memberMsg');
		}else{
			$Offlineex_badge_obj = M("offlineex_badge");         //实例化offlineex_badge对象
			
			if($_POST["submit"]){
				$data['epid']        = $offlineex_status['epid'];
				$data['oeid']        = $offlineex_status['id'];
				$data['name'] 	     = Input::getVar($_POST["badge_name"]);
				$data['corpname'] 	 = Input::getVar($_POST["badge_corpname"]);
				$data['position'] 	 = Input::getVar($_POST["badge_position"]);
				$data['cTime'] 		 = time();
				
				if($data['name'] != '' && $data['corpname'] != '' && $data['position'] != ''){			
					$res = $Offlineex_badge_obj->add($data);
					
					if($res){
						$this->redirect('offlineexBadge');
					}else{
						$this->success('操作失败，请重试，或咨询客服人员！');	
					}
				}else{
					$msg  = $data['name'] != '' ? '' : '姓名不能为空！ ';
					$msg .= $data['corpname'] != '' ? '' : '公司名称不能为空！ ';
					$msg .= $data['position'] != '' ? '' : '职务不能为空！ ';
					$this->success($msg);
				}
				
			}else{
				$offlineex_badge = $Offlineex_badge_obj->where('oeid = '.$offlineex_status['id'])->order('cTime asc')->select();
				$n = 1;
				foreach ($offlineex_badge as $value){
					$value['num'] = $n;
					$n++;
					$badge[] = $value;
				}
				
				$this->assign('badge',$badge);
				$this->display();
			}
		}
	}
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，展商胸卡修改
    +----------------------------------------------------------
    */
    public function offlineexBadgeEdit()
    {
		$user_info = $this->login_check();
		$Offlineex_badge_obj = M("offlineex_badge");         //实例化offlineex对象
		
		if($_POST["submit"]){
			$data['name'] 	     = trim(addslashes($_POST["badge_name"]));
			$data['corpname'] 	 = trim(addslashes($_POST["badge_corpname"]));
			$data['position'] 	 = trim(addslashes($_POST["badge_position"]));
			$data['uTime'] 		 = time();
			
			if($data['name'] != '' && $data['corpname'] != '' && $data['position'] != ''){			
				$res = $Offlineex_badge_obj->where('id = '.$_GET['id'])->save($data);
				
				if($res){					
					$this->redirect('offlineexBadge');
				}else{
					$this->success('操作失败，请重试，或咨询客服人员！');	
				}
			}else{
				$msg  = $data['name'] != '' ? '' : '姓名不能为空！ ';
				$msg .= $data['corpname'] != '' ? '' : '公司名称不能为空！ ';
				$msg .= $data['position'] != '' ? '' : '职务不能为空！ ';
				$this->success($msg);
			}
					
		}else{
			$offlineex_badge = $Offlineex_badge_obj->where('id = '.$_GET['id'])->find();
			$this->assign('badge',$offlineex_badge);
			
			$this->assign('flag',1);                  //导航选择
			$userinfo['username'] = $user_info[2]['corpname_cn'];
			$this->assign('mid',$_SESSION["mid"]);
			$this->assign('userinfo',$userinfo);
			$this->assign('pagetitle',"展商胸卡修改 ");
			$this->display();
		}

	}
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，展商胸卡删除
    +----------------------------------------------------------
    */
    public function offlineexBadgeDel()
    {
		$user_info = $this->login_check();
		$offlineex_status = $this->offlineexStatus();        //线下展会初始状态信息检测及获取
		
		if($offlineex_status == 0){
			$this->assign('memberMsg',"您目前没有有效的线下展会参展记录，不能操作此项功能！");
			$this->display('memberMsg');
		}else{
			$Offlineex_badge_obj = M("offlineex_badge");         //实例化offlineex对象
	
			if(!empty($_GET['id'])){
				$delres = $Offlineex_badge_obj->where('id = '.$_GET['id'])->delete();
				$this->redirect('offlineexBadge');
			}else{
				$this->success('非法操作！');
			}
		}
	}
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，在线提名贵宾观众
    +----------------------------------------------------------
    */
    public function offlineexVIPVisitor()
    {
		$user_info = $this->login_check();
		$offlineex_status = $this->offlineexStatus();        //线下展会初始状态信息检测及获取
		
		//通用信息传递
		$this->assign('flag',1);  //导航选择
		$this->assign('pagetitle',"在线提名贵宾观众");
		
		if($offlineex_status == 0){
			$this->assign('memberMsg',"您目前没有有效的线下展会参展记录，不能操作此项功能！");
			$this->display('memberMsg');
		}else{
			$Offlineex_vipvisitor_obj = M("offlineex_vipvisitor");         //实例化offlineex_vipvisitor对象
			
			if($_POST["submit"]){
				$data['epid']        = $offlineex_status['epid'];
				$data['oeid']        = $offlineex_status['id'];
				$data['name'] 	     = Input::getVar($_POST["name"]);
				$data['duties'] 	 = Input::getVar($_POST["duties"]);
				$data['department']	 = Input::getVar($_POST["department"]);
				$data['corpname'] 	 = Input::getVar($_POST["corpname"]);
				$data['corpaddress'] = Input::getVar($_POST["corpaddress"]);
				$data['zipcode'] 	 = Input::getVar($_POST["zipcode"]);
				$data['phone'] 	     = Input::getVar($_POST["phone"]);
				$data['mobile'] 	 = Input::getVar($_POST["mobile"]);
				$data['email'] 	     = Input::getVar($_POST["email"]);
				
				$data['cTime'] 		 = time();
				$data['uTime'] 		 = time();
				
				if($data['name'] != '' && $data['corpname'] != '' && $data['corpaddress'] != '' && $data['phone'] != '' && $data['email'] != ''){			
					$res = $Offlineex_vipvisitor_obj->add($data);
					
					if($res){
						$this->redirect('offlineexVIPVisitor');
					}else{
						$this->success('操作失败，请重试，或咨询客服人员！');	
					}
				}else{
					$msg  = $data['name'] != '' ? '' : '姓名不能为空！ ';
					$msg .= $data['corpname'] != '' ? '' : '公司名称不能为空！ ';
					$msg .= $data['corpaddress'] != '' ? '' : '通讯地址不能为空！ ';
					$msg .= $data['phone'] != '' ? '' : '电话不能为空！ ';
					$msg .= $data['email'] != '' ? '' : '电子邮箱不能为空！ ';
					$this->success($msg);
				}
				
			}else{
				$offlineex_vipvisitor = $Offlineex_vipvisitor_obj->where('oeid = '.$offlineex_status['id'])->order('cTime asc')->select();
				$n = 1;
				foreach ($offlineex_vipvisitor as $value){
					$value['num'] = $n;
					$n++;
					$vipvisitor[] = $value;
				}
				
				$this->assign('vipvisitor',$vipvisitor);
				$this->display();
			}
		}
	}
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，在线提名贵宾观众 删除
    +----------------------------------------------------------
    */
    public function offlineexVIPVisitorDel()
    {
		$user_info = $this->login_check();
		$offlineex_status = $this->offlineexStatus();        //线下展会初始状态信息检测及获取
		
		if($offlineex_status == 0){
			$this->assign('memberMsg',"您目前没有有效的线下展会参展记录，不能操作此项功能！");
			$this->display('memberMsg');
		}else{
			$Offlineex_vipvisitor_obj = M("offlineex_vipvisitor");         //实例化offlineex_vipvisitor对象
	
			if(!empty($_GET['id'])){
				$delres = $Offlineex_vipvisitor_obj->where('id = '.$_GET['id'])->delete();
				$this->redirect('offlineexVIPVisitor');
			}else{
				$this->success('非法操作！');
			}
		}
	}
	
	/**
    +----------------------------------------------------------
    * 企业会员中心 - 线下展会，参展资料下载
    +----------------------------------------------------------
    */
    public function offlineexDown()
    {
		$user_info = $this->login_check();
		
		$this->assign('flag',1);   //导航选择
		$this->assign('pagetitle',"参展资料下载 ");
		$this->display();
	}
	
	



	
	
	
	
	/*--------------------- 询盘模块 梁喜峰 --------------------------*/
	/**
    +----------------------------------------------------------
    * 询盘管理收件箱显示
    +----------------------------------------------------------
    */
    public function consultingInbox(){
    	$user_info			  = $this->login_check();
    	$consult_list 		  = A('Consulting');					//远程调用Consulting咨询控制器下的consultManage咨询列表方法
    	$consultlist_receiver = $consult_list->consultManage(2);	//接收方信息   

    	$this->assign('conreceiver',$consultlist_receiver);   	
		$userinfo['username'] = $user_info[2]['corpname_cn'];
		$this->assign('mid',$_SESSION["mid"]);
		$this->assign('userinfo',$userinfo);
		$this->assign('pagetitle','询盘管理 - 收件箱');
    	$this->display();
    	
    }
    /**
    +----------------------------------------------------------
    * 询盘管理发件箱显示
    +----------------------------------------------------------
    */   
    public function consultingOutbox(){
    	$user_info = $this->login_check();
    	$consult_list 		  = A('Consulting');					//远程调用Consulting咨询控制器下的consultManage咨询列表方法
    	$consultlist_send 	  = $consult_list->consultManage(1);	//发送方信息
		$this->assign('consend',$consultlist_send);
    	$this->assign('pagetitle','询盘管理 - 发件箱');
    	$this->display();
    }
    /**
    +----------------------------------------------------------
    * 询盘具体内容页显示
    +----------------------------------------------------------
    */
    public function consultingDetail(){
    	$user_info    = $this->login_check();
    	$consult_info = A('Consulting');					//实例化Consulting在线咨询控制器类
    	$consulting   = $consult_info->consultDetail(1);    //咨询主表信息
    	$consultreply = $consult_info->consultDetail();    //咨询回复表信息   	
        $this->assign('consulting',$consulting);
        $this->assign('consultreply',$consultreply);
		$this->assign('mid',$_SESSION["mid"]);
		$userinfo['username'] = $user_info[2]['corpname_cn'];
		$this->assign('userinfo',$userinfo);
		//$this->assign('pagetitle',$consulting['sendtitle'] .'-'.  );
    	$this->display();
    	
    }
    
    /**
    +----------------------------------------------------------
    * 询盘信息回复
    +----------------------------------------------------------
    */
    public function consultingReply(){
    	$user_info = $this->login_check();
		$conreply = R('Consulting','consultReply');
		$this->assign('mid',$_SESSION["mid"]);
		$userinfo['username'] = $user_info[2]['corpname_cn'];
		$this->assign('userinfo',$userinfo);
    	$this->display();	
    }
    
    /**
    +----------------------------------------------------------
    * 询盘信息删除
    +----------------------------------------------------------
    */
    public function consultingDel(){
    	$user_info = $this->login_check();
		$conreply = R('Consulting','consultDel');
		$this->assign('mid',$_SESSION["mid"]);
		$userinfo['username'] = $user_info[2]['corpname_cn'];
		$this->assign('userinfo',$userinfo);
    	$this->display();	
    }
	
	
	
	
	/*--------------------- 公用方法 --------------------------*/
	/**
    +----------------------------------------------------------
    * 验证企业用户登录状态[前台会员服务中心访问权限管理]
    +----------------------------------------------------------
    */
	public function login_check(){
		if(!empty($_SESSION["mid"])){
			
			if($_SESSION["mtype"] == 1){
				$Member_user_obj = M("corp_user");        //实例化企业用户对象
			}else if($_SESSION["mtype"] == 2){
				$Member_user_obj = M("personal_user");    //实例化个人用户对象	
			}		
			$row = $Member_user_obj->where('status = 1 AND id = "'.$_SESSION["mid"].'"')->find();
			$us = is_array($row);
			$shell = $us ? $_SESSION["member_shell"] == md5($row["account"].$row["password"].MEMBER_PS) : FALSE;

			if($shell){
				$Exhibitors_obj = M("exhibitors");         //实例化企业网上参展服务基础类
				$Corp_baseinfo_obj = M("corp_baseinfo");   //实例化企业基本信息类
				$row_ex = $Exhibitors_obj->where('status = 1 AND uid = '.$row["id"])->find();
				$row_baseinfo = $Corp_baseinfo_obj->where('status = 1 AND id = '.$row["bid"])->find();
				
				//语言版本选择处理
				if($_SESSION["lang"] == 2){
					require 'lang/en.inc.php';        //引入英文语言包
				}else{
					require 'lang/zh.inc.php';        //引入中文语言包
				}
				$this->assign('lang',$langarray);	
				$this->assign('today',date('Y年n月j日',time()));
				$this->assign('account',$row["account"]);
				$this->assign('corpname',$row_baseinfo["corpname_cn"]);
				$this->assign('closeex',1);
				return array($row["id"],$row_ex,$row_baseinfo,$row);
			}else{
				$this->assign('jumpUrl',"__APP__/member/login");
				$this->success('您无权访问，请先登录！');
				exit();
			}	
		}else{
			$this->assign('jumpUrl',"__APP__/member/login");
			$this->success('您还未登录，请先登录！');
			exit();			
		}
	}
	
	/**
    +----------------------------------------------------------
    * 验证用户登录状态[前台通用访问权限管理]
    +----------------------------------------------------------
    */
	public function public_check(){
		if(!empty($_SESSION["mid"])){
			
			if($_SESSION["mtype"] == 1){
				$Member_user_obj = M("corp_user");        //实例化企业用户对象			
			}else if($_SESSION["mtype"] == 2){
				$Member_user_obj = M("personal_user");    //实例化个人用户对象			
			}
			
			$row = $Member_user_obj->where('status = 1 AND id = "'.$_SESSION["mid"].'"')->find();
			$us = is_array($row);
			$user_account = $_SESSION["mtype"] == 1 ? $row["account"] : $row["email"];
			$shell = $us ? $_SESSION["member_shell"] == md5($user_account.$row["password"].MEMBER_PS) : FALSE;
				
			if($shell){
				$Exhibitors_obj = M("exhibitors");         //实例化企业参展服务基础类
				$Corp_baseinfo_obj = M("corp_baseinfo");   //实例化企业基本信息类
				$row_ex = $Exhibitors_obj->where('status = 1 AND uid = '.$row["id"])->find();
				$row_baseinfo = $Corp_baseinfo_obj->where('status = 1 AND id = '.$row["bid"])->find();
			
				//数组形式返回需要的信息，用户类型、登录账号、名称、服务类型、服务级别等；
				$userinfo['mtype']    = $_SESSION["mtype"];
				$userinfo['account']  = $row["account"];
				$userinfo['username'] = $_SESSION["mtype"] == 1 ? $row_baseinfo['corpname_cn'] : $row['email'];
				$userinfo['exlevel']  = $row_ex['level'];
				$userinfo['vslevel']  = '';

				return $userinfo;
			}else{
				$this->assign('jumpUrl',"__APP__/member/login");
				$this->success('您无权访问，请先登录！');
				exit();
			}
		}
	}
	

}
?>
