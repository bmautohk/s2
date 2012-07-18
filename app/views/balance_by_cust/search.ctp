<? 
echo $html->css('960.css', NULL, array('inline'=>false));
echo $html->css('sia.css', NULL, array('inline'=>false));
echo $html->css('jscal/jscal2.css', NULL, array('inline'=>false));

echo $javascript->link('cal/jscal2.js');
echo $javascript->link('cal/lang/en.js');?>

	<div class="container_12">
		<div class="invoice_header">
			<div class="lightpanel roundedtop linkbg">
				<h2><a href="../" class="link">Settle Invoice Amt list</a></h2>
				<div class="linkdescription">
				<form id="form1" method="get">
					<label class="grid_2">Invoice ID:</label><input class="grid_2" type="text" name="invoice_id" /> <div class="clear"></div>
					<label class="grid_2">Cust Cd:</label><input class="grid_2" type="text" name="custs_cd" /> <div class="clear"></div>
					<label class="grid_2">SIA Date From:</label>
						<input class="grid_2" type="text" name="settle_date_from" id="settle_date_from" />
						<input class="grid_1" type="button" id="settle_date_from_btn" value=".."/>
						<label class="grid_1" >TO:</label>
						<input class="grid_2" type="text" name="settle_date_to" id="settle_date_to" />
						<input class="grid_1" type="button" id="settle_date_to_btn" value=".."/><div class="clear"></div>
					<label class="grid_2">Settle Ref No. (Cheque No.):</label><input class="grid_2" type="text" name="cheque_no" /><div class="clear"></div>
					<label class="grid_2">Settle Amt:</label><input class="grid_2" type="text" name="amt" /><div class="clear"></div>
					<input class="grid_1" type="submit" id="searchBtn" value="Search" />
					<input class="grid_1" type="button" id="cvsBtn" value="CVS" />
					<input class="grid_1" type="button" id="resetBtn" value="Reset" /><div class="clear"></div>
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
	    inputField : "settle_date_from",
	    trigger    : "settle_date_from_btn",
	    dateFormat : "%Y-%m-%d",
	    onSelect   : function() { this.hide() }
	});
	Calendar.setup({
	    inputField : "settle_date_to",
	    trigger    : "settle_date_to_btn",
	    dateFormat : "%Y-%m-%d",
	    onSelect   : function() { this.hide() }
	});
});
</script>