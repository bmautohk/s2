<?php echo $html->css('1280_32_4_4.css', NULL, array('inline'=>false));
echo $html->css('supplier.css', NULL, array('inline'=>false));
?>
 
	<div class="container_32">
        <div class="supplier_header">
            <div class="lightpanel roundedtop linkbg"> 
            <h2><a href="../" class="link">Supplier List</a></h2>
            <div class="linkdescription">
            <form id="form1" method="get">
            <label class="grid_3">Name:</label><input class="grid_4" name="name" type="text" /> <div class="clear"></div> 
            <label class="grid_3">Code:</label><input class="grid_4" name="supplier_cd" type="text" /> <div class="clear"></div> 
            <label class="grid_3">Tel:</label><input class="grid_4" name="tel" type="text" /> <div class="clear"></div>
            <label class="grid_3">Fax:</label><input class="grid_4" name="fax" type="text" /> <div class="clear"></div> 
            <label class="grid_3">Address:</label><input class="grid_4" name="address" type="text" /><div class="clear"></div>
            <label class="grid_3">Contact Person:</label><input class="grid_4" name="contact_person" type="text" /> <div class="clear"></div>
            <label class="grid_3">Email:</label><input class="grid_4" name="email" type="text" /><div class="clear"></div>
            <label class="grid_3">&nbsp </label>
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
