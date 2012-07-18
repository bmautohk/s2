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
    <?php echo $html->css('960.css');?>
    <?php echo $html->css('style.css');?>
	<?php echo $scripts_for_layout;?>
</head>
<body>

<?php echo $content_for_layout;?>

<?php echo $this->element('sql_dump'); ?>
</body>
</html>