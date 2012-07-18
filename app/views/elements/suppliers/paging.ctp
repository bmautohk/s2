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

	<div class="supplier_header">
        <div class="lightpanel linkbg"> 
            <h3> 
                <div class="grid_3">Name</div>
                <div class="grid_2">Code</div>
                <div class="grid_2">Tel</div>
                <div class="grid_2">Contact Person</div>
                <div class="grid_4">Email</div>
                <div class="grid_2">Address</div>
                <div class="grid_1">Edit</div>
                <div class="clear"></div> 
            </h3>

            <div class="linkdescription">
                <?
                foreach($data as $suppliers):
                $supplier = $suppliers['Supplier'];
                ?>
                <div class="grid_3"><?=$supplier['name']?></div> 
                <div class="grid_2"><?=$supplier['supplier_cd']?>&nbsp;</div> 
                <div class="grid_2"><?=$supplier['tel']?>&nbsp;</div> 
                <div class="grid_2"><?=$supplier['contact_person']?>&nbsp;</div>
                <div class="grid_4"><?=$supplier['email']?>&nbsp;</div> 
                <div class="grid_2"><?=$supplier['address']?>&nbsp;</div> 
                <div class="grid_1"><a href="edit?id=<?=$supplier['id']?>">EDIT</a></div> 
                <div class="clear"></div> 
                <? endforeach; ?>
            </div>
    	</div>
    	
    	<div class="bottompanel"> 
			<ul class="bottomlist">		
			</ul> 
		</div> 
    </div>
