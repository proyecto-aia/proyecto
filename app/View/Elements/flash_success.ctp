<div class='success' id='success' align='center'>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $message; ?>&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#success').hide();
	$('#success').show('slow');
	$('#success').delay(8000);
	$('#success').hide('slow');
});
</script>
