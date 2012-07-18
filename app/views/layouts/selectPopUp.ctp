<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
	if (isset($charset)) {
		echo $this->Html->charset($charset);
	}
	else {
		echo $this->Html->charset();
	}
	?>
	<title>
		<?php __('Superparts: Administration Tool'); ?>
		<?php echo $title_for_layout;?>
	</title>

	<link rel="icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon" />
    <?php echo $html->css('style.css');?>
    <? echo $javascript->link('jquery-1.4.3.min.js');?>
	<?php echo $scripts_for_layout;?>
</head>
<body>
	
	<?php $this->Session->flash();?>

<div class="row">
    <?php echo $content_for_layout;?>
	
	<div class="loading_div" id="loading_div" style="display: none;"></div>

	<div id="paging_div">
    	<? echo $this->element(strtolower($this->name).'/select_paging'); ?>
    </div>
</div>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>