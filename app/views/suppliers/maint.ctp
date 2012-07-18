<?php echo $html->css('supplier.css', NULL, array('inline'=>false));?>

<?php
if (isset($this->data['Supplier']['id']) && !empty($this->data['Supplier']['id'])) {
	$isSupplierCdReadOnly = true;
}
else {
	$isSupplierCdReadOnly = false;
}
?>

<div class="row"> 
	<div class=""> 
		<? echo $this->Form->create('Supplier', array('name'=>'form1', 'method'=>'post', 'action'=>'save', 'enctype'=>'multipart/form-data')); ?>
		<? echo $this->Form->hidden('id')?>
		<div class="supplier_header">
			<div class="lightpanel roundedtop linkbg"> 
				<h2><a href="<?=$this->webroot?>suppliers/list_all" class="link">Supplier Entry</a></h2>
				<div class="linkdescription">
					<div class="container_32"> 
					<div class="clear"></div> 
				
                	<label class="grid_3">Supplier Name :</label><? echo $this->Form->input('name', array('label'=>false, 'class'=>'grid_4'))?>
                    <div class="clear"></div>
                    <label class="grid_3">Code.:</label><? echo $this->Form->input('supplier_cd', array('label'=>false, 'class'=>'grid_4', 'readonly'=>$isSupplierCdReadOnly))?>
                    <div class="clear"></div>
                    <label class="grid_3">Tel.:</label><? echo $this->Form->input('tel', array('label'=>false, 'class'=>'grid_4'))?>
                    <div class="clear"></div>
                    <label class="grid_3">Fax.:</label><? echo $this->Form->input('fax', array('label'=>false, 'class'=>'grid_4'))?>
					<div class="clear"></div>
                    <label class="grid_3">Address.:</label><? echo $this->Form->textarea('address', array('label'=>false, 'class'=>'grid_4'))?>
                    <div class="clear"></div>
                    <label class="grid_3">Contact Person.:</label><? echo $this->Form->input('contact_person', array('label'=>false, 'class'=>'grid_4'))?>
					<div class="clear"></div>
                    <label class="grid_3">Email.:</label><? echo $this->Form->input('email', array('label'=>false, 'class'=>'grid_4'))?>
                    <div class="clear"></div>
					</div>
				</div> 
		
			</div>
			
            <div class="bottompanel"> 
				<ul class="bottomlist">	
 				<input tclass="grid_1" type="submit"  name="submit" value="submit"/>				
				</ul> 
			</div> 
		</div>
		<? echo $this->Form->end(); ?>
    </div>
</div>