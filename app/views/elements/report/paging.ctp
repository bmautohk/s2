
	<div class="container_12">
		<div class="po_header">
			<div class="lightpanel linkbg">
				<h3>
					<div class="grid_0">Invoice No.</div>
					<div class="grid_1">Total Amt</div>
					<div class="grid_1">Settled Amt</div>
					<div class="grid_2">Invoice Date</div>
					<div class="grid_1">Sales</div>
					<div class="grid_2">Customer Code</div>
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
	                <div class="grid_1"><?=$invoice['ar_settle_amt']?></div> 
	                <div class="grid_2"><?=$invoice['inv_date']?></div> 
	                <div class="grid_1"><?=$invoice['create_by']?></div>
	                <div class="grid_2"><?=$so['cust_cd']?></div>
	                <div class="grid_2"><a href="../invoices/edit?id=<?=$invoice['id']?>">VIEW</a></div> 
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
