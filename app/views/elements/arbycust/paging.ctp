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
				<div class="grid_2">SIA Id</div>
				<div class="grid_2">Settle Amt.</div>
				<div class="grid_2">Inv ID</div>
				<div class="grid_2">Cust Cd</div>
				<div class="grid_4">Sia Date</div>
				<div class="grid_3">Sia Ref No.</div>
				<div class="grid_1">EDIT</div>

				<div class="clear"></div>

			</h3>
			<div class="linkdescription">
				<?
                foreach($data as $arByCusts):
                $arByCust = $arByCusts['ArByCust'];
                ?>
				<div class="grid_2"><?=$arByCust['id']?></div>
				<div class="grid_2">$<?=$arByCust['amt']?></div>
				<div class="grid_2"><?=$arByCust['invoice_id']?>&nbsp;</div>
				<div class="grid_2"><?=$arByCust['cust_cd']?></div>
				<div class="grid_4"><?=$arByCust['settle_date']?></div>
				<div class="grid_3"><?=$arByCust['cheque_no']?></div>
				<div class="grid_1"><a href="edit?id=<?=$arByCust['id']?>">EDIT</a></div>
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