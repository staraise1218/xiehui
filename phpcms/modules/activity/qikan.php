<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class qikan extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('qikan_subscribe_model');
	}
	//首页
	public function init() {
		$show_header = $show_dialog = '';


		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$limit = 20;
		$infos = $this->db->listinfo('', $order = 'id desc', $page, $limit);
		$pages = $this->db->pages;

		include $this->admin_tpl('subscribe_list');
	}
 
	public function details() {


		$show_validator = $show_scroll = $show_header = true;
		pc_base::load_sys_class('form', '', 0);
	
		//解出内容
		$info = $this->db->get_one(array('id'=>$_GET['id']));
		if(!$info) showmessage('数据不存在');
		extract($info); 

		include $this->admin_tpl('subscribe_details');


	}
}