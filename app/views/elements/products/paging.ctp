<?php echo $this->Html->charset("euc-jp");?>

	<?
	$page = $paging['page'];
	$pageCount = $paging['pageCount'];
	?>
    
    <input value="&lt;&lt;" type="button" onclick="goToPage(<? echo $page > 1 ? 1 : 0 ?>)" />
    <input value="&lt;" type="button" onclick="goToPage(<? echo $page > 1 ? $page - 1 : 0 ?>)" />
    <input value="&gt;" type="button" onclick="goToPage(<? echo $page < $pageCount ? $page + 1 : 0 ?>)" />
    <input value="&gt;&gt;" type="button" onclick="goToPage(<? echo $page < $pageCount ? $pageCount : 0 ?>)" />
    
    <form id="criteriaForm">
    <? foreach ($paging as $index => $value) {?>
		<input type="hidden" name="<?=$index?>" value="<?=$value?>" />
	<? } ?>
    </form>

	<div class="goods_name_header">
        <div class="lightpanel linkbg"> 
            <h3> 
                <div class="grid_2">Product ID</div>
                <div class="grid_2">Price</div>
                <div class="grid_3">Model</div>
                <div class="grid_2">Remarks</div>
                <div class="grid_6">Name</div>
                <div class="grid_0">VIEW</div>
                <div class="clear"></div> 
            </h3>

            <div class="linkdescription">
                <?
                foreach($data as $products):
                $product = $products['Product'];
                ?>
                <div class="grid_2"><?=$product['product_id']?>&nbsp;</div> 
                <div class="grid_2"><?=$product['product_cus_price']?>&nbsp;</div> 
                <div class="grid_3"><?=$product['product_model']?>&nbsp;</div> 
                <div class="grid_2"><?=$product['product_remark']?>&nbsp;</div>
                <div class="grid_6"><?=$product['product_name']?>&nbsp;</div>  
                <div class="grid_0"><a href="edit?id=<?=$product['product_id']?>">VIEW</a></div> 
                <div class="clear"></div> 
                <? endforeach; ?>
            </div>
    	</div>
    </div>
