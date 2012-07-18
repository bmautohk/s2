<?php 
echo $html->css('bbc.css', NULL, array('inline'=>false));

echo $javascript->link('bbc/bbc.js');
?>

<div class="row">
	<div class="container_32">
		<div class="bbc_header">
			<div class="lightpanel roundedtop linkbg">
				<h2><a href="../" class="link">Balance By Cust (Cust_CD)</a></h2>
		
				<div class="linkdescription">
					<label class="grid_3">Change CustCd</label>
		
					<?php echo $form->select('cust_cd', $custCdList, NULL, array("onchange"=>"search('form1')")); ?>
		
				</div>
			</div>
		
			<div class="bottompanel">
				<ul class="bottomlist">
				</ul>
			</div>
		</div>
	</div>
	
	<div class="clear"></div>
	
	<div class="loading_div" id="loading_div" style="display: none;"></div>
	
	<div class="container_32">
		
		<div id="paging_div_ar">
	    	<? echo $this->element('balance_by_cust/paging_ar'); ?>
	    </div>
	    
	    <div id="paging_div_ap">
	    	<? echo $this->element('balance_by_cust/paging_ap'); ?>
	    </div>

	</div>

	<div class="clear"></div>
	
</div>