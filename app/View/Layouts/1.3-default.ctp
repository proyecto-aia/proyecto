<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php echo $html->charset('utf-8'); ?>
	<title>
		<?php __('Config Sistemas'); ?>
		<?php //echo $title_for_layout; ?>
	</title>
	<?php        
        echo $this->Html->meta('icon',$this->Html->url('/img/favicon.png'));
        echo $scripts_for_layout;	
	?>    
</head>

<body> 
	<div id="container">	
		<div id="header">           
		</div>
		
		<div id="content">
				<!-- Content Elements Will Go Here -->
				<?php echo $content_for_layout ?>
		</div>

		<div id="footer">        
		</div>
	</div>
	<?php //echo $cakeDebug; ?>
</body>

</html>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
});
</script>