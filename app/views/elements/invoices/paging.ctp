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
				<div class="grid_2">Invoice No.</div>
				<div class="grid_3">Total Amt</div>
				<div class="grid_6">Invoice Date</div>
				<div class="grid_3">Sales</div>
				<div class="grid_3">Customer Code</div>
				<div class="grid_2">View Detail</div>
				<div class="grid_2">Print PDF</div>
	
				<div class="clear"></div>
			</h3>
			
			<div class="linkdescription">
				<?
                foreach($data as $invoices):
                $invoice = $invoices['Invoice'];
                ?>
                <div class="grid_2"><?=$invoice['id']?></div> 
                <div class="grid_3"><?=$invoice['total_amt']?></div> 
                <div class="grid_6"><?=$invoice['inv_date']?></div> 
                <div class="grid_3"><?=$invoice['create_by']?></div>
                <div class="grid_3"><?=$invoice['cust_cd']?></div>
                <div class="grid_2"><a href="edit?id=<?=$invoice['id']?>">VIEW</a></div> 
                <div class="grid_2"><a href="javascript:genpdf(<?=$invoice['id']?>)">PRINT</a></div>  
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