var product_id = 0;
function verify_specification() {
	var fail = 0;
	var selected = $('#product_spec_select option:selected').val();
	$('#product_spec tbody').find('tr').each(function () {
		console.log($(this).find('th').html());
		if (selected == $(this).find('th').html()) {
			alert('specification already exists');
			fail = 1;
			return false;
		}
	});
	if (fail) {
		return false;
	} else {
		selected_ = selected.replace(/ /g, '_');
		var html = '<input id="' + selected + '" type="text">';
		var ylakoma = "'";
		$('#product_spec').append('<tr id="product_'+selected_+'"><th>' + selected + '</th><td>' + html + '</td><td><a href="#"' +
			'onclick="if (!confirm('+ylakoma+'Are you sure?'+ylakoma+')) return false;' +
			'remove_specification_ajax('+ ylakoma + selected_ + ylakoma + ', '+ ylakoma + product_id + ylakoma+');return false' +
			'"><i class="icon-trash"></i>Remove</a></td></tr>');
	}
}
function remove_specification_ajax(id, product_id) {
	$.post(BASE_URL + "backend/remove_specification/" + product_id, {id: id})
		.done(function (data) {
			if (data == 'OK') {
				alert('product_'+id);
				$('#product_spec > tbody > tr#product_' + id).remove();
				alert("Specification deleted!");
			}
			else {
				alert("Error!\n\nServer said: '" + data + "'.\n\nContact developer. ");
			}
		});
}
function submit(){
	var product_specs = {};
	var product_id = $('input[type=hidden]#product_id').val();
	product_specs[product_id] = {};
	$('#product_spec').find('tr').each(function(){
		var spec_id = $(this).attr('id');
		var spec_id_sub = toLowerCase(spec_id.substring(8));
		product_specs[product_id][spec_id_sub] = $(this).find('td:nth-child(0) input');
	});
	var json_text = JSON.stringify(product_specs, null);
	$('input[type=hidden]#product_spec').val(json_text);
	$('#product_info').submit();
}
$(function () {
	product_id = $('input[type=hidden]#product_id').val();
});
