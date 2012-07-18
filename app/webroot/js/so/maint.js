var isIE = false;

$(function() {
	if (navigator.userAgent.indexOf('MSIE') !=-1) {
		isIE = true;
	}
	
	$('input[name*="[prod_cd]"]').change(function() {
		getProd(this);
	});
	
	$('#SoCustCd').blur(function() {
		if ($(this).val()) {
			$.getJSON(webroot + 'customers/searchByCustCd?cd=' + $(this).val(), 
				function(data) {
					if (data != null) {
						$('#CustomerName').val(data.Customer.name);
						$('#custNoErrMsg').html('');
					}
					else {
						$('#CustomerName').val('');
						$('#custNoErrMsg').html('Not exists');
					}
				}
			);
		}
	});
	
	$('#saveBtn').click(function(){
		if (confirm('Are you sure to save?')) {
			$('#saveFrom').submit();
		}
	});
});

var cache = {}, lastXhr;
function initAutoCOmplete(elem, idx) {
	$(elem).autocomplete({
		source: function( request, response ) {
		var term = request.term;
		if ( term in cache ) {
			response( cache[ term ] );
			return;
		}

		lastXhr = $.getJSON( webroot + "products/searchList", request, function( data, status, xhr ) {
			cache[ term ] = data;
			if ( xhr === lastXhr ) {
				response( data );
			}
		});
	},
	select: function(event, ui) {
		fromList = true;
		getProduct(idx, ui.item.id);
	}
});
}

function getProd(item) {
	idx = $(item).attr('name').substring(15);
	idx = idx.substring(0, idx.indexOf(']'));
	getProduct(idx, $(item).val());
}

function getProduct(idx, prodCd) {
	$.getJSON(webroot + 'products/searchByProdCd?cd=' + prodCd, 
		function(data) {
			if (data && data != null) {
				$('#SoDetail' + idx + 'ProductProductName').val(data.Product.product_name);
				$('#SoDetail' + idx + 'UnitPrice').val(data.Product.product_cus_price);
				$('#SoDetail' + idx + 'Cost').val(data.Product.product_cost_rmb);
				$('#SoDetail' + idx + 'Discount').val(0);
				$('#SoDetail' + idx + 'Qty').val(1);
			}
			else {
				$('#SoDetail' + idx + 'ProductProductName').val('');
				$('#SoDetail' + idx + 'UnitPrice').val('');
				$('#SoDetail' + idx + 'Cost').val('');
				$('#SoDetail' + idx + 'Discount').val('');
				$('#SoDetail' + idx + 'Qty').val('');
				
			}
			calPrice($('#SoDetail' + idx + 'Qty'));
		}
	);
}

function addRow(elem) {
	$(elem).unbind('focus');
	last_idx = row_idx;
	row_idx = row_idx + 1;
	
	// Add new row
	$('#table').append('<div class="row_detail">' + $(elem).parent().parent().parent().html() + '</div>');
	
	// Renew row number
	$("#table .row_detail:last .grid_1:first").html(row_idx + 1);

	if (!isIE) {
		// Rename input's name and id
		var childElem = $("#table .row_detail:last").children('div');
		for (var i = 0; i < childElem.length; i++) {
			var inputElem = $(childElem[i]).children().children()[0];
			if (inputElem && inputElem.hasOwnProperty('name')) {
				inputElem.name = inputElem.name.replace(last_idx, row_idx);
				inputElem.id = inputElem.id.replace(last_idx, row_idx);
			}
		}
		// Rename dropdown (7th element)
		var inputElem = $(childElem[7]).children()[0];
		if (inputElem && inputElem.hasOwnProperty('name')) {
			inputElem.name = inputElem.name.replace(last_idx, row_idx);
			inputElem.id = inputElem.id.replace(last_idx, row_idx);
		}
	}
	else {
		// For IE (IE not support hasOwnProperty)
		// Rename input's name and id
		var childElem = $("#table .row_detail:last").children('div');
		for (var i = 0; i < childElem.length; i++) {
			var inputElem = $(childElem[i]).children().children()[0];
			if (inputElem && 'name' in inputElem) {
				inputElem.name = inputElem.name.replace(last_idx, row_idx);
				inputElem.id = inputElem.id.replace(last_idx, row_idx);
				inputElem.value = '';
			}
		}
		// Rename dropdown (7th element)
		var inputElem = $(childElem[7]).children()[0];
		if (inputElem && 'name' in inputElem) {
			inputElem.name = inputElem.name.replace(last_idx, row_idx);
			inputElem.id = inputElem.id.replace(last_idx, row_idx);
		}
	}
	
	initAutoCOmplete($('#SoDetail' + row_idx + 'ProdCd'), row_idx);
	$('#SoDetail' + row_idx + 'ProdCd').focus(function() {
		addRow(this);
	});
	
	$('#SoDetail' + row_idx + 'ProdCd').change(function() {
		getProd(this);
	});
}

function calPrice(elem) {
	var container = $(elem).parent().parent().siblings(".grid_1");
	var idx = $(container).html() - 1;
	var qty = $('#SoDetail' + idx + 'Qty').val();
	var discount = $('#SoDetail' + idx + 'Discount').val();
	var unit_price = $('#SoDetail' + idx + 'UnitPrice').val();
	$('#SoDetail' + idx + 'Subtotal').val(qty * (unit_price - discount));

	calTotalPrice();
}

function calTotalPrice() {
	var total = 0;
	$("input[name*='subtotal']").each(function(index) {
		total = total + $(this).val()*1;
	});

	$('#SoTotalAmt').val("$" + total.toFixed(2));
}
