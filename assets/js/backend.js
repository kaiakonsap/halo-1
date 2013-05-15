$(document).ready(function () {
	$('#add_product').click(function () {
		var elem = $(this).closest('#confirmOverlay');
		$.confirm({
			'title'  : "Add new product's name:",
			'buttons': {
				'Save': {
					'class' : 'blue',
					'action': function add() {
						return $.ajax({
							type    : 'POST',
							dataType: 'html',
							data    : {product_name: $('input[name="product_name"]').val(), group_id: 1 },
							url     : BASE_URL + 'backend/add',
							complete: function (data) {
								console.log(data);
								if (!isNaN(data.responseText) && data.responseText > 0) {
									window.location = BASE_URL + 'backend/edit/' + data.responseText
								}
								else {
									alert("Error" + ' ' + data.responseText)
								}
							}
						})
					}
				},
				'Cancel'   : {
					'class' : 'gray',
					'action': function () {
					}
					// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});

	});
});

(function ($) {
	$.confirm = function (params) {
		if ($('#confirmOverlay').length) {
			// A confirm is already shown on the page:
			return false;
		}
		var buttonHTML = '';
		$.each(params.buttons, function (name, obj) {
			// Generating the markup for the buttons:
			buttonHTML += '<a href="#" class="button ' + obj['class'] + '">' + name + '<span></span></a>';
			if (!obj.action) {
				obj.action = function () {
				};
			}
		});
		var markup = [
			'<div id="confirmOverlay">',
			'<div id="confirmBox">',
			'<h1>', params.title, '</h1>',
			'<center><input style="margin-top: 20px" name="product_name" type="text"></center>',
			'<p>', params.message, '</p>',
			'<div id="confirmButtons">',
			buttonHTML,
			'</div></div></div>'
		].join('');
		$(markup).hide().appendTo('body').fadeIn();
		var buttons = $('#confirmBox .button'),
			i = 0;
		$.each(params.buttons, function (name, obj) {
			buttons.eq(i++).click(function () {
				obj.action();
				$.confirm.hide();
				return false;
			});
		});
	};

	$.confirm.hide = function () {
		$('#confirmOverlay').fadeOut(function () {
			$(this).remove();
		});
	};

})(jQuery);
function remove_product_ajax(id){
	$.post(BASE_URL + "backend/remove/" + id)
		.done(function(data){
			if(data == 'OK'){
				$('table#products_table > tbody > tr#product' + id).remove();
				alert("Product deleted!");
			}
			else{
				alert("Error!\n\nServer said: '" + data + "'.\n\nContact developer. ");
			}
		});
}
