<?php echo $html->css('goods_name.css');?>
<?php echo $this->Html->charset("euc-jp");?>
<?php
if (isset($this->data['Product']['product_id']) && !empty($this->data['Product']['product_id'])) {
	$isProductCdReadOnly = true;
}
else {
	$isProductCdReadOnly = false;
}
?>

<div class="row"> 	
		<? echo $this->Form->create('Product', array('name'=>'form1', 'method'=>'post', 'action'=>'save', 'enctype'=>'multipart/form-data')); ?>
		 
        <div class="goods_name_header">
			<div class="lightpanel roundedtop linkbg"> 
				<h2><a href="list_all" class="link">Product Item Entry</a></h2>
				<div class="linkdescription">
				<div class="container_32">  
                    <label class="grid_3">prod_id:</label><? echo $this->Form->input('product_id', array('label'=>false, 'type'=>'text', 'class'=>'grid_3', 'readonly'=>$isProductCdReadOnly))?>
                    <div class="clear"></div> 
                    <label class="grid_3">prod_jp_no:</label><? echo $this->Form->input('product_jp_no', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div> 
                    <label class="grid_3">prod_us_no:</label><? echo $this->Form->input('product_us_no', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div> 
                    <label class="grid_3">prod_sup_no:</label><? echo $this->Form->input('product_sup_no', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">make_id:</label><? echo $this->Form->input('make_id', array('label'=>false, 'type'=>'text', 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_make:</label><? echo $this->Form->input('product_made', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_model:</label><? echo $this->Form->input('product_model', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_remark:</label><? echo $this->Form->input('product_remark', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_name:</label><? echo $this->Form->input('product_name', array('label'=>false, 'class'=>'grid_3', "lang"=>"ja"))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_pcs:</label><? echo $this->Form->input('product_pcs', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_photo:</label><? echo $this->Form->input('product_photo', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_dit:</label><? echo $this->Form->input('product_dit', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_price_s:</label><? echo $this->Form->input('product_price_s', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_price_s2:</label><? echo $this->Form->input('product_price_s2', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_cus_price:</label><? echo $this->Form->input('product_cus_price', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_cost_rmb:</label><? echo $this->Form->input('product_cost_rmb', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_cost_hk:</label><? echo $this->Form->input('product_cost_hk', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_cost_us:</label><? echo $this->Form->input('product_cost_us', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_cost_yan	:</label><? echo $this->Form->input('product_cost_yan', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_sup	:</label><? echo $this->Form->input('product_sup', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_web	:</label><? echo $this->Form->input('product_web', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_colour:</label><? echo $this->Form->input('product_colour', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_price_u:</label><? echo $this->Form->input('product_price_u', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_index:</label><? echo $this->Form->input('product_index', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_location:</label><? echo $this->Form->input('product_location', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_stock_level:</label><? echo $this->Form->input('product_stock_level', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_stock_jp:</label><? echo $this->Form->input('product_stock_jp', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_model_no:</label><? echo $this->Form->input('product_model_no', array('label'=>false, 'type'=>'text', 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_year:</label><? echo $this->Form->input('product_year', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">cat_id:</label><? echo $this->Form->input('cat_id', array('label'=>false, 'type'=>'text', 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_cat:</label><? echo $this->Form->input('product_cat', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_desc:</label><? echo $this->Form->input('product_desc', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">roduct_70_17:</label><? echo $this->Form->input('roduct_70_17', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_rmb:</label><? echo $this->Form->input('product_rmb', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_stock_us:</label><? echo $this->Form->input('product_stock_us', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_stock_cn:</label><? echo $this->Form->input('product_stock_cn', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">roduct_stock_hk:</label><? echo $this->Form->input('roduct_stock_hk', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_cus_des:</label><? echo $this->Form->input('product_cus_des', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_group:</label><? echo $this->Form->input('product_group', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_material:</label><? echo $this->Form->input('product_material', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_colour_no:</label><? echo $this->Form->input('product_colour_no', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_original_color:</label><? echo $this->Form->input('product_original_color', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_auction_p:</label><? echo $this->Form->input('product_auction_p', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">product_qc:</label><? echo $this->Form->input('product_qc', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">maz:</label><? echo $this->Form->input('maz', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">prod_on_order:</label><? echo $this->Form->input('prod_on_order', array('label'=>false, 'class'=>'grid_3'))?>
                    <div class="clear"></div>
                    <label class="grid_3">alias:</label><? echo $this->Form->input('alias', array('label'=>false, 'class'=>'grid_3'))?>
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