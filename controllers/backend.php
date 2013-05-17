<?php

class backend
{

	public $requires_auth = TRUE;

	function index()
	{
		global $request;
		global $_user;
		$this->scripts[] = 'backend.js';
		$products = get_all("SELECT * FROM product NATURAL JOIN `group` WHERE deleted=0");
		$group_names = get_all("SELECT group_name FROM `group` WHERE deleted=0");
		$result = q("UPDATE product_spec SET cpu_speed=null WHERE product_id=1");
		require 'views/master_view.php';
	}

	function add()
	{
		global $request;
		if (isset($_POST['product_name'])) {
			$product_name = $_POST['product_name'];
			$group_id = $_POST['group_id'];
			$product_id = q("INSERT INTO product SET name='$product_name', group_id='$group_id'");
			$product_id_image = q("INSERT INTO image SET product_id='$product_id'");
			$product_id_more_info = q("INSERT INTO product_more_info SET product_id='$product_id'");
			$product_id_spec = q("INSERT INTO product_spec SET product_id='$product_id'");
			echo $product_id > 0 ? $product_id : $product_id;
			exit();
		}
	}

	function edit()
	{
		global $request;
		$this->scripts[] = 'backend_edit.js';
		$product_id = $request->params[0];
		$product_info = get_all(
			"SELECT * FROM product NATURAL JOIN `group` NATURAL JOIN product_more_info NATURAL JOIN image WHERE product_id='$product_id'"
		);
		if (! empty($product_info)) {
		$product_info = $product_info[0];
		}
		$specs = get_all("SELECT * FROM product_spec WHERE product_id='$product_id'");

		if (! empty($specs)) {
			$specs = $specs[0];
			foreach ($specs as $key => $spec) {
				unset($specs[$key]);
				$specs[ucfirst($key)] = $spec;
				if ($spec == NULL) {
					unset($specs[ucfirst($key)]);
				}
			}
		}
		$group_names = get_all("SELECT group_name, group_id FROM `group` WHERE deleted=0");
		$products_spec = get_all("SELECT * FROM product_spec");
		$products_spec = $products_spec[0];
		foreach ($products_spec as $key => $value) {
			unset($products_spec[$key]);
			$products_spec[ucfirst($key)] = $value;
		}
		require 'views/master_view.php';
	}

	function remove()
	{
		global $request;
		$id = $request->params[0];
		$result = q("UPDATE product SET deleted=1 WHERE product_id='$id'");
		require 'views/master_view.php';
	}
	function remove_specification()
	{
		global $request;
		$id = $request->params[0];
		if (isset($_POST)){
			$product_id = $_POST['id'];
			$product_id = strtolower(str_replace(' ', '_', $product_id));
		}
		$result = q("UPDATE product_spec SET $product_id=null WHERE product_id='$id'");
		if ($result==0){
			$result = 1;
		}
		require 'views/master_view.php';
	}
}