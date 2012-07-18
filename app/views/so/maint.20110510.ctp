<?php 
echo $html->css('so.css', NULL, array('inline'=>false));
echo $html->css('jscal/jscal2.css');
echo $html->css('smoothness/jquery-ui.custom.css', NULL, array('inline'=>false));

echo $javascript->link('cal/jscal2.js');
echo $javascript->link('cal/lang/en.js');
echo $javascript->link('jquery-ui-core.min.js');
echo $javascript->link('jquery-ui.autocomplete.min.js');
echo $javascript->link('so/maint.js');?>

<?php
if (isset($this->data['So']['id']) && !empty($this->data['So']['id'])) {
	$isProdReadOnly = true;
	$isCreate = false;
}
else {
	$isProdReadOnly = false;
	$isCreate = true;
}

if (!empty($this->validationErrors['So']['cust_id'])) {
	$this->validationErrors['So']['cust_cd'] = $this->validationErrors['So']['cust_id'];
}
?>

<? echo $this->Form->create('So', array('name'=>'form1', 'id'=>'saveFrom', 'method'=>'post', 'action'=>'../so/save', 'enctype'=>'multipart/form-data')); ?>
<? echo $this->Form->hidden('id')?>

<style type="text/css">
	ul li.ui-menu-item  a {background: transparent;}
</style>

