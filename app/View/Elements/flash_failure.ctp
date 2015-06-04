<div class='failure' id='failure' align='center'>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $message; ?>&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#failure').hide();
	$('#failure').show('slow');
	$('#failure').delay(8000);
	$('#failure').hide('slow');
});
</script>