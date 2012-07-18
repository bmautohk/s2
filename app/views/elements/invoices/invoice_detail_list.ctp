
<? if (isset($this->data['Customer'])) {?>
<input type="hidden" id="custCd" value="<?=$this->data['Customer']['cust_cd']?>"/>
<input type="hidden" id="custName" value="<?=$this->data['Customer']['name']?>"/>
<? } ?>

<?
if (isset($this->data["Invoice"]["id"])) {
	$isNewItem = false;
}
else {
	$isNewItem = true;
}
?>

<div class="invoice_header">
	<div class="lightpanel linkbg">

		<div class="linkdescription" >
			<div class="container_32">
				<div class="grid_1">&nbsp;</div>
				<div class="grid_4">PartNo.</div>
				<div class="grid_5">Desc</div>
				<div class="grid_2">Orig. Qty</div>
				<div class="grid_2">Avail. Qty</div>
				<div class="grid_3">Actual. Qty</div>
				<div class="grid_2">Disc</div>
				<div class="grid_3">UnitPrice</div>
				<div class="grid_3">SubTotal</div>

				<div class="clear"></div>

				<? for ($i = 0; $i < sizeof($this->data['InvoiceDetail']); $i++) { ?>
                    <?  echo $this->Form->hidden('InvoiceDetail.'.$i.'.id');
                    echo $this->Form->hidden('InvoiceDetail.'.$i.'.so_detail_id');
                    echo $this->Form->hidden('InvoiceDetail.'.$i.'.sumAvailActQty');
                    
                    $qtyReadOnly = false;
                    if ($this->data['InvoiceDetail'][$i]['qty'] == 0 && $this->data['InvoiceDetail'][$i]['availQty'] == 0) {
                    	$qtyReadOnly = true;
                    }
                ?>
                <div class="row_detail">
				<div class="grid_1"><?=$i + 1 ?></div>
				<div class="grid_4"><? echo $this->Form->input('InvoiceDetail.'.$i.'.prod_cd', array('label'=>false, 'type'=>'text', 'size'=>'20', 'maxlength'=>'20', 'readonly'=>true))?></div>
				<div class="grid_5"><? echo $this->Form->input('InvoiceDetail.'.$i.'.Product.product_name', array('label'=>false, 'type'=>'text', 'size'=>'30', 'maxlength'=>'50', 'readonly'=>true))?></div>
				<div class="grid_2"><? echo $this->Form->input('InvoiceDetail.'.$i.'.origQty', array('label'=>false, 'type'=>'text', 'size'=>'5', 'maxlength'=>'5', 'readonly'=>true))?></div>
				<div class="grid_2"><? echo $this->Form->input('InvoiceDetail.'.$i.'.availQty', array('label'=>false, 'type'=>'text', 'size'=>'5', 'maxlength'=>'5', 'readonly'=>true))?></div>
				<div class="grid_3"><? echo $this->Form->input('InvoiceDetail.'.$i.'.qty', array('label'=>false, 'type'=>'text', 'onblur'=>'calPrice(this)', 'size'=>'5', 'maxlength'=>'5', 'error'=>false, 'readonly'=>$qtyReadOnly))?></div>
				<div class="grid_2"><? echo $this->Form->input('InvoiceDetail.'.$i.'.discount', array('label'=>false, 'type'=>'text', 'size'=>'3', 'onblur'=>'calPrice(this)', 'maxlength'=>'3', 'error'=>false))?></div>
				<div class="grid_3"><? echo $this->Form->input('InvoiceDetail.'.$i.'.unit_price', array('label'=>false, 'type'=>'text', 'size'=>'10', 'onblur'=>'calPrice(this)', 'maxlength'=>'10', 'error'=>false))?></div>
				<div class="grid_3"><? echo $this->Form->input('InvoiceDetail.'.$i.'.subtotal', array('label'=>false, 'type'=>'text', 'size'=>'10', 'maxlength'=>'10', 'readonly'=>true))?></div>

				<div class="clear"></div>
				</div>
				<? } ?>
			</div>
		</div>


	</div>
	<div class="bottompanel roundedbottom">
		<div class="container_32">
			<ul class="bottomlist">
				<div class="grid_16">&nbsp; </div>
				<div class="grid_2">&nbsp; </div>
				<label class="grid_2"> Total: </label>
				<? echo $this->Form->input('Invoice.total_amt', array('label'=>false, 'class'=>'grid_2', 'readonly'=>'readonly'))?>
				<input tclass="grid_2" type="submit"  name="submit" value="submit"/>
				<div class="clear"></div>
			</ul>
		</div>
	</div>
</div>