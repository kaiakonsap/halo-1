<?php

class products {
	function index(){
		global $request;
		$this->scripts[]='products.js';
		if (isset($_POST['id'])){
			$group_id = $_POST['id'];
			if ($group_id==0){
				$products = get_all("SELECT * FROM product NATURAL JOIN `group` NATURAL JOIN image WHERE deleted=0");
				$products = json_encode($products, true);
				ob_end_clean();
				exit($products);
			} else {
				$products = get_all("SELECT * FROM product NATURAL JOIN `group` NATURAL JOIN image WHERE group_id='$group_id' AND deleted=0");
				$products = json_encode($products, true);
				ob_end_clean();
				exit($products);
			}
		}
		$groups = get_all("SELECT * FROM `group`");

		// Lisa All groups loetellu
		array_unshift($groups, array('group_id'=>0, 'group_name'=>"All"));
		$products = get_all("SELECT * FROM product NATURAL JOIN `group` NATURAL JOIN image WHERE deleted=0");
		require 'views/master_view.php';
	}
	function view(){
		global $request;
		$this->scripts[]='products_view.js';
		$id = $request->params[0];
		$products = get_all("SELECT * FROM product WHERE product_id='$id'");
		$products = $products[0];
		$products_spec = get_all("SELECT * FROM product_spec WHERE product_id='$id'");
		$products_spec = $products_spec[0];
		$products_spec = array_filter($products_spec);
		//$products_spec = array_change_key_case($products_spec, MB_CASE_UPPER);
		foreach ($products_spec as $key=>$value){
			unset($products_spec[$key]);
			$products_spec[ucfirst($key)] = $value;
		}
		$more_info = get_all("SELECT * FROM product_more_info WHERE product_id='$id'");
		$more_info = $more_info[0];
		require 'views/master_view.php';
	}
}