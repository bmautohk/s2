<?php
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename="invoice.xls"');
?>

<table>
	<tr>
		<td>Invoice No</td>
		<td>Total Amt</td>
		<td>Invoice Date</td>
		<td>Sales</td>
		<td>Customer Code</td>
	</tr>
<? foreach($data as $invoices) {
	$invoice = $invoices['Invoice'];
	$customer = $invoices['Customer'];
	?>
	<tr>
		<td><?=$invoice['id']?></td>
		<td><?=$invoice['total_amt']?></td>
		<td><?=$invoice['inv_date']?></td>
		<td><?=$invoice['create_by']?></td>
		<td><?=$customer['cust_cd']?></td>
	</tr>
<? } ?>
</table>