<div class='warning' id='warning'  align='center'>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $message; ?>&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#warning').hide();
	$('#warning').show('slow');
	$('#warning').delay(8000);
	$('#warning').hide('slow');
});
</script>