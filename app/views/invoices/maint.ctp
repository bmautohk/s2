<?php 
echo $html->css('jscal/jscal2.css');
echo $javascript->link('invoices/maint.js');?>

<?php
if (isset($this->data['Invoice']['id']) && !empty($this->data['Invoice']['id'])) {
	if ($action == 'create') {
		$isUpdate = false;
	}
	else {
		$isUpdate = true;
	}
}
else {
	$isUpdate = false;
}
?>

<div class="row">
	<div class="">
		<? echo $this->Form->create('Invoice', array('name'=>'form1', 'method'=>'post', 'action'=>'../invoices/save', 'enctype'=>'multipart/form-data')); ?>
		<? echo $this->Form->hidden('id')?>
		
			<div class="invoice_header ">
				<div class="lightpanel roundedtop linkbg">
					<h2><a href="<?=$this->webroot ?>invoices/list_all" class="link">Invoice Entry</a></h2>
					<div class="linkdescription">
						<div class="container_32">
							<div class="grid_4"><label>Sell Order No.:</label></div>
								<div class="grid_4"><? echo $this->Form->input('Invoice.sell_order_id', array('label'=>false, 'type'=>'text', 'readonly'=>$isUpdate))?>
								</div>
								<? if (!$isUpdate) {?><input type="button" id="searchBtn" value="search"/> <? }?>
							<div class="clear"></div>
							<div class="grid_4"><label>Invoice Date:</label></div><div class="grid_5"><? echo $this->Form->input('Invoice.inv_date', array('label'=>false, 'type'=>'text', 'readonly'=>true))?></div>
							<div class="clear"></div>
							<div class="grid_4"><label>Cust no.:</label></div>
								<div class="grid_4"><? echo $this->Form->input('Invoice.cust_cd', array('label'=>false, 'type'=>'text'))?></div>
								<div class="grid_2 error-message" id="custNoErrMsg"></div>
							<div class="clear"></div>
							<div class="grid_4"><label>Cust Name:</label></div><div class="grid_2"><? echo $this->Form->input('Customer.name', array('label'=>false, 'type'=>'text', 'readonly'=>true))?></div>
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
if (!empty($this->validationErrors['Invoice']['InvoiceDetail'])) { ?>
	<div class="row">
    	<div class="container_12"> 
			<div class="error_msg">
	
	<? foreach ($this->validationErrors['Invoice']['InvoiceDetail'] as $index => $value) {
		foreach ($value as $msg) {
		echo $index + 1;
		echo ': '.$msg.'<br>';
		}
	}
	?>
			</div>
		</div>
	</div>
<? } ?>

			<div class="loading_div" id="loading_div" style="display: none;"></div>
			
			<div id="detail_div">
    			<? echo $this->element('invoices/invoice_detail_list'); ?>
    		</div>
		</form>
	</div>
</div>
<? echo $this->Form->end(); ?>

<script type="text/javascript">
var webroot = '<?=$this->webroot ?>';
var action = '<?=$action ?>';
</script>