<?php 
echo $html->css('sia.css', NULL, array('inline'=>false));
?>

<?php
if (isset($this->data['ArByCust']['id']) && !empty($this->data['ArByCust']['id'])) {
	$isCustCdReadOnly = true;
}
else {
	$isCustCdReadOnly = false;
}
?>

<? echo $this->Form->create('ArByCust', array('name'=>'form1', 'method'=>'post', 'action'=>'../arByCust/save', 'enctype'=>'multipart/form-data')); ?>
<? echo $this->Form->hidden('id')?>

<div class="row">
	<div class="">
		<div class="invoice_header ">
			<div class="lightpanel roundedtop linkbg">
				<h2><a href="<?=$this->webroot ?>arByCust/list_all" class="link">Settle Invoice Amt Entry (AR)</a></h2>
				<div class="linkdescription">
					<div class="container_32">
						<div class="grid_5"><label>Invoice No:(optional)</label></div><? echo $this->Form->input('ArByCust.invoice_id', array('label'=>false, 'type'=>'text', 'class'=>'grid_5'))?>
						<div class="clear"></div>
						<div class="grid_5"><label>*Settle date:</label></div><? echo $this->Form->input('ArByCust.settle_date', array('label'=>false, 'type'=>'text', 'readonly'=>true, 'class'=>'grid_5'))?>
						<div class="clear"></div>
						<div class="grid_5"><label>*Cust no.:</label></div><? echo $this->Form->input('ArByCust.cust_cd', array('label'=>false, 'readonly'=>$isCustCdReadOnly, 'class'=>'grid_5'))?>
						<div class="clear"></div>

						<div class="grid_5"><label>*Settle Ref No. (Cheque No.):</label></div><? echo $this->Form->input('ArByCust.cheque_no', array('label'=>false, 'class'=>'grid_5'))?>
						<div class="clear"></div>
						<div class="grid_5"><label>*Settle Amt:</label></div>
							<? echo $this->Form->input('amt', array('label'=>false, 'class'=>'grid_5'))?>
						<div class="clear"></div>
						<div class="grid_5">
							<input type="submit" name="submit" value="submit"/>
						</div>
						<div class="clear"></div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>
<? echo $this->Form->end(); ?>