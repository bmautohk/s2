<?
$po = $this->data['Po'];
$so = $this->data['So'];
$po_date = new DateTime($po["po_date"]);
?>
<style>
h1 {font-size: 25pt;}

.detail td
{
border:1px solid black;
}
</style>

<h1>Purchase Order</h1>
<table width="500">
	<tr><td width="300">PO No.:</td><td><?=$po['id']?></td></tr>
	<tr><td>Sale Date:</td><td><?=$po_date->format('Y-m-d')?></td></tr>
	<tr><td>Expected Delivery Date:</td><td><?=$so['delivery_date']?></td></tr>
	<tr><td>Cust No.:</td><td><?=$so['cust_cd']?></td></tr>
	<tr><td>Cust Name:</td><td><?=$so['Customer']['name']?></td></tr>
	<tr><td>SO Remark:</td><td><?=$so['remark']?></td></tr>
</table>

<div height="200"></div>

<table class="detail" cellpadding="5">
 <tr>
  	<td width="20"></td>
	<td>Part No</td>
	<td width="200">Desc</td>
	<td>Qty</td>
	<td>Cost/Per QTY</td>
 </tr>
 
<? foreach($this->data['PoDetail'] as $index=>$detail) {?>
	<tr>
		<td><?=$index+1 ?></td>
		<td><?=$detail['prod_cd']?></td>
		<td><?=$detail['Product']['product_name']?></td>
		<td><?=$detail['qty']?></td>
		<td><?=$detail['cost']?></td>
	</tr>
<? }?>
	<tr>
		<td colspan="4" align="right">Total:</td>
		<td><?=$po['total_amt'] ?></td>
	</tr>
</table>
