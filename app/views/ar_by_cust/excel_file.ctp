<?php
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename="ar.xls"');
?>

<table>
	<tr>
		<td>AR ID</td>
		<td>Invoice ID</td>
		<td>Settle Date</td>
		<td>Customer Code</td>
		<td>Cheque No</td>
		<td>Amt</td>
		<td>Settle Amt</td>
		<td>Sts</td>
	</tr>
<? foreach($data as $ars) {
	$ar = $ars['ArByCust'];
	?>
	<tr>
		<td><?=$ar['id']?></td>
		<td><?=$ar['invoice_id']?></td>
		<td><?=$ar['settle_date']?></td>
		<td><?=$ar['cust_cd']?></td>
		<td><?=$ar['cheque_no']?></td>
		<td><?=$ar['amt']?></td>
		<td><?=$ar['settle_amt']?></td>
		<td><?=$ar['sts']?></td>
	</tr>
<? } ?>
</table>