<div class="row"> 
	<div class=""> 
        <div class="invoice_header ">
            <div class="lightpanel roundedtop linkbg"> 
                <h2><a href="<?=$this->webroot ?>so/list_all" class="link">Sell Order Entry</a></h2>
                <div class="linkdescription"> 
	                <div class="container_32">
	                	<? if (!$isCreate) {?>
	                	<div class="grid_4"><label>SO No:</label></div><div class="grid_2"><input value="<?=$this->data['So']['id']?>" readonly="readonly" /></div>
		                <div class="clear"></div>
	                 	<? }?>
		                <div class="grid_4"><label>Sale Date:</label></div><div class="grid_2"><? echo $this->Form->input('So.so_date', array('label'=>false, 'type'=>'text', 'readonly'=>true))?></div>
		                <div class="clear"></div>
		                <div class="grid_4"><label>Expected Delivery Date:</label></div>
		                	<div class="grid_4"><? echo $this->Form->input('So.delivery_date', array('label'=>false, 'type'=>'text'))?></div>
		                	<input class="grid_1" type="button" id="SoDeliveryDateBtn" value=".."/>
		                <div class="clear"></div>
		                <div class="grid_4"><label>Cust No.:</label></div>
		                	<div class="grid_4"><? echo $this->Form->input('So.cust_cd', array('label'=>false))?></div>
		                	<div class="grid_2 error-message" id="custNoErrMsg"></div>
		                <div class="clear"></div> 
		                <div class="grid_4"><label>Cust Name:</label></div><div class="grid_2"><? echo $this->Form->input('Customer.name', array('label'=>false, 'readonly'=>true))?></div>
		                <div class="clear"></div>
		                <div class="grid_4"><label>SO Remark:</label></div><div class="grid_16"><? echo $this->Form->input('So.remark', array('label'=>false, 'cols'=>60, 'rows'=>5))?></div>
		                <div class="clear"></div>
	            	</div>
        		</div>
    	</div>
		
        <div class="bottompanel"> 
			<ul class="bottomlist">		
			</ul> 
		</div> 
	</div>
	
	<?
	if (!empty($this->validationErrors['SoDetail'])) { ?>
		<div class="row">
	    	<div class="container_12"> 
				<div class="error_msg">
		
		<? foreach ($this->validationErrors['SoDetail'] as $index => $value) {
			foreach ($value as $fieldsName => $msg) {
			echo $index + 1;
			echo ': '.' - '.$msg.'<br>';
			}
		}
		?>
				</div>
			</div>
		</div>
	<? } ?>

	<div class="invoice_header">
		<div class="lightpanel linkbg">
			<div class="linkdescription">
				 <div class="container_32" id="table"> 
                    <div class="grid_1">&nbsp;</div>
                    <div class="grid_3">PartNo.</div>   
                    <div class="grid_5">Desc</div>   
                    <div class="grid_2">Qty</div>   
                    <div class="grid_2">Disc</div>
                    <div class="grid_2">UnitPrice</div>
                    <div class="grid_2">SubTotal</div>
                    <div class="grid_3">SupplierCd</div>                        
                    <div class="grid_2">Cost</div>
                    <div class="grid_2">Type</div>
                    <div class="grid_2">Label</div>
                    <div class="grid_2">Logo</div>
                    <div class="grid_2">Quality</div>
                    <div class="clear"></div> 
                    
                    <? for ($i = 0; $i <= sizeof($this->data['SoDetail']); $i++) { ?>
                    <? echo $this->Form->hidden('SoDetail.'.$i.'.id')?>
                    <div class="row_detail">
                    <div class="grid_1"><?=$i+1 ?></div>
                    <div class="grid_3"><? echo $this->Form->input('SoDetail.'.$i.'.prod_cd', array('label'=>false, 'type'=>'text', 'size'=>'15', 'maxlength'=>'20', 'readonly'=>$isProdReadOnly))?></div>
                    <div class="grid_5"><? echo $this->Form->input('SoDetail.'.$i.'.Product.product_name', array('label'=>false, 'type'=>'text', 'size'=>'30','maxlength'=>'50', 'readonly'=>true))?></div>   
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.qty', array('label'=>false, 'onblur'=>'calPrice(this)', 'size'=>'5', 'maxlength'=>'5', 'error'=>false))?></div>   
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.discount', array('label'=>false, 'onblur'=>'calPrice(this)', 'size'=>'3', 'maxlength'=>'3', 'error'=>false))?></div>
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.unit_price', array('label'=>false, 'onblur'=>'calPrice(this)', 'size'=>'5','maxlength'=>'10'))?></div>
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.subtotal', array('label'=>false, 'size'=>'5', 'maxlength'=>'10', 'readonly'=>true))?></div>
                    <div class="grid_3"><? echo $form->select('SoDetail.'.$i.'.supplier_cd', $supplierCdList); ?></div>
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.cost', array('label'=>false, 'size'=>'5', 'maxlength'=>'10'))?></div>
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.type', array('label'=>false, 'size'=>'6', 'maxlength'=>'255'))?></div>
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.label', array('label'=>false, 'size'=>'6', 'maxlength'=>'255'))?></div>
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.logo', array('label'=>false, 'size'=>'6', 'maxlength'=>'255'))?></div>
                    <div class="grid_2"><? echo $this->Form->input('SoDetail.'.$i.'.quality', array('label'=>false, 'size'=>'6', 'maxlength'=>'255'))?></div>
                    <div class="clear"></div>
                    </div>
                    <? } ?>
                    
				</div> 
			</div>    

		</div>
		
        <div class="bottompanel roundedbottom"> 
			<div class="container_16"> 
                <ul class="bottomlist">		
                    <div class="grid_6">&nbsp; </div>
                    <div class="grid_0">&nbsp; </div>
                    <label class="grid_1"> Total: </label>
                    <? echo $this->Form->input('So.total_amt', array('label'=>false, 'class'=>'grid_2', 'readonly'=>'readonly'))?>
                    <input tclass="grid_1" type="button"  id="saveBtn" value="submit"/>
                    <? if (!$isCreate) {?>
                    	<input tclass="grid_1" type="button"  value="PDF" onclick="genpdf(<?=$this->data['So']['id']?>)"/>
                    <? }?>
				</ul> 
			</div> 
		</div>
	</div>
    
</div>
<? echo $this->Form->end(); ?>
<script type="text/javascript">
var row_idx = <?=$i-1 ?>;
var webroot = '<?=$this->webroot ?>';

$(function() {
	Calendar.setup({
	    inputField : "SoDeliveryDate",
	    trigger    : "SoDeliveryDateBtn",
	    dateFormat : "%Y-%m-%d %H:%M:%S",
	    showTime   : true,
	    onSelect   : function() { this.hide() }
	});

	$('#SoDetail' + row_idx + 'ProdCd').attr('readonly', '');

	initAutoCOmplete($('#SoDetail' + row_idx + 'ProdCd'), row_idx);
	
	$('#SoDetail' + row_idx + 'ProdCd').focus(function() {
		addRow(this);
	});
});

function genpdf(id) {
	window.open('genPdf/'+id,'pdf','width=1000,height=800');
}
</script>
