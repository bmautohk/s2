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

	<div class="member_header">
        <div class="lightpanel linkbg"> 
            <h3> 
                <div class="grid_4">Name</div>
                <div class="grid_2">CustCD</div>
                <div class="grid_3">TEL</div>
                <div class="grid_3">Address</div>
                <div class="grid_5">Email</div>
                <div class="grid_0">Select</div>
                <div class="clear"></div> 
            </h3>

            <div class="linkdescription">
                <?
                foreach($data as $customers):
                $customer = $customers['Customer'];
                ?>
                <div class="grid_4"><?=$customer['name']?></div> 
                <div class="grid_2"><?=$customer['cust_cd']?>&nbsp;</div> 
                <div class="grid_3"><?=$customer['tel']?>&nbsp;</div> 
                <div class="grid_3"><?=$customer['address']?>&nbsp;</div> 
                <div class="grid_5"><?=$customer['email']?>&nbsp;</div> 
                <div class="grid_0"><a href="javascript:goSelect('<?=$customer['cust_cd']?>', '<?=$customer['name']?>')">SELECT</a></div> 
                <div class="clear"></div> 
                <? endforeach; ?>
            </div>
    	</div>
    	
    	<div class="bottompanel"> 
			<ul class="bottomlist">		
			</ul> 
		</div> 
    </div>
