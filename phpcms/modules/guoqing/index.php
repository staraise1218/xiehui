<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
class index {
	private $db;
	function __construct() {
		$this->db = pc_base::load_model('guoqing_model');
		/*$this->_userid = param::get_cookie('_userid');
		$this->_username = param::get_cookie('_username');
		$this->_groupid = param::get_cookie('_groupid');*/
	}

	//首页
	public function init() {
		// 获取所有的经纬度坐标
		$list = $this->db->select("longitude != '' and latitude != ''", 'longitude, latitude');
		$list = json_encode($list);

		include template('guoqing','index', 'mobile');
	}
}
?>