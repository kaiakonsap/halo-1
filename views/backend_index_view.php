<a href="#" id="add_product" style="margin: 30px" class="btn btn-primary btn-large">Add new product</a>
<select id="groups" onchange="change_group()">
	<? if (isset($group_names)) : foreach ($group_names as $group_name) :?>
	<option id="<?=$group_name['group_name']?>"><?=$group_name['group_name']?></option>
	<? endforeach; endif ?>
</select>
<table id="products_table" class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>Product</th>
		<th>Group</th>
		<th>Price</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<? if (isset($products)) : foreach ($products as $product) :?>
	<tr id="product<?=$product['product_id']?>">
		<td><?=$product['name']?></td>
		<td><?=$product['group_name']?></td>
		<? if ($product['price']==null){ ?>
		<td>hind puudub</td><? } else {?>
		<td>$ <?=$product['price']?></td>
		<? } ?>
		<td><a href="<?=BASE_URL?>backend/edit/<?=$product['product_id']?>"><i class="icon-pencil"></i>Change</a>
			<a href="#"
			   onclick="if (!confirm('Are you sure?')) return false;
				   remove_product_ajax(<?=$product['product_id']?>);return false
				   "><i class="icon-trash"></i>Remove</a>
		</td>
	</tr>
	<? endforeach; endif ?>
	</tbody>
</table>