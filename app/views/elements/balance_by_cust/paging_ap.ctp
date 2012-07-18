<?
$page = $paging_ap['page'];
$pageCount = $paging_ap['pageCount'];
?>

<div class="grid_16">
		<div class="lightpanel roundedtop linkbg">
			<?  if ($cust_cd != "") {?>
			<h2><a href="../" class="link">AP Display unsettle PO for [<?=$cust_cd?>] invoice only</a></h2>
			<? } else {?>
			<h2><a href="../" class="link">AP Display unsettle PO</a></h2>
			<? }?>
			<input value="&lt;&lt;" type="button" onclick="goToPage_ap(<? echo $page > 1 ? 1 : 0 ?>)" />
		    <input value="&lt;" type="button" onclick="goToPage_ap(<? echo $page > 1 ? $page - 1 : 0 ?>)" />
		    <input value="&gt;" type="button" onclick="goToPage_ap(<? echo $page < $pageCount ? $page + 1 : 0 ?>)" />
		    <input value="&gt;&gt;" type="button" onclick="goToPage_ap(<? echo $page < $pageCount ? $pageCount : 0 ?>)" />
		</div>
		
		<form id="criteriaForm_ap">
			<? foreach ($paging_ap as $index => $value) {?>
			<input type="hidden" name="<?=$index?>" value="<?=$value?>" />
			<? } ?>
		</form>
		
		<div class="bbc_header">
			<div class="lightpanel linkbg">
				<h3>
					<div class="grid_2">PO No.</div>
					<div class="grid_3">PO Date</div>
					<div class="grid_2">SO No.</div>
					<div class="grid_3">Supplier Code</div>
					<div class="grid_4">Amt/Settled Amt</div>
					<div class="grid_1">Sts</div>

					<div class="clear"></div>

				</h3>
				<div class="linkdescription">
					<?
					$total = 0;
					$total_settle = 0;
	                foreach($apData as $pos):
	                $po = $pos['Po'];
	                $po_date = new DateTime($po["po_date"]);
	                $total = $total + $po["total_amt"];
	                $total_settle = $total_settle + $po["ap_settle_amt"];
	                ?>
	                <div class="grid_2"><a href="../po/view?id=<?=$po['id']?>"><?=$po["id"]?></a></div>
	                <div class="grid_3"><?=$po_date->format('Y-m-d')?></div>
	                <div class="grid_2"><?=$po["sell_order_id"]?></div>
	                <div class="grid_3"><?=$po["supplier_cd"]?></div>
					<div class="grid_4">$<?=$po["total_amt"]?> / $<?=$po["ap_settle_amt"]?></div>
					<div class="grid_1"><a href="../ap_to_supp/create?supplier_cd=<?=$po['supplier_cd']?>"><?=$po["ap_sts"]?></a></div>
					<div class="clear"></div>
	                
					<? endforeach?>
				</div>

			</div>
			
			<div class="bottompanel roundedbottom">
				<div class="container_32">
					<ul class="bottomlist" style="height:30px">
						<label class="grid_4"> Total PO: </label>
						<input class="grid_2" readonly="readonly" value="$<?=$total ?>"/>
					</ul>
					<ul class="bottomlist" style="height:30px">
						<label class="grid_4"> Total Unsettle: </label>
						<input class="grid_2" readonly="readonly" value="$<?=$total - $total_settle ?>"/>
					</ul>
				</div>
			</div>
		</div>
	</div>