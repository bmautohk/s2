$(function() {
	$('#searchBtn').click(function() {
		search('form1');
		return false;
	});
	
	$('#resetBtn').click(function() {
		$('input[type=text]').val('');
	});
});

function search(formId) {
	$('#loading_div').show();
	$.ajax({
		url: 'searchForSelectCust',
		data: $('#' + formId).serialize(),
		success: function(data) {
			$('#loading_div').hide();
			$('#paging_div').html(data);
		}
	});
}

function goToPage(page) {
	if (page > 0) {
		$('#loading_div').show();
		$.ajax({
			url: 'searchForSelectCust',
			data: $('#criteriaForm').serialize() + '&page=' + page,
			success: function(data) {
				$('#loading_div').hide();
				$('#paging_div').html(data);
			}
		});
	}
}

function goSelect(custCd, name) {
	window.opener.document.getElementById('SoCustCd').value = custCd;
	window.opener.document.getElementById('CustomerName').value = name;
	self.close();
}

