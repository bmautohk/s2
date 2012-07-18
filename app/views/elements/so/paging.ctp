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

	<div class="so_header">
        <div class="lightpanel linkbg"> 
            <h3>
				<div class="grid_2">SO No</div>
				<div class="grid_4">SO Total Amt</div>
				<div class="grid_4">Sale Date</div>
				
				<div class="grid_6">Cust Code</div>
				<div class="grid_2">Edit</div>
				<div class="grid_2">View</div>
				<div class="grid_2">Create Invoice</div>
				
				<div class="clear"></div>
			</h3>

            <div class="linkdescription">
                <?
                foreach($data as $sos):
                $so = $sos['So'];
                ?>
                <div class="grid_2"><?=$so['id']?></div> 
                <div class="grid_4">$<?=$so['total_amt']?>&nbsp;</div> 
                <div class="grid_4"><?=$so['so_date']?>&nbsp;</div> 
                <div class="grid_6"><?=$so['cust_cd']?>&nbsp;</div> 
                <div class="grid_2"><a href="edit?id=<?=$so['id']?>">EDIT</a></div>
                <div class="grid_2"><a href="javascript:genpdf(<?=$so['id']?>)">VIEW</a></div>
                <? if ($so['sts'] == So::STS_PENDING) { ?>
                <div class="grid_2"><a href="../invoices/create?so_id=<?=$so['id']?>">CREATE</a></div>
                <? } else { ?>
                <div class="grid_2">&nbsp;</div>
                <? }?>  
                <div class="clear"></div> 
                <? endforeach; ?>
            </div>
    	</div>
    	
		<div class="bottompanel"> 
			<ul class="bottomlist">		
			</ul> 
		</div> 
    </div>
