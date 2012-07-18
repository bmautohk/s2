<?php
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename="supplier.xls"');
?>
<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body>
<table>
	<tr>
		<td>ID</td>
		<td>Name</td>
		<td>Supplier Code</td>
		<td>Tel</td>
		<td>Fax</td>
		<td>Contact Person</td>
		<td>Email</td>
		<td>Address</td>
		<td>Creation Date</td>
		<td>Created By</td>
		<td>Last Update Date</td>
		<td>Last Update By</td>
	</tr>
<? foreach($data as $suppliers) {
	$supplier = $suppliers['Supplier'];
	?>
	<tr>
		<td><?=$supplier['id']?></td>
		<td><?=$supplier['name']?></td>
		<td><?=$supplier['supplier_cd']?></td>
		<td><?=$supplier['tel']?></td>
		<td><?=$supplier['fax']?></td>
		<td><?=$supplier['contact_person']?></td>
		<td><?=$supplier['email']?></td>
		<td><?=$supplier['address']?></td>
		<td><?=$supplier['create_date']?></td>
		<td><?=$supplier['create_by']?></td>
		<td><?=$supplier['last_update_date']?></td>
		<td><?=$supplier['last_update_by']?></td>
	</tr>
<? } ?>
</table>

</body></html>