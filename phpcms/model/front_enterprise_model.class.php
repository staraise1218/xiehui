<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class front_enterprise_model extends model {
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'app';
		$this->table_name = 'front_enterprise';
		parent::__construct();
	}
}
?>