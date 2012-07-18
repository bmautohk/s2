<?php
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename="po.xls"');
?>

<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body>

<table>
	<tr>
		<td>PO No.</td>
		<td>SO No.</td>
		<td>PO Date</td>
		<td>Sts</td>
		<td>Total Cost Amt</td>
		<td>AP Sts</td>
		<td>Supplier Code</td>
		<td>Creation Date</td>
		<td>Created By</td>
		<td>Last Update Date</td>
		<td>Last Update By</td>
		
		<td>Item ID</td>
		<td>PO No.</td>
		<td>Product ID</td>
		<td>Product Code</td>
		<td>Qty</td>
		<td>Cost</td>
		<td>Sub Total</td>
		<td>sts</td>
		<td>Creation Date</td>
		<td>Created By</td>
		<td>Last Update Date</td>
		<td>Last Update By</td>
		
		<td>product_id</td>
		<td>product_jp_no</td>
		<td>product_us_no</td>
		<td>product_sup_no</td>
		<td>make_id</td>
		<td>product_made</td>
		<td>product_model</td>
		<td>product_remark</td>
		<td>product_name</td>
		<td>product_pcs</td>
		<td>product_photo</td>
		<td>product_dit</td>
		<td>product_price_s</td>
		<td>product_price_s1</td>
		<td>product_price_s2</td>
		<td>product_cus_price</td>
		<td>product_cost_rmb</td>
		<td>product_cost_hk</td>
		<td>product_cost_us</td>
		<td>product_cost_yan</td>
		<td>product_sup</td>
		<td>product_web</td>
		<td>product_colour</td>
		<td>product_price_u</td>
		<td>product_index</td>
		<td>product_location</td>
		<td>product_stock_level</td>
		<td>product_stock_jp</td>
		<td>product_model_no</td>
		<td>product_year</td>
		<td>cat_id</td>
		<td>product_cat</td>
		<td>product_desc</td>
		<td>product_70_17</td>
		<td>product_rmb</td>
		<td>product_stock_us</td>
		<td>product_stock_cn</td>
		<td>product_stock_hk</td>
		<td>product_cus_des</td>
		<td>product_group</td>
		<td>product_material</td>
		<td>product_colour_no</td>
		<td>product_original_color</td>
		<td>product_auction_p</td>
		<td>product_qc</td>
		<td>maz</td>
		<td>prod_on_order</td>
		<td>alias</td>
		<td>remark2</td>
		<td>sent</td>
		<td>net_total</td>
	</tr>
<? foreach($data as $pos) {
	$po = $pos['Po'];
	?>
	<tr>
		<td><?=$po['id']?></td>
		<td><?=$po['sell_order_id']?></td>
		<td><?=$po['po_date']?></td>
		<td><?=$po['sts']?></td>
		<td><?=$po['total_amt']?></td>
		<td><?=$po['ap_sts']?></td>
		<td><?=$po['supplier_cd']?></td>
		<td><?=$po['create_date']?></td>
		<td><?=$po['create_by']?></td>
		<td><?=$po['last_update_date']?></td>
		<td><?=$po['last_update_by']?></td>
	</tr>
	
	<? foreach($pos['PoDetail'] as $po_detail ) { 
		$product = $po_detail["Product"];
	?>
	<tr>
		<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
		<td><?=$po_detail['id']?></td>
		<td><?=$po_detail['po_id']?></td>
		<td><?=$po_detail['prod_id']?></td>
		<td><?=$po_detail['prod_cd']?></td>
		<td><?=$po_detail['qty']?></td>
		<td><?=$po_detail['cost']?></td>
		<td><?=$po_detail['subtotal']?></td>
		<td><?=$po_detail['sts']?></td>
		<td><?=$po_detail['create_date']?></td>
		<td><?=$po_detail['create_by']?></td>
		<td><?=$po_detail['last_update_date']?></td>
		<td><?=$po_detail['last_update_by']?></td>
		
		<td><?=$product['product_id']?></td>
		<td><?=$product['product_jp_no']?></td>
		<td><?=$product['product_us_no']?></td>
		<td><?=$product['product_sup_no']?></td>
		<td><?=$product['make_id']?></td>
		<td><?=$product['product_made']?></td>
		<td><?=$product['product_model']?></td>
		<td><?=$product['product_remark']?></td>
		<td><?=$product['product_name']?></td>
		<td><?=$product['product_pcs']?></td>
		<td><?=$product['product_photo']?></td>
		<td><?=$product['product_dit']?></td>
		<td><?=$product['product_price_s']?></td>
		<td><?=$product['product_price_s1']?></td>
		<td><?=$product['product_price_s2']?></td>
		<td><?=$product['product_cus_price']?></td>
		<td><?=$product['product_cost_rmb']?></td>
		<td><?=$product['product_cost_hk']?></td>
		<td><?=$product['product_cost_us']?></td>
		<td><?=$product['product_cost_yan']?></td>
		<td><?=$product['product_sup']?></td>
		<td><?=$product['product_web']?></td>
		<td><?=$product['product_colour']?></td>
		<td><?=$product['product_price_u']?></td>
		<td><?=$product['product_index']?></td>
		<td><?=$product['product_location']?></td>
		<td><?=$product['product_stock_level']?></td>
		<td><?=$product['product_stock_jp']?></td>
		<td><?=$product['product_model_no']?></td>
		<td><?=$product['product_year']?></td>
		<td><?=$product['cat_id']?></td>
		<td><?=$product['product_cat']?></td>
		<td><?=$product['product_desc']?></td>
		<td><?=$product['product_70_17']?></td>
		<td><?=$product['product_rmb']?></td>
		<td><?=$product['product_stock_us']?></td>
		<td><?=$product['product_stock_cn']?></td>
		<td><?=$product['product_stock_hk']?></td>
		<td><?=$product['product_cus_des']?></td>
		<td><?=$product['product_group']?></td>
		<td><?=$product['product_material']?></td>
		<td><?=$product['product_colour_no']?></td>
		<td><?=$product['product_original_color']?></td>
		<td><?=$product['product_auction_p']?></td>
		<td><?=$product['product_qc']?></td>
		<td><?=$product['maz']?></td>
		<td><?=$product['prod_on_order']?></td>
		<td><?=$product['alias']?></td>
		<td><?=$product['remark2']?></td>
		<td><?=$product['sent']?></td>
		<td><?=$product['net_total']?></td>
	</tr>
	<? }?>
<? } ?>
</table>

</body></html>