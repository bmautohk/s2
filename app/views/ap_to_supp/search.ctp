<? 
echo $html->css('1280_32_4_4.css', NULL, array('inline'=>false));
echo $html->css('pts.css', NULL, array('inline'=>false));
echo $html->css('jscal/jscal2.css', NULL, array('inline'=>false));

echo $javascript->link('cal/jscal2.js');
echo $javascript->link('cal/lang/en.js');?>

	<div class="container_32">
		<div class="invoice_header">
			<div class="lightpanel roundedtop linkbg">
				<h2><a href="../" class="link">Payment to Supplier list</a></h2>
				<div class="linkdescription">
				<form id="form1" method="get">
					<label class="grid_4">Payment to Supplier  id:</label><input class="grid_4" type="text" name="ap_id"> <div class="clear"></div>
					<label class="grid_4">PO NO:</label><input class="grid_4" type="text" name="po_id"> <div class="clear"></div>
					<label class="grid_4">SO NO:</label><input class="grid_4" type="text" name="so_id"> <div class="clear"></div>

					<label class="grid_4">INV NO:</label><input class="grid_4" type="text" name="invoice_id"> <div class="clear"></div>
					<label class="grid_4">Supplier Code:</label><input class="grid_4" type="text" name="supplier_cd"> <div class="clear"></div>
					<label class="grid_4">PTS Date From:</label>
						<input class="grid_4" type="text" name="payment_date_from" id="payment_date_from">
						<input class="grid_1" type="button" id="payment_date_from_btn" value=".."/>
						<label class="grid_1" >TO:</label>
						<input class="grid_4" type="text" name="payment_date_to" id="payment_date_to" >
						<input class="grid_1" type="button" id="payment_date_to_btn" value=".."/>
					<div class="clear"></div>
					<label class="grid_4">Payment Ref No. (Cheque No.):</label><input class="grid_4" type="text" name="cheque_no"><div class="clear"></div>
					<label class="grid_4">Payment Amt:</label><input class="grid_4" type="text" name="amt"><div class="clear"></div>
					<input class="grid_2" type="submit" id="searchBtn" value="Search" />
					<input class="grid_2" type="button" id="cvsBtn" value="CVS" />
					<input class="grid_2" type="button" id="resetBtn" value="Reset" /><div class="clear"></div>
				</form>
				</div>
			</div>
			<div class="bottompanel">
				<ul class="bottomlist">
				</ul>
			</div>
		</div>
	</div>

<script type="text/javascript">
$(function() {
	Calendar.setup({
	    inputField : "payment_date_from",
	    trigger    : "payment_date_from_btn",
	    dateFormat : "%Y-%m-%d",
	    onSelect   : function() { this.hide() }
	});
	Calendar.setup({
	    inputField : "payment_date_to",
	    trigger    : "payment_date_to_btn",
	    dateFormat : "%Y-%m-%d",
	    onSelect   : function() { this.hide() }
	});
});
</script>
