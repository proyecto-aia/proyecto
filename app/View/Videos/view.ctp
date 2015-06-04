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
/*** Estilo para video de Youtube ***/
echo $this->addScript($this->Html->script('swfobject'));
echo $this->addScript($this->Html->css('video'));           
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
	<tr>
		<td>
			<div style='width:70%'>
				<fieldset style='padding:3%;'><legend><h3>Video</h3></legend>

					<table  class='tabla_normal'>
						<tr>
							<td style='text-align:right'><span><b>Nombre:</b></span></td>	
							<td style='text-align:left'><span><?php echo $video['Video']['name']; ?></span></td>
						</tr>
						<tr>
							<td style='text-align:right'><span><b>Descripci&oacute;n:</b></span></td>	
							<td style='text-align:left'><span><?php echo $video['Video']['description']; ?></span></td>
						</tr>						
					</table>
				
				</fieldset>
			</div>

			<div style='width:70%'>	
				<fieldset style='padding:3%;'>			
					<iframe class="youtube-player" type="text/html" width="640" height="385" src="http://www.youtube.com/embed/<?php echo $codigo; ?>" frameborder="0">
					</iframe>
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

