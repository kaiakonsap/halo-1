function verify_specifications(){
	var fail=0;
		var selected = $('#product_spec_select option:selected').val();
		$('#product_spec tbody').find(tr).each(function(){
			console.log($(this).find('th').html());
			if (selected == $(this).find('tr').attr('id')){
				alert('specification exists');
				fail=1;
			}

		});

if(fail)
{
	return false;
}
	else{
	var html = '<input id="'+selected+'" type="text">'
	$('this').append('<tr><th>'+selected+'</th><td>'+html+'</td></tr>')
}

};
function remove_specification_ajax(id){
	$.post(BASE_URL + "backend/remove/" + id)
		.done(function(data){
			if(data == 'OK'){
				$('table#products_spec > tbody > tr#' + id).remove();
				alert("Specification deleted!");
			}
			else{
				alert("Error!\n\nServer said: '" + data + "'.\n\nContact developer. ");
			}
		});
}
