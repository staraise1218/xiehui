<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class agenda extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('activity_agenda_model');
	}
	//首页
	public function init() {
		$show_header = $show_dialog = '';

		$where['activity_id'] = intval($_GET['activity_id']);

		$typename = $_GET['typename'];
		$infos = $this->db->listinfo($where, 'id asc');

		include $this->admin_tpl('agenda_list');
	}
	
	//添加
 	public function add() {
 		if(isset($_POST['dosubmit'])) {

			$data = $_POST['info'];
			$id = $this->db->insert($data, true);
			if(!$id) return FALSE; 
 			$siteid = $this->get_siteid();
	 		//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['info']['content']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['info']['content'], 'agenda-'.$id, 1);
			}
			showmessage(L('operation_success'), HTTP_REFERER, '', 'add');
		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			$activity_id = intval($_GET['activity_id']);

 			include $this->admin_tpl('agenda_add');
		}
	}
 
	public function edit() {
		if(isset($_POST['dosubmit'])){

 			$id = intval($_GET['id']);
			if($id < 1) return false;
			if(!is_array($_POST['info']) || empty($_POST['info'])) return false;
			$info = $_POST['info'];
			$this->db->update($info, array('id'=>$id));

			//更新附件状态
			if(pc_base::load_config('system','attachment_stat')) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				if($_POST['info']['banner'])
					$this->attachment_db->api_update($_POST['info']['banner'],'enterprise-'.$id,1);
				if($_POST['info']['minglu'])
					$this->attachment_db->api_update($_POST['info']['minglu'],'enterprise-'.$id,1);
				if($_POST['info']['cooperation'])
					$this->attachment_db->api_update($_POST['info']['cooperation'],'enterprise-'.$id,1);
				if($_POST['info']['cooperation_plan'])
					$this->attachment_db->api_update($_POST['info']['cooperation_plan'],'enterprise-'.$id,1);
			}
			showmessage(L('operation_success'),'?m=activity&c=exhibition&a=edit','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			
			//解出内容
			$info = $this->db->get_one(array('id'=>$_GET['id']));
			if(!$info) showmessage('数据不存在');

			$info = $info;
			extract($info); 

 			include $this->admin_tpl('agenda_edit');
		}

	}

	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$id = intval($id);
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}

	/**
	 * 删除
	 * @param	intval	$sid	友情链接ID，递归删除
	 */
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $id_arr) {
 					//批量删除友情链接
					$this->db->delete(array('id'=>$id_arr));
				}
				showmessage(L('operation_success'),'?m=activity&c=agenda&a=init&activity_id='.$_GET['activity_id']);
			}else{
				$id = intval($_GET['id']);
				if($id < 1) return false;
				//删除
				$result = $this->db->delete(array('id'=>$id));
				
				if($result){
					showmessage(L('operation_success'),'?m=activity&c=agenda&a=init&activity_id='.$_GET['activity_id']);
				}else {
					showmessage(L("operation_failure"),'?m=activity&c=agenda&a=init&activity_id='.$_GET['activity_id']);
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}

	public function recruitSelectEnterprise() {
		$show_header = $show_dialog = '';
		// 搜索

		$where = '';
		if(isset($_GET['keyword']) && $_GET['keyword'] != ''){
			$keyword = new_addslashes($_GET['keyword']);
			$where = "name like '%{$keyword}%'";
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where, $order = 'listorder desc, id desc', $page, 20);
		$pages = $this->db->pages;

		include $this->admin_tpl('enterprise_select_list');
	}
}
?>