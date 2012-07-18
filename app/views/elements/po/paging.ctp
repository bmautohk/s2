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

<div class="container_32">
	<div class="po_header">
		<div class="lightpanel linkbg">
			<h3>
				<div class="grid_2">PO No.</div>
				<div class="grid_2">SO No.</div>
				<div class="grid_3">Total Cost Amt</div>
				<div class="grid_3">PO Date</div>
				<div class="grid_3">Sales</div>
				<div class="grid_2">Supplier Code</div>
				<div class="grid_2">Cust Code</div>
				<div class="grid_2">View Detail</div>
				<div class="grid_2">Print PDF</div>
	
				<div class="clear"></div>
			</h3>
			
			<div class="linkdescription">
				<?
                foreach($data as $pos):
                $po = $pos['Po'];
                $so = $pos['So'];
                ?>
                <div class="grid_2"><?=$po['id']?></div> 
                <div class="grid_2"><?=$po['sell_order_id']?></div> 
                <div class="grid_3">$<?=$po['total_amt']?></div> 
                <div class="grid_3"><?=$po['po_date']?></div>
                <div class="grid_3"><?=$po['create_by']?></div>
                <div class="grid_2"><?=$po['supplier_cd']?></div>
                <div class="grid_2"><?=$so['cust_cd']?></div>
                <div class="grid_2"><a href="view?id=<?=$po['id']?>">VIEW</a></div> 
                <div class="grid_2"><a href="javascript:genpdf(<?=$po['id']?>)">PRINT</a></div>  
                <div class="clear"></div> 
                <? endforeach; ?>
			</div>
	
		</div>
		
		<div class="bottompanel">
			<ul class="bottomlist">
			</ul>
		</div>
	</div>
</div>