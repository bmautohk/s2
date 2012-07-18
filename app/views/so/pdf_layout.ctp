<?
$so = $this->data['So'];
$customer = $this->data['Customer'];
$so_date = new DateTime($so["so_date"]);
?>
<style>
h1 {font-size: 25pt;}

.detail td
{
border:1px solid black;
}
</style>

<h1>Sell Order</h1>
<table width="500">
	<tr><td width="300">SO No.:</td><td><?=$so['id']?></td></tr>
	<tr><td>Sale Date:</td><td><?=$so_date->format('Y-m-d')?></td></tr>
	<tr><td>Expected Delivery Date:</td><td><?=$so['delivery_date']?></td></tr>
	<tr><td>Cust No.:</td><td><?=$so['cust_cd']?></td></tr>
	<tr><td>Cust Name:</td><td><?=$customer['name']?></td></tr>
	<tr><td>SO Remark:</td><td><?=$so['remark']?></td></tr>
</table>

<div height="200"></div>

<table class="detail" cellpadding="5">
 <tr>
  	<td width="20"></td>
	<td>Part No</td>
	<td width="200">Desc</td>
	<td>Qty</td>
	<td>Discount</td>
	<td>Unit Price</td>
	<td>SubTotal</td>
	<td>Supplier Code</td>
	<td>Cost</td>
 </tr>
 
<? foreach($this->data['SoDetail'] as $index=>$soDetail) {?>
	<tr>
		<td><?=$index+1 ?></td>
		<td><?=$soDetail['prod_cd']?></td>
		<td><?=$soDetail['Product']['product_name']?></td>
		<td><?=$soDetail['qty']?></td>
		<td><?=$soDetail['discount']?></td>
		<td><?=$soDetail['unit_price']?></td>
		<td><?=$soDetail['subtotal']?></td>
		<td><?=$soDetail['supplier_cd']?></td>
		<td><?=$soDetail['cost']?></td>
	</tr>
<? }?>
	<tr>
		<td colspan="8" align="right">Total:</td>
		<td><?=$so['total_amt'] ?></td>
	</tr>
</table>
