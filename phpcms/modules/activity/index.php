<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	function __construct() {
		pc_base::load_app_func('global');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);

  		$this->db = pc_base::load_model('activity_model');
  		$this->db_agenda = pc_base::load_model('activity_agenda_model');
  		$this->db_apply = pc_base::load_model('activity_apply_model');
  		$this->db_subscribe = pc_base::load_model('qikan_subscribe_model');
	}
	
	public function init() {


		include template('activity', $template_name);
	}

	// 展会介绍
	public function exhibition(){

		$types = array('bj', 'sh');

		$exhibition_type = new_addslashes($_GET['type']);
		
		if(!in_array($exhibition_type, $types)) return false;

		$activity_id = ($exhibition_type == 'bj') ? '2 ': '1';
		$catid = ($exhibition_type == 'bj') ? 9: 35;

		$info = $this->db->get_one(array('id'=>$activity_id));
		if(empty($info)) return false;
		// 议程活动
		$agendas = $this->db_agenda->select(array('activity_id'=>$activity_id));

		$info = new_stripslashes($info);
		extract($info);
		// seo
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('activity', 'exhibition', $default_style);
	}

	// 峰会论坛介绍
	public function forum(){

		$types = array('bj', 'sh');

		$forum_type = new_addslashes($_GET['type']);
		
		if(!in_array($forum_type, $types)) return false;

		$activity_id = ($forum_type == 'bj') ? '4 ': '3';
		$catid = ($forum_type == 'bj') ? 12: 36;

		$info = $this->db->get_one(array('id'=>$activity_id));
		if(empty($info)) return false;
		// 议程活动
		$agendas = $this->db_agenda->select(array('activity_id'=>$activity_id));

		$info = new_stripslashes($info);
		extract($info);
		// seo
		$SEO = seo(SITEID);

		$default_style = isMobile() ? 'mobile' : 'content';
		include template('activity', 'forum', $default_style);
	}

	// 摩天奖介绍
	public function ferris(){

		$activity_id = 5;
		$catid = 15;

		$info = $this->db->get_one(array('id'=>$activity_id));
		if(empty($info)) return false;

		$info = new_stripslashes($info);
		extract($info);
		// seo
		$SEO = seo(SITEID);
		
		$default_style = isMobile() ? 'mobile' : 'default';

		include template('activity', 'ferris', $default_style);
	}

	public function downfile(){
		$activity_id = $_GET['activity_id'];
		$info = $this->db->get_one(array('id'=>$activity_id), 'cooperation_plan');

		if($info['cooperation_plan'] == '') return false;

		$thefile = $info['cooperation_plan'];
		// if (isset($thefile)) 
        /*{ 
            Header("HTTP/1.1 303 See Other"); 
            Header("Location: $thefile"); 
            exit; 
        }*/
		$fileinfo = pathinfo($thefile);

		header('Content-type: application/'.$fileinfo['extension']);
		header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
		header('Content-Length: '.filesize($filename));
		readfile($thefile);
		exit();
	}

	// 参展
	public function exhibition_join (){

		if($_POST['dosubmit']){
			session_start();
			$data = new_addslashes($_POST['info']);
			// 检测验证码是否正确
			if( false == $this->checkMobileCode($data['contact_phone'], $_POST['code'], 1, $error)){
				showmessage($error);
			}
			$data['local_type'] = new_addslashes($_POST['exhibition_type']);
			$data['table_type'] = 'exhibition';

			$token = $_POST['__token__'];

			// 验证表单令牌
			if(empty($token) || $_SESSION['__token__'] != $token){
				showmessage('token验证失败');
			} else {
				token();
			}

			$insert_id = $this->db_apply->insert($data);
			if($insert_id){
				showmessage('报名成功', 'goback', 1000);
			} else {
				showmessage('服务器错误，请稍后再试');
			}
		} else {

			$SEO = seo(SITEID);

			$exhibition_type = $_GET['exhibition_type'];

			$default_style = isMobile() ? 'mobile' : 'content';
			include template('activity', 'exhibition_join', $default_style);
		}
	}

	// 论坛参会报名
	public function forum_join(){
		if($_POST['dosubmit']){
			$data = new_addslashes($_POST['info']);
			// 检测验证码是否正确
			if( false == $this->checkMobileCode($data['contact_phone'], $_POST['code'], 1, $error)){
				die(json_encode(array('code' => 400, 'msg'=> $error)));
			}
			// $data['local_type'] = new_addslashes($_POST['forum_type']);
			$data['local_type'] = input('post.forum_type');
			$data['table_type'] = 'forum';
			$order_sn = $this->generateOrdersn();
			$data['order_sn'] = $order_sn;
			$data['price'] = $data['is_member'] ? get_extend_setting('meeting_price_member') : get_extend_setting('meeting_price_nomember');

			// 新增的联系人
			$add_contact_name = new_addslashes($_POST['add_contact_name']);
			$add_position = new_addslashes($_POST['add_position']);
			$add_contact_phone = new_addslashes($_POST['add_contact_phone']);
			$add_email = new_addslashes($_POST['add_email']);

			$people_num = $add_contact_name ? count($add_contact_name) + 1 : 1;
			if($people_num > 1){
				foreach ($add_contact_name as $k => $item) {
					$other_conact[] = array(
						'add_contact_name' => $item,
						'add_position' => $add_position[$k],
						'add_contact_phone' => $add_contact_phone[$k],
						'add_email' => $add_email[$k],
					);
				}
				$data['other_contact'] = serialize($other_conact);
				$data['price'] = $data['price'] * $people_num;
			}

			$insert_id = $this->db_apply->insert($data);
			if($insert_id){
				die(json_encode(array('code' => 200, 'order_sn' => $order_sn, 'msg'=> '报名成功')));
			} else {
				die(json_encode(array('code' => 400, 'msg'=> '服务器错误，请稍后再试')));
			}
		} else {

			$forum_type = $_GET['forum_type'];

			$SEO = seo(SITEID);

			$default_style = isMobile() ? 'mobile' : 'content';
			include template('activity', 'forum_join', $default_style);
		}
	}


	function generateOrdersn(){
		$order_sn = null;
	    // 保证不会有重复订单号存在
	    while(true){
	        $order_sn = 'm'. date('YmdHis').rand(1000,9999); // 订单编号	 
	        $order_sn_count = $this->db_apply->count("order_sn = '".$order_sn."'");
	        if($order_sn_count == 0)
	            break;
	    }
	    
	    return $order_sn;
	}


	public function qikan_subscribe(){
		if($_POST['dosubmit']){
			$data = new_addslashes($_POST['info']);

			$insert_id = $this->db_subscribe->insert($data);
			if($insert_id){
				showmessage('订阅成功', 'close', 1000);
			} else {
				showmessage('服务器错误，请稍后再试');
			}
		} else {

			// seo
			$SEO = seo(SITEID);
			include template('activity', 'qikan_subscribe');
		}
	}

	// scene 1 活动报名 
	public function sendMobileCode(){
		$mobile = $_POST['mobile'];
        $scene = $_POST['scene'];

         // 检测发送次数
        $day_time_start = strtotime(date('Y-m-d'));
        $day_time_end = $day_time_start + 3600*24;

        $sms_log_model = pc_base::load_model('sms_log_model');
        $count = $sms_log_model->count("mobile=$mobile and add_time > $day_time_start and add_time < $day_time_end");

        if($count >= 10){
            die(json_encode(array('code'=>400, 'msg'=>'您的次数已超限')));
        }

        $code = rand(100000, 999999);
        $data = array(
            'mobile' => $mobile,
            'code' => $code,
            'scene' => $scene,
            'add_time' => time(),
        );

        $smsLogid = $sms_log_model->insert($data, true);

        // 执行短信网关发送 
        

        $rongliansms = pc_base::load_sys_class('rongliansms');
        $result = $rongliansms->sendTemplateSMS($mobile, array($code), 207012);
        if(empty($result)){
			die(json_encode(array('code'=>400, 'msg'=>'发送失败')));
		}elseif($result->statusReturn == false){
			if($result->statusCode == '160040'){
				die(json_encode(array('code'=>400, 'msg'=>'该电话号码今日获取验证码已达上限')));
			}else{
				die(json_encode(array('code'=>400, 'msg'=>'发送失败')));
			}
		}
		else{
			$sms_log_model = pc_base::load_model('sms_log_model');
			$sms_log_model->update(array('status'=>'1'), array('id'=>$smsLogid));
			die(json_encode(array('code'=>400, 'msg'=>'发送成功')));
			
		}
	}

	public function checkMobileCode($mobile, $code, $scene, &$error){
		$sms_log_model = pc_base::load_model('sms_log_model');
		$smsLog = $sms_log_model->get_one("mobile=$mobile and scene=$scene", 'code, add_time', 'id desc');

        if(!$smsLog){
            $error = '手机验证码错误';
            return false;
        }
        if($smsLog['code'] != $code){
            $error = '手机验证码错误';
            return false;
        }

        if(time() > ($smsLog['add_time'] + 300)){
            $error = '验证码已失效';
            return false;
        }
        return true;
	}
}