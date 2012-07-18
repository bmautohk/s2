<?
echo $html->css('1280_32_4_4.css');  
echo $html->css('goods_name.css');?>
 
	<div class="container_32">
        <div class="goods_name_header">
            <div class="lightpanel roundedtop linkbg"> 
            <h2><a href="../" class="link">Product List</a></h2>
            <div class="linkdescription">
            <form id="form1" method="get">
            <label class="grid_3">Product ID:</label><input class="grid_3" name="product_id" type="text" /> <div class="clear"></div> 
			<label class="grid_3">Desc:</label><input class="grid_3" name="desc" type="text" /> <div class="clear"></div> 
			<label class="grid_3">Price:</label>
				<input class="grid_3" name="price_from" type="text" />
				<label class="grid_1" >to:</label>
				<input class="grid_3" name="price_to" type="text" />
				<div class="clear"></div>
            <label class="grid_3">&nbsp </label><input class="grid_2" type="button" id="searchBtn" value="Search" />
												<input class="grid_2" type="button" id="resetBtn" value="Reset" /><div class="clear"></div>
            </form>
            </div>
        </div>
		
        <div class="bottompanel"> 
			<ul class="bottomlist">		
			</ul> 
		</div> 
	</div>
