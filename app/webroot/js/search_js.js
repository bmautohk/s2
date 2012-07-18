$(function() {
	$('#searchBtn').click(function() {
		search('form1');
		return false;
	});
	
	$('#resetBtn').click(function() {
		$('input[type=text]').val('');
	});
	
	$('#cvsBtn').click(function() {
		$('#form1').attr('action', 'genCVS');
		$('#form1').submit();
	});
});

function search(formId) {
	$('#loading_div').show();
	$.ajax({
		url: 'search',
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
			url: 'search',
			data: $('#criteriaForm').serialize() + '&page=' + page,
			success: function(data) {
				$('#loading_div').hide();
				$('#paging_div').html(data);
			}
		});
	}
}

function genpdf(id) {
	window.open('genPdf/'+id,'pdf','width=1000,height=800');
}

