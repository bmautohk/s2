<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset();?>
	<title>
		<?php __('Superparts: Administration Tool'); ?>
		<?php echo $title_for_layout;?>
	</title>

	<link rel="icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon" />
	<?php //echo $this->Html->css('cake.generic');?>
    <?php 
	echo $html->css('1280_32_4_4.css');
    echo $html->css('reset.css');
    echo $html->css('css.css');
    echo $html->css('style.css');
    echo $javascript->link('jquery-1.4.3.min.js');?>
	<?php echo $scripts_for_layout;?>
</head>
<body> 
	<div> 
		<? echo $this->element('header'); ?>
	</div>

	<div class="row">
    	<div class="container_12"> 
			<? if (isset($success_msg)) { ?><div class="success_msg"><?=$success_msg?></div><? } ?>
            <? if (isset($error_msg)) { ?><div class="error_msg"><?=$error_msg?></div><? } ?>
		</div>
    </div>
	
	<?php $this->Session->flash();?>

    <?php echo $content_for_layout;?>

    <?php echo $this->element('sql_dump'); ?>
</body>
</html>