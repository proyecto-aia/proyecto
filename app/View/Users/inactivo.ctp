<?php
/************************* ##### CSS ##### *************************/
echo $this->addScript($this->Html->css('reset'));		
echo $this->addScript($this->Html->css('cake.generic'));
echo $this->addScript($this->Html->css('menu'));
/************************* ##### UTILIZADOS ##### *************************/
/*** jQuery - Version ***/
echo $this->addScript($this->Html->script('jquery-1.8.3'));
/*** Elimina borde final de las tablas ***/
echo $this->addScript($this->Html->css('estilo_tablas'));         
?>
<?php echo $this->element('menu_inactivo'); ?>
<?php echo $this->Session->flash(); ?>

<table class="tabla_normal">
	<tr>	
		<td>
			<div style='width:60%'>
				<fieldset><legend><h3>Estado</h3></legend>
				
					<p><h2 style="font-size:190%">Usuario Inactivo</h2></p>
					<br/>
					<p><h1 style="font-size:110%">No tiene permitido realizar acciones en el Sistema.<br/>Comun&iacute;quese con el Administrador.</h1></p>
				
				</fieldset>
			</div>
		</td>		
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
});
</script>