<?php
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename="ap.xls"');
?>

<table>
	<tr>
		<td>PTS ID</td>
		<td>Payment Amt.</td>
		<td>PO NO</td>
		<td>SO No</td>
		<td>INV NO</td>
		<td>Supplier Cd</td>
		<td>PTS Date</td>
		<td>PTS Ref No.</td>
	</tr>
<? foreach($data as $ars) {
	$ap = $ars['ApToSupp'];
	?>
	<tr>
		<td><?=$ap['id']?></td>
		<td><?=$ap['amt']?></td>
		<td><?=$ap['po_id']?></td>
		<td><?=$ap['so_id']?></td>
		<td><?=$ap['invoice_id']?></td>
		<td><?=$ap['supplier_cd']?></td>
		<td><?=$ap['payment_date']?></td>
		<td><?=$ap['cheque_no']?></td>
	</tr>
<? } ?>
</table>

