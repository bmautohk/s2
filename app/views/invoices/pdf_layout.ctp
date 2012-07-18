<?
$invoice = $this->data['Invoice'];
$customer = $this->data['Customer'];
$inv_date = new DateTime($invoice["inv_date"]);
?>
<style>
h1 {font-size: 25pt;}

.detail td
{
border:1px solid black;
}
</style>

<h1>Invoice</h1>
<table width="500">
	<tr><td width="200">Invoice No.:</td><td><?=$invoice['id']?></td></tr>
	<tr><td>Sell Order No.:</td><td><?=$invoice['sell_order_id']?></td></tr>
	<tr><td>Invoice Date:</td><td><?=$inv_date->format('Y-m-d')?></td></tr>
	<tr><td>Cust No.:</td><td><?=$invoice['cust_cd']?></td></tr>
	<tr><td>Cust Name:</td><td><?=$customer['name']?></td></tr>
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
 </tr>
 
<? foreach($this->data['InvoiceDetail'] as $index=>$detail) {?>
	<tr>
		<td><?=$index+1 ?></td>
		<td><?=$detail['prod_cd']?></td>
		<td><?=$detail['Product']['product_name']?></td>
		<td><?=$detail['qty']?></td>
		<td><?=$detail['discount']?></td>
		<td><?=$detail['unit_price']?></td>
		<td><?=$detail['subtotal']?></td>
	</tr>
<? }?>
	<tr>
		<td colspan="6" align="right">Total:</td>
		<td><?=$invoice['total_amt'] ?></td>
	</tr>
</table>
