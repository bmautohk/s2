
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

				<? for ($i = 0; $i < sizeof($this->data['SoDetail']); $i++) { ?>
                    <? 
                    $detail = $this->data['SoDetail'][$i];?>
                <input type="hidden" name="data[InvoiceDetail][<?=$i ?>][so_detail_id]" value="<?=$detail['id'] ?>" />
				<div class="grid_1">1</div>
				<div class="grid_4"><input name="SoDetailProdCd" size="20" maxlength="20" type="text" value="<?=$detail['prod_cd'] ?>"/></div>
				<div class="grid_5"><input name="SoDetailProductName" size="30" maxlength="50" type="text" value="<?=$detail['Product']['product_name'] ?>"/></div>
				<div class="grid_2"><input name="SoDetailOrigQty" size="5" maxlength="5" type="text" value="<?=$detail['qty'] ?>" readonly/> </div>
				<div class="grid_2"><input name="SoDetailAvailQty" size="5" maxlength="5" type="text" value="<?=$detail['qty'] - $detail['inv_qty'] ?>" readonly/></div>
				<div class="grid_3"><input name="data[InvoiceDetail][<?=$i ?>][qty]" size="5" maxlength="5" type="text" value="0"/></div>
				<div class="grid_2"><input name="SoDetailDiscount" size="3" maxlength="3"  type="text" value="<?=$detail['discount'] ?>"/> </div>
				<div class="grid_3"><input name="SoDetailUnitPrice" size="10" maxlength="10" type="text" value="<?=$detail['unit_price'] ?>" readonly/></div>
				<div class="grid_3"><input name="SoDetailSubTotal" size="10" maxlength="10" type="text" value="<?=$detail['subtotal'] ?>"/></div>

				<div class="clear"></div>
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
				<? echo $this->Form->input('So.total_amt', array('label'=>false, 'class'=>'grid_2', 'readonly'=>'readonly'))?>
				<input tclass="grid_2" type="submit"  name="submit" value="submit"/>
				<div class="clear"></div>
			</ul>
		</div>
	</div>
</div>