<div class='info' id='info' align='center'>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $message; ?>&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#info').hide();
	$('#info').show('slow');
	$('#info').delay(8000);
	$('#info').hide('slow');
});
</script>