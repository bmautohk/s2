<?
$page = $paging_ar['page'];
$pageCount = $paging_ar['pageCount'];
?>
		<div class="grid_16">
			<div class="lightpanel roundedtop linkbg">
				<?  if ($cust_cd != "") {?>
				<h2><a href="../" class="link">AR Display unsettle invoice for [<?=$cust_cd ?>]</a></h2>
				<? } else {?>
				<h2><a href="../" class="link">AR Display unsettle invoice</a></h2>
				<? }?>
				<input value="&lt;&lt;" type="button" onclick="goToPage_ar(<? echo $page > 1 ? 1 : 0 ?>)" />
			    <input value="&lt;" type="button" onclick="goToPage_ar(<? echo $page > 1 ? $page - 1 : 0 ?>)" />
			    <input value="&gt;" type="button" onclick="goToPage_ar(<? echo $page < $pageCount ? $page + 1 : 0 ?>)" />
			    <input value="&gt;&gt;" type="button" onclick="goToPage_ar(<? echo $page < $pageCount ? $pageCount : 0 ?>)" />
			</div>
			
			<form id="criteriaForm_ar">
		    <? foreach ($paging_ar as $index => $value) {?>
				<input type="hidden" name="<?=$index?>" value="<?=$value?>" />
			<? } ?>
		    </form>

			<div class="bbc_header">
				<div class="lightpanel linkbg">
					<h3>
						<div class="grid_2">Inv No.</div>
						<div class="grid_3">Invoice Date</div>
						<div class="grid_2">SO No.</div>
						<div class="grid_3">Customer Code</div>
						<div class="grid_4">Amt/Settled Amt</div>
						<div class="grid_1">Sts</div>
	
						<div class="clear"></div>
	
					</h3>
					<div class="linkdescription">
						<?
						$total = 0;
						$total_settle = 0;
		                foreach($arData as $invoices):
		                $invoice = $invoices['Invoice'];
		                $inv_date = new DateTime($invoice["inv_date"]);
		                $total = $total + $invoice["total_amt"];
		                $total_settle = $total_settle + $invoice["ar_settle_amt"];
		                ?>
		                <div class="grid_2"><a href="../invoices/edit?id=<?=$invoice['id']?>"><?=$invoice["id"]?></a></div>
		                <div class="grid_3"><?=$inv_date->format('Y-m-d')?></div>
		                <div class="grid_2"><?=$invoice["sell_order_id"]?></div>
		                <div class="grid_3"><?=$invoice["cust_cd"]?></div>
						<div class="grid_4">$<?=$invoice["total_amt"]?> / $<?=$invoice["ar_settle_amt"]?></div>
						<div class="grid_1"><a href="../ar_by_cust/create?cust_cd=<?=$invoice['cust_cd']?>"><?=$invoice["ar_sts"]?></a></div>
						<div class="clear"></div>
		                
						<? endforeach?>	
					</div>
	
				</div>
				<div class="bottompanel roundedbottom">
				<div class="container_32">
					<ul class="bottomlist" style="height:30px">
						<label class="grid_4"> Total Invoice: </label>
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