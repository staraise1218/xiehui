	function file($field, $value) {
		extract(string2array($this->fields[$field]['setting']));
		$list_str = array();
		if($value){
			$value_arr = explode('|',$value);
			$fileurl = $value_arr['0'];
			if($fileurl) {
				
				return $fileurl;
			}
		} 
	}
