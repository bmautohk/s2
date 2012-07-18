<table>
<tr>
<td>
	<div class="container_32">
		<div class="po_header">
			<div class="lightpanel linkbg">
				<h3>
					<div class="grid_0">Invoice No.</div>
					<div class="grid_1">Total Amt</div>
					<div class="grid_2">Invoice Date</div>
					<div class="grid_1">Sales</div>
					<div class="grid_3">Customer Code</div>
					<div class="grid_2">View Detail</div>
					<div class="grid_2">Print PDF</div>
		
					<div class="clear"></div>
				</h3>
				
				<div class="linkdescription">
					<?
	                foreach($invoiceList as $invoices):
	                $invoice = $invoices['Invoice'];
	                $so = $invoices['So'];
	                ?>
	                <div class="grid_0"><?=$invoice['id']?></div> 
	                <div class="grid_1"><?=$invoice['total_amt']?></div> 
	                <div class="grid_2"><?=$invoice['inv_date']?></div> 
	                <div class="grid_1"><?=$invoice['create_by']?></div>
	                <div class="grid_3"><?=$so['cust_cd']?></div>
	                <div class="grid_2"><a href="edit?id=<?=$invoice['id']?>">VIEW</a></div> 
	                <div class="grid_2"><a href="#">PRINT</a></div>  
	                <div class="clear"></div> 
	                <? endforeach; ?>
				</div>
		
			</div>
			
			<div class="bottompanel">
				<ul class="bottomlist">
				</ul>
			</div>
		</div>
	</div>
</td>
<td>
	<div class="container_32">
		<div class="po_header">
			<div class="lightpanel linkbg">
				<h3>
					<div class="grid_2">PO No.</div>
					<div class="grid_2">SO No.</div>
					<div class="grid_3">Total Cost Amt</div>
					<div class="grid_3">PO Date</div>
					<div class="grid_3">Sales</div>
					<div class="grid_2">Supplier Code</div>
					<div class="grid_2">Cust Code</div>
					<div class="grid_2">View Detail</div>
					<div class="grid_2">Print PDF</div>
		
					<div class="clear"></div>
				</h3>
				
				<div class="linkdescription">
					<?
	                foreach($poList as $pos):
	                $po = $pos['Po'];
	                $so = $pos['So'];
	                ?>
	                <div class="grid_2"><?=$po['id']?></div> 
	                <div class="grid_2"><?=$po['sell_order_id']?></div> 
	                <div class="grid_3">$<?=$po['total_amt']?></div> 
	                <div class="grid_3"><?=$po['po_date']?></div>
	                <div class="grid_3"><?=$po['create_by']?></div>
	                <div class="grid_2"><?=$po['supplier_cd']?></div>
	                <div class="grid_2"><?=$so['cust_cd']?></div>
	                <div class="grid_2"><a href="view?id=<?=$po['id']?>">VIEW</a></div> 
	                <div class="grid_2"><a href="#">PRINT</a></div>  
	                <div class="clear"></div> 
	                <? endforeach; ?>
				</div>
		
			</div>
			
			<div class="bottompanel">
				<ul class="bottomlist">
				</ul>
			</div>
		</div>
	</div>
</td>
</tr>
</table>

