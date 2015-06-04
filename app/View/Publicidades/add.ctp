<?php
/*** NO SE USA ESTA VISTA ***/

/************************* ##### CSS ##### *************************/
echo $this->addScript($this->Html->css('reset'));		
echo $this->addScript($this->Html->css('cake.generic'));
echo $this->addScript($this->Html->css('menu'));
/************************* ##### UTILIZADOS ##### *************************/
/*** jQuery - Version ***/
echo $this->addScript($this->Html->script('jquery-1.8.3'));
/*** Elimina borde final de las tablas ***/
echo $this->addScript($this->Html->css('estilo_tablas'));
/*** mask - Mascaras para campos ***/
echo $this->addScript($this->Html->script('jquery.mask'));
/*** Validate con estilos css modificados en el .js ***/
echo $this->addScript($this->Html->script('jquery.validate'));
echo $this->addScript($this->Html->script('jquery.corner'));           
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
	<tr>
		<td>
			<div style='width:70%'>
				<fieldset style='padding:3%;'>
					<legend><h3>Agregar Publicidad</h3></legend>
				<?php
					echo $form->create('Publicidade',array('type' => 'file', 'id' => 'agregar'));
					//echo $form->input('name', array('label' => 'Nombre', 'class' => 'required alphanumeric', 'id' => 'name'));
					echo $form->input('location', array('label' => 'Publicidad', 'type' => 'file', 'class' => 'required', 'id' => 'location')); 
				?>	
					<b><i>* Cargar un archivo con entensi&oacute;n jpg, jpeg, png o gif. </i></b>
					<br/><br/>
				<span style='float:right'>	
				<?php
					 echo $form->submit('Agregar', array('after' => ' ' . $html->link('Cancelar', array('action' => 'index'))));
				?>
				</span>
				</fieldset>
			</div>			
		</td>			
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#agregar').validate();
});
</script>