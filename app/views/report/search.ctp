<?
echo $html->css('960.css', NULL, array('inline'=>false));
echo $html->css('css.css', NULL, array('inline'=>false));?>

<div class="container_12">
	<div class="po_header">
		<div class="lightpanel roundedtop linkbg">
			<h2><a href="../" class="link">Invoice View</a>
			</h2>
			
			<div class="linkdescription">
				<form id="form1" method="get">
				<label class="grid_3">Change View</label>
				
				<?php echo $form->select('cust_cd', $custCdList, NULL, array("onchange"=>"search('form1')")); ?>

				<div class="clear"></div><hr/>
				<div class="clear"></div>
				</form>
			</div>
		</div>
		
		<div class="bottompanel">
			<ul class="bottomlist">
			</ul>
		</div>
	</div>
</div>
<br>
