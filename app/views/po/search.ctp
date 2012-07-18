<?
echo $html->css('1280_32_4_4.css', NULL, array('inline'=>false)); 
echo $html->css('po.css', NULL, array('inline'=>false));?>

<div class="container_32">
	<div class="po_header">
		<div class="lightpanel roundedtop linkbg">
			<h2><a href="../" class="link">PO List</a>
			</h2>
			
			<div class="linkdescription">
				<form id="form1" method="get">
				<label class="grid_3">Change View</label>
				
				<?php echo $form->select('supplier_cd', $supplierCdList, NULL, array("onchange"=>"search('form1')")); ?>

				<div class="clear"></div><hr/>
				<div class="clear"></div>
				<label class="grid_4">PO ID:</label><input class="grid_5" type="text" name="po_id">
				
				<input class="grid_2" type="submit" id="searchBtn" value="Search" />
				<input class="grid_2" type="button" id="cvsBtn" value="CSV"/> <div class="clear"></div>
				
				</form>
			</div>
		</div>
		
		<div class="bottompanel">
			<ul class="bottomlist">
			</ul>
		</div>
	</div>
</div>
