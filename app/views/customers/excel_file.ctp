<?php
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename="customer.xls"');
?>
<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body>
<table>
	<tr>
		<td>ID</td>
		<td>Customer Code</td>
		<td>Name</td>
		<td>Tel</td>
		<td>Contact Person</td>
		<td>Address</td>
		<td>Email</td>
		<td>Creation Date</td>
		<td>Created By</td>
		<td>Last Update Date</td>
		<td>Last Update By</td>
	</tr>
<? foreach($data as $customers) {
	$customer = $customers['Customer'];
	?>
	<tr>
		<td><?=$customer['id']?></td>
		<td><?=$customer['cust_cd']?></td>
		<td><?=$customer['name']?></td>
		<td><?=$customer['tel']?></td>
		<td><?=$customer['contact_person']?></td>
		<td><?=$customer['address']?></td>
		<td><?=$customer['email']?></td>
		<td><?=$customer['create_date']?></td>
		<td><?=$customer['create_by']?></td>
		<td><?=$customer['last_update_date']?></td>
		<td><?=$customer['last_update_by']?></td>
	</tr>
<? } ?>
</table>

</body>
</html>