<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class ferris extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('activity_model');
	}
 
	public function edit() {
		if(isset($_POST['dosubmit'])){

 			$id = intval($_GET['activity_id']);
			if($id < 1) return false;
			if(!is_array($_POST['info']) || empty($_POST['info'])) return false;
			$info = new_addslashes($_POST['info']);
			$this->db->update($info, array('id'=>$id));

			//更新附件状态
			if(pc_base::load_config('system','attachment_stat')) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				if($_POST['info']['banner'])
					$this->attachment_db->api_update($_POST['info']['banner'],'enterprise-'.$id,1);
				if($_POST['info']['cooperation'])
					$this->attachment_db->api_update($_POST['info']['cooperation'],'enterprise-'.$id,1);
				if($_POST['info']['cooperation_plan'])
					$this->attachment_db->api_update($_POST['info']['cooperation_plan'],'enterprise-'.$id,1);
			}
			showmessage(L('operation_success'), HTTP_REFERER);
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			
			//解出内容
			$info = $this->db->get_one(array('id'=>$_GET['activity_id']));
			if(!$info) showmessage('数据不存在');

			$info = new_stripslashes($info);
			extract($info); 

 			include $this->admin_tpl('ferris_edit');
		}

	}
}
?>