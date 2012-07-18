<?php 
echo $html->css('pts.css', NULL, array('inline'=>false));
?>

<?php
if (isset($this->data['ApToSupp']['id']) && !empty($this->data['ApToSupp']['id'])) {
	$isSuppCdReadOnly = true;
}
else {
	$isSuppCdReadOnly = false;
}
?>

<? echo $this->Form->create('ApToSupp', array('name'=>'form1', 'method'=>'post', 'action'=>'../apToSupp/save', 'enctype'=>'multipart/form-data')); ?>
<? echo $this->Form->hidden('id')?>

<div class="row">
	<div class="">
		<div class="invoice_header ">
			<div class="lightpanel roundedtop linkbg">
				<h2><a href="<?=$this->webroot ?>apToSupp/list_all" class="link">Payment to Supplier (AP)</a></h2>
				<div class="linkdescription">
					<div class="container_32">
						<div class="grid_5"><label>Invoice No:(OPTIONAL)</label></div><? echo $this->Form->input('ApToSupp.invoice_id', array('label'=>false, 'type'=>'text', 'class'=>'grid_4'))?>
						<div class="clear"></div>

						<div class="grid_5"><label>SO No:(OPTIONAL)</label></div><? echo $this->Form->input('ApToSupp.so_id', array('label'=>false, 'type'=>'text', 'class'=>'grid_4'))?>
						<div class="clear"></div>

						<div class="grid_5"><label>PO No:(OPTIONAL)</label></div><? echo $this->Form->input('ApToSupp.po_id', array('label'=>false, 'type'=>'text', 'class'=>'grid_4'))?>
						<div class="clear"></div>


						<div class="grid_5"><label>*Payment date:</label></div><? echo $this->Form->input('ApToSupp.payment_date', array('label'=>false, 'type'=>'text', 'class'=>'grid_4', 'readonly'=>true))?>
						<div class="clear"></div>

						<div class="grid_5"><label>*Supplier Code.:</label></div><? echo $this->Form->input('ApToSupp.supplier_cd', array('label'=>false, 'type'=>'text', 'class'=>'grid_4', 'readonly'=>$isSuppCdReadOnly))?>
						<div class="clear"></div>

						<div class="grid_5"><label>*Payment Ref No. (Cheque No.):</label></div><? echo $this->Form->input('ApToSupp.cheque_no', array('label'=>false, 'type'=>'text', 'class'=>'grid_4'))?>
						<div class="clear"></div>

						<div class="grid_5"><label>*Payment Amt:</label></div><? echo $this->Form->input('ApToSupp.amt', array('label'=>false, 'type'=>'text', 'class'=>'grid_4'))?>

						<div class="grid_5">
							<input type="submit"  name="submit" value="submit"/>
						</div>

						<div class="clear"></div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<? echo $this->Form->end(); ?>