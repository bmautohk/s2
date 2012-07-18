<?php echo $html->css('/css/menubar.css');?>
<div class="row">    
<div class="container_12">
	<div class="menubar"> 
	<ul>
	
	<li><a href="#">Sell Order</a>
	<ul>
		<li><a href="<?=$this->webroot?>so/list_all">list</a></li>
		<li><a href="<?=$this->webroot?>so/create">create</a></li>
	</ul>
	</li>
	
	<li><a href="#">Purchase Order</a>
	<ul>
		<li><a href="<?=$this->webroot?>po/list_all">list</a></li>
	</ul>
	</li>
	
	<li><a href="#">Invoice</a>
	<ul>
		<li><a href="<?=$this->webroot?>invoices/list_all">list</a></li>
		<li><a href="<?=$this->webroot?>invoices/create">create</a></li>
	</ul>
	</li>
	
	
	<li><a href="#">Settle Invoice</a>
	<ul>
		<li><a href="<?=$this->webroot?>arByCust/list_all">list</a></li>
		<li><a href="<?=$this->webroot?>arByCust/create">create</a></li>
	</ul>
	</li>
	
	<li><a href="#">Settle Purchase Order</a>
	<ul>
		<li><a href="<?=$this->webroot?>apToSupp/list_all">list</a></li>
		<li><a href="<?=$this->webroot?>apToSupp/create">create</a></li>
	</ul>
	</li>
	
	<li><a href="#">Balance</a>
	<ul>
		<li><a href="<?=$this->webroot?>balance_by_cust/list_by_cust">List By Customer</a></li>
		<li><a href="<?=$this->webroot?>balance_by_cust/list_all">List All</a></li>
	</ul>
	</li>
	
	<li><a href="#">Customer</a>
	<ul>
		<li><a href="<?=$this->webroot?>customers/list_all">list</a></li>
		<li><a href="<?=$this->webroot?>customers/create">create</a></li>
	</ul>
	</li>
	
	<li><a href="">Supplier</a>
	<ul>
		<li><a href="<?=$this->webroot?>suppliers/list_all">list</a></li>
		<li><a href="<?=$this->webroot?>suppliers/create">create</a></li>
	</ul>
	</li>
	
	<li><a href="">Product</a>
	<ul>
		<li><a href="<?=$this->webroot?>products/list_all">list</a></li>
		<li><a href="<?=$this->webroot?>products/create">create</a></li>
	</ul>
	</li>
	
</ul>
</div>
</div>
</div>
