<?
	$page = $paging['page'];
	$pageCount = $paging['pageCount'];
?>

<div class="container_32">
	<input value="&lt;&lt;" type="button" onclick="goToPage(<? echo $page > 1 ? 1 : 0 ?>)" />
    <input value="&lt;" type="button" onclick="goToPage(<? echo $page > 1 ? $page - 1 : 0 ?>)" />
    <input value="&gt;" type="button" onclick="goToPage(<? echo $page < $pageCount ? $page + 1 : 0 ?>)" />
    <input value="&gt;&gt;" type="button" onclick="goToPage(<? echo $page < $pageCount ? $pageCount : 0 ?>)" />
    
    <form id="criteriaForm">
    <? foreach ($paging as $index => $value) {?>
		<input type="hidden" name="<?=$index?>" value="<?=$value?>" />
	<? } ?>
    </form>

	<div class="invoice_header">
		<div class="lightpanel linkbg">
			<h3>
				<div class="grid_2">PTS Id</div>
				<div class="grid_3">Payment Amt.</div>
				<div class="grid_2">PO NO</div>
				<div class="grid_2">SO NO</div>
				<div class="grid_2">INV NO</div>
				<div class="grid_3">Supplier Cd</div>
				<div class="grid_4">PTS Date</div>
				<div class="grid_3">PTS Ref No.</div>
				<div class="grid_1">EDIT</div>

				<div class="clear"></div>

			</h3>
			<div class="linkdescription">
				<?
                foreach($data as $apToSupps):
                $apToSupp = $apToSupps['ApToSupp'];
                ?>
                <div class="grid_2"><?=$apToSupp['id']?></div>
				<div class="grid_3">$<?=$apToSupp['amt']?></div>
				<div class="grid_2"><?=$apToSupp['po_id']?>&nbsp;</div>
				<div class="grid_2"><?=$apToSupp['so_id']?>&nbsp;</div>
				<div class="grid_2"><?=$apToSupp['invoice_id']?>&nbsp;</div>
				<div class="grid_3"><?=$apToSupp['supplier_cd']?></div>
				<div class="grid_4"><?=$apToSupp['payment_date']?></div>
				<div class="grid_3"><?=$apToSupp['cheque_no']?></div>
				<div class="grid_1"><a href="edit?id=<?=$apToSupp['id']?>">EDIT</a></div>
				<div class="clear"></div>
				
                <? endforeach;?>
			</div>

		</div>
		<div class="bottompanel">
			<ul class="bottomlist">
			</ul>
		</div>
	</div>
</div>
