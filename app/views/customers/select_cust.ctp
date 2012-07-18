<?php echo $html->css('1280_32_4_4.css', NULL, array('inline'=>false));
echo $html->css('customer.css', NULL, array('inline'=>false));
echo $javascript->link(strtolower($this->name).'/selectCust');
?>
 
	<div class="container_32">
        <div class="member_header">
            <div class="lightpanel roundedtop linkbg"> 
            <h2><a href="../" class="link">Customer List</a></h2>
            <div class="linkdescription">
            <form id="form1" method="get">
            <label class="grid_3">Name:</label><input type="text" class='grid_4' name="name" /><div class="clear"></div> 
            <label class="grid_3">Code:</label><input type="text" class='grid_4' name="cust_cd" /><div class="clear"></div> 
            <label class="grid_3">Tel:</label><input type="text" class='grid_4' name="tel" /><div class="clear"></div>
            <label class="grid_3">Fax:</label><input type="text" class='grid_4' name="fax" /><div class="clear"></div> 
            <label class="grid_3">Address:</label><input type="text" class='grid_4' name="address" /><div class="clear"></div>
            <label class="grid_3">Contact Person:</label><input type="text" class='grid_4' name="contact_person" /><div class="clear"></div> 
            <label class="grid_3">Email:</label><input type="text" class='grid_4' name="email" /><div class="clear"></div> 
            <label class="grid_3">&nbsp </label>
            <input class="grid_2" type="submit" id="searchBtn" value="Search" />
			<input class="grid_2" type="button" id="resetBtn" value="Reset" /><div class="clear"></div>
            </form>
            </div>
        </div>
		
        <div class="bottompanel"> 
			<ul class="bottomlist">		
			</ul> 
		</div> 
	</div>
