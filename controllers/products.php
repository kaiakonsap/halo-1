<?php

class products {
	function index(){
		global $request;
		$groups=get_all("SELECT * FROM `group`");
		array_unshift($groups,array('group_id'=>0,'group_name'=>'All'));
		require 'views/master_view.php';
	}
}