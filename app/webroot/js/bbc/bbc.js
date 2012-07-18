function search() {
	if ($('#cust_cd').val() == '') return;
	
	var arComplete = false;
	var apComplete = false;
	$('#loading_div').show();
	$.ajax({
		url: 'search_ar',
		data: 'cust_cd=' + $('#cust_cd').val(),
		success: function(data) {
			arComplete = true;
			if (apComplete) {
				$('#loading_div').hide();
			}
			$('#paging_div_ar').html(data);
		}
	});

	$.ajax({
		url: 'search_ap',
		data: 'cust_cd=' + $('#cust_cd').val(),
		success: function(data) {
			apComplete = true;
			if (arComplete) {
				$('#loading_div').hide();
			}
			$('#loading_div').hide();
			$('#paging_div_ap').html(data);
		}
	});
}

function goToPage_ar(page) {
	if (page > 0) {
		$('#loading_div').show();
		$.ajax({
			url: 'search_ar',
			data: $('#criteriaForm_ar').serialize() + '&page=' + page,
			success: function(data) {
				$('#loading_div').hide();
				$('#paging_div_ar').html(data);
			}
		});
	}
}

function goToPage_ap(page) {
	if (page > 0) {
		$('#loading_div').show();
		$.ajax({
			url: 'search_ap',
			data: $('#criteriaForm_ap').serialize() + '&page=' + page,
			success: function(data) {
				$('#loading_div').hide();
				$('#paging_div_ap').html(data);
			}
		});
	}
}
