$(function()
{
	$('#product_spec_select').bind('change',function(event)
	{
		var selected=$('#product_spec_select option:selected'.attr('value');
		var html=<input id="product_'+selected+'" type="text">'
		$('#product_spec_select')

	)
	});
})