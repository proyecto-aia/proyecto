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
<?php echo $this->element('menu_administrador'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
	<tr>	
		<td>
			<div style='width:42%'>
				<fieldset style='padding:3%;'><legend><h3>Informaci&oacute;n</h3></legend>
				
					<table class='tabla_normal'>
						<tr>
							<td style='text-align:right'><span><b>Usuario:</b></span></td>	
							<td style='text-align:left'><span><?php echo $user['User']['username']; ?></span></td>
						</tr>
						<tr>
							<td style='text-align:right'><span><b>Nombre:</b></span></td>	
							<td style='text-align:left'><span><?php echo $user['User']['first_name']; ?></span></td>
						</tr>
						<tr>
							<td style='text-align:right'><span><b>Apellido:</b></span></td>	
							<td style='text-align:left'><span><?php echo $user['User']['last_name']; ?></span></td>
						</tr>
						<tr>
							<td style='text-align:right'><span><b>E-Mail:</b></span></td>	
							<td style='text-align:left'><span><?php echo $user['User']['email']; ?></span></td>
						</tr>						
						<tr>
							<td style='text-align:right'><span><b>Rol:</b></span></td>	
							<td style='text-align:left'><span><?php echo $user['Role']['nombre']; ?></span></td>
						</tr>						
						<tr>
							<td style='text-align:right'><span><b>Estado:</b></span></td>	
							<td style='text-align:left'><span><?php echo $user['User']['status']; ?></span></td>
						</tr>
				
					</table>
					
				</fieldset>
			</div>
		</td>		
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
});
</script>

