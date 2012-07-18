<?php echo $html->css('po.css');?>
<?php  //var_dump($this);?>
<div class="row">
	<div class="">
		<div class="po_header">
			<div class="lightpanel roundedtop linkbg">
				<h2><a href="list_all" class="link">Purchase Order No: <?=$this->data['Po']['id']?><br/>Invoice No: </a></h2>
				<div class="linkdescription">
					<div class="container_32">
						<div class="grid_4"><label>Sale Date:</label></div><div class="grid_2"><? echo $this->Form->input('Po.po_date', array('label'=>false, 'type'=>'text'))?></div>
						<div class="clear"></div>
						<div class="grid_4"><label>Expected Delivery Date:</label></div><div class="grid_2"><? echo $this->Form->input('So.delivery_date', array('label'=>false, 'type'=>'text'))?></div>
						<div class="clear"></div>
						<div class="grid_4"><label>Cust No.:</label></div><div class="grid_2"><? echo $this->Form->input('So.cust_cd', array('label'=>false, 'type'=>'text'))?></div>
						<div class="clear"></div>
						<div class="grid_4"><label>Cust Name:</label></div><div class="grid_2"><? echo $this->Form->input('So.Customer.name', array('label'=>false, 'type'=>'text'))?></div>
						<div class="clear"></div>
						<div class="grid_4"><label>SO Remark:</label></div><div class="grid_16"><? echo $this->Form->input('So.remark', array('label'=>false, 'cols'=>60, 'rows'=>5))?></textarea></div>
						<div class="clear"></div>
					</div>
				</div>

			</div>
			<div class="bottompanel">
				<ul class="bottomlist">
				</ul>
			</div>
		</div>

		<div class="po_header">
			<div class="lightpanel linkbg">

				<div class="linkdescription" >
					<div class="container_32">
						<div class="grid_1">&nbsp;</div>
						<div class="grid_4">PartNo.</div>
						<div class="grid_5">Desc</div>
						<div class="grid_2">Qty</div>
						<div class="grid_3">Cost/Per QTY</div>
						<div class="grid_3">Type</div>
	                    <div class="grid_3">Label</div>
	                    <div class="grid_3">Logo</div>
	                    <div class="grid_3">Quality</div>
						<div class="clear"></div>

						<? for ($i = 0; $i < sizeof($this->data['PoDetail']); $i++) { ?>
						<div class="grid_1"><?= $i + 1?></div>
						<div class="grid_4"><? echo $this->Form->input('PoDetail.'.$i.'.prod_cd', array('label'=>false, 'type'=>'text', 'size'=>"20", 'maxlength'=>"20"))?></div>
						<div class="grid_5"><? echo $this->Form->input('PoDetail.'.$i.'.Product.product_name', array('label'=>false, 'type'=>'text', 'size'=>"30", 'maxlength'=>"50"))?></div>
						<div class="grid_2"><? echo $this->Form->input('PoDetail.'.$i.'.qty', array('label'=>false, 'type'=>'text', 'size'=>"5", 'maxlength'=>"2"))?></div>
						<div class="grid_3"><? echo $this->Form->input('PoDetail.'.$i.'.cost', array('label'=>false, 'type'=>'text', 'size'=>"10", 'maxlength'=>"10"))?></div>
						<div class="grid_3"><? echo $this->Form->input('PoDetail.'.$i.'.type', array('label'=>false, 'type'=>'text', 'size'=>"13", 'maxlength'=>"10"))?></div>
						<div class="grid_3"><? echo $this->Form->input('PoDetail.'.$i.'.label', array('label'=>false, 'type'=>'text', 'size'=>"13", 'maxlength'=>"10"))?></div>
						<div class="grid_3"><? echo $this->Form->input('PoDetail.'.$i.'.logo', array('label'=>false, 'type'=>'text', 'size'=>"13", 'maxlength'=>"10"))?></div>
						<div class="grid_3"><? echo $this->Form->input('PoDetail.'.$i.'.quality', array('label'=>false, 'type'=>'text', 'size'=>"13", 'maxlength'=>"10"))?></div>
						<div class="clear"></div>
						<? } ?>

					</div>
				</div>


			</div>
			<div class="bottompanel roundedbottom">
				<div class="container_32">
					<ul class="bottomlist" style="height:30px">
						<div class="grid_16">&nbsp; </div>
						<div class="grid_2">&nbsp; </div>
						<label class="grid_2"> Total: </label>
						<? echo $this->Form->input('Po.total_amt', array('label'=>false, 'class'=>'grid_2', 'readonly'=>'readonly'))?>
						<input tclass="grid_1" type="button"  value="PDF" onclick="genpdf(<?=$this->data['Po']['id']?>)"/>
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
function genpdf(id) {
	window.open('genPdf/'+id,'pdf','width=1000,height=800');
}
</script>