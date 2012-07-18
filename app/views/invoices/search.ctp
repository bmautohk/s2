<? 
echo $html->css('1280_32_4_4.css', NULL, array('inline'=>false));
echo $html->css('css.css', NULL, array('inline'=>false));
echo $html->css('jscal/jscal2.css', NULL, array('inline'=>false));

echo $javascript->link('cal/jscal2.js');
echo $javascript->link('cal/lang/en.js');?>

	<div class="container_32">
        <div class="invoice_header">
            <div class="lightpanel roundedtop linkbg"> 
            <h2><a href="../" class="link">Invoice List</a></h2>
            <div class="linkdescription">
            <form id="form1" method="get">
	            <label class="grid_4">Invoice no:</label><input class="grid_4" type="text" name="id" /> <div class="clear"></div> 
	            <label class="grid_4">Cust Name:</label><input class="grid_4" type="text" name="cust_name" /> <div class="clear"></div> 
	            <label class="grid_4">Cust Code:</label><input class="grid_4" type="text" name="cust_cd" /> <div class="clear"></div>
	            <label class="grid_4">Product Code:</label><input class="grid_4" type="text" name="prod_cd" /> <div class="clear"></div> 
	            <label class="grid_4">Invoice Date From:</label>
	            	<input class="grid_4" type="text" name="inv_date_from" id="inv_date_from" /> 
	            	<input class="grid_1" type="button" id="inv_date_from_btn" value=".."/>
	            	<label class="grid_1" >to:</label>
	            	<input class="grid_4" type="text" name="inv_date_to" id="inv_date_to" />
	            	<input class="grid_1" type="button" id="inv_date_to_btn" value=".."/><div class="clear"></div>
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

<script type="text/javascript"><!--
$(function() {
	Calendar.setup({
	    inputField : "inv_date_from",
	    trigger    : "inv_date_from_btn",
	    dateFormat : "%Y-%m-%d",
	    onSelect   : function() { this.hide() }
	});
	Calendar.setup({
	    inputField : "inv_date_to",
	    trigger    : "inv_date_to_btn",
	    dateFormat : "%Y-%m-%d",
	    onSelect   : function() { this.hide() }
	});
});
--></script>