<?php

class backend {
	public $requires_auth = true;
	function index(){
		global $request;
		global $_user;
		$this->scripts[]='backend.js';
		$products = get_all("SELECT * FROM product NATURAL JOIN `group` WHERE deleted=0");
		$group_names = get_all("SELECT group_name FROM `group` WHERE deleted=0");
		require 'views/master_view.php';
	}
	function add(){
		global $request;
		if (isset($_POST['product_name'])){
			$product_name = $_POST['product_name'];
			$group_id = $_POST['group_id'];
			$product_id = q("INSERT INTO product SET name='$product_name', group_id='$group_id'");
			echo $product_id>0 ? $product_id : $product_id;
			exit();
		}
	}
	function edit(){
		global $request;
		$this->scripts[] = 'backend_edit.js';
		$product_id = $request->params[0];
		$product_info = get_all("SELECT * FROM product NATURAL JOIN `group` NATURAL JOIN product_more_info NATURAL JOIN image WHERE product_id='$product_id'");
		$product_info = $product_info[0];
		$specs = get_all("SELECT * FROM product_spec WHERE ");
		$specs = $specs[0];
		if (!empty($specs)){
	array_filter($specs);
			if($specs[$key]==null){
				foreach($specs as $key->$specs){
				unset ($specs[$key]);}
			}
			$specs[ ucfirst($key)]=$spec;
		}

		$group_names = get_all("SELECT group_name, group_id FROM `group` WHERE deleted=0");
		require 'views/master_view.php';
	}
	function remove(){
		global $request;
		$id = $request->params[0];
		$result = q("UPDATE product SET deleted=1 WHERE product_id='$id'");
		require 'views/master_view.php';
	}
}