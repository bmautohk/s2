<?php
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename="so.xls"');
?>
<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body>
<table>
	<tr>
		<td>SO No.</td>
		<td>SO Date</td>
		<td>Delivery Date</td>
		<td>Customer Code</td>
		<td>Customer ID</td>
		<td>Sts</td>
		<td>Total Amt</td>
		<td>Remarks</td>
		<td>Creation Date</td>
		<td>Created By</td>
		<td>Last Update Date</td>
		<td>Last Update By</td>
	</tr>
<? foreach($data as $sos) {
	$so = $sos['So'];
	?>
	<tr>
		<td><?=$so['id']?></td>
		<td><?=$so['so_date']?></td>
		<td><?=$so['delivery_date']?></td>
		<td><?=$so['cust_cd']?></td>
		<td><?=$so['cust_id']?></td>
		<td><?=$so['sts']?></td>
		<td><?=$so['total_amt']?></td>
		<td><?=$so['remark']?></td>
		<td><?=$so['create_date']?></td>
		<td><?=$so['create_by']?></td>
		<td><?=$so['last_update_date']?></td>
		<td><?=$so['last_update_by']?></td>
	</tr>
<? } ?>
</table>

</body></html>