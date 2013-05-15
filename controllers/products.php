<?php

class products
{

	function index()
	{
		global $request;
		$this->scripts[] = 'products.js';
		if (isset($_GET['status']) == 'ok') {
			var_dump($_GET['status']);
			$bill_id = $_GET['makse_id'];
			//märgi andmebaasis see arve makstuks mille ID on $_POST['makse_ID']
			q("UPDATE bill SET paid = 1 WHERE bill_id='$bill_id'");
		}
		if (isset($_POST['id'])) {
			$group_id = $_POST['id'];
			if ($group_id == 0) {
				$products = get_all("SELECT * FROM product NATURAL JOIN `group` NATURAL JOIN image WHERE deleted=0");
				$products = json_encode($products, TRUE);
				ob_end_clean();
				exit($products);
			} else {
				$products = get_all(
					"SELECT * FROM product NATURAL JOIN `group` NATURAL JOIN image WHERE group_id='$group_id' AND deleted=0"
				);
				$products = json_encode($products, TRUE);
				ob_end_clean();
				exit($products);
			}
		}
		$groups = get_all("SELECT * FROM `group`");

		// Lisa All groups loetellu
		array_unshift($groups, array('group_id' => 0, 'group_name' => "All"));
		$products = get_all("SELECT * FROM product NATURAL JOIN `group` NATURAL JOIN image WHERE deleted=0");
		require 'views/master_view.php';
	}

	function view()
	{
		global $request;
		$this->scripts[] = 'products_view.js';
		$id = $request->params[0];
		$products = get_all("SELECT * FROM product WHERE product_id='$id'");
		$products = $products[0];
		$products_spec = get_all("SELECT * FROM product_spec WHERE product_id='$id'");
		if (!empty($products_spec)){
		$products_spec= $products_spec[0];
		$products_spec = array_filter($products_spec);}
		//$products_spec = array_change_key_case($products_spec, MB_CASE_UPPER);
		foreach ($products_spec as $key => $value) {
			unset($products_spec[$key]);
			$products_spec[ucfirst($key)] = $value;
		}
		$more_info = get_all("SELECT * FROM product_more_info WHERE product_id='$id'");
		if (!empty($more_info)){ $more_info= $more_info[0];
		$more_info = array_filter($more_info);}
		require 'views/master_view.php';
	}

	function buy()
	{
		global $request;
		// meil on olemas $request->params[0] mis on toote ID, nüüd tuleks andmebaasist välja võtta andmed, et saada name ja price
		$id = $request->params[0];
		$products = get_all("SELECT * FROM product WHERE product_id = '$id'");
		$products = $products[0];
		//nüüd on olemas toote andmed, loome uue arve andmebaasis (saame $bill_id, mis on mysql_insert_id
		//mille funktsioon q()annab meile )
		$date = date("Y-m-d");
		$due_date = date('Y-m-d', strtotime("+ 10 days"));
		$price = $products['price'];
		$bill_id = q("INSERT INTO bill SET product_id = '$id', total = '$price', `date` = '$date', due_date = '$due_date'");
		$billid = base64_encode($bill_id);
		$product_price = $products['price']; //antud ID'le vastava toote hind
		$pprice = base64_encode($product_price);
		$product_name = $products['name']; //antud ID'le vastava toote nimi
		$pname = base64_encode($product_name);
		//"poenimi ja "poearvelduskonto" tuleb lisada hard code'na
		$destination = "http://localhost/pank/index.php/pangalink/maksa/kaia.konsap@khk.ee/1145615685/$pprice/$billid/$pname/localhost/routerboard";
		header("Location: $destination");
	}
}