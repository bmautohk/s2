$(function() {
	$('#searchBtn').click(function() {
		$('#loading_div').show();
		$.ajax({
			url: '../so/searchSoDetailBySoId?so_id=' + $('#InvoiceSellOrderId').val(),
			success: function(data) {
				$('#loading_div').hide();
				$('#detail_div').html(data);
				
				if (data) {
					$('#InvoiceCustCd').val($('#custCd').val());
					$('#CustomerName').val($('#custName').val());
				}
				else {
					$('#InvoiceCustCd').val('');
					$('#CustomerName').val('');
				}
			}
		});
	});
	
	$('#InvoiceCustCd').blur(function() {
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
		else {
			$('#CustomerName').val('');
		}
	});
	
	if (action == 'create' && $('#InvoiceSellOrderId').val() != '') {
		$('#searchBtn').click();
	}
});

function calPrice(elem) {
	var container = $(elem).parent().parent().siblings(".grid_1");
	var idx = $(container).html() - 1;
	

	var sumAvailActQty = $('#InvoiceDetail' + idx + 'SumAvailActQty').val();
	var qty = $('#InvoiceDetail' + idx + 'Qty').val();
	var discount = $('#InvoiceDetail' + idx + 'Discount').val();
	var unit_price = $('#InvoiceDetail' + idx + 'UnitPrice').val();
	$('#InvoiceDetail' + idx + 'Subtotal').val(qty * (unit_price - discount));
	
	// Update avail. qty
	$('#InvoiceDetail' + idx + 'AvailQty').val(sumAvailActQty - qty);

	calTotalPrice();
}

function calTotalPrice() {
	var total = 0;
	$("input[name*='subtotal']").each(function(index) {
		total = total + $(this).val()*1;
	});

	$('#InvoiceTotalAmt').val("$" + total.toFixed(2));
}
