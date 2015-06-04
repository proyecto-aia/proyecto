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
			<div style='width:50%'>
				<fieldset style='padding:3%;'><legend><h3>Editar Enlace a Video</h3></legend>
		<?php
		echo $form->create('Video', array('id' => 'editar'));
		echo $form->hidden('id');
		echo $form->input('name', array('label' => 'Nombre', 'class' => 'required', 'minLength' => '3', 'id' => 'nombre'));
		//echo $form->input('link', array('type' => 'textarea', 'label' => 'Enlace a Video Youtube', 'class' => 'required', 'id' => 'link'));
        echo $form->input('link', array('label' => 'Enlace a Video Youtube', 'class' => 'required', 'rows' => '2', 'id' => 'link'));
		echo $form->input('description', array('label' => 'Descripci&oacute;n', 'id' => 'description'));
		?>
		<span style='float:right'>
		<?php		
		echo $form->submit('Editar', array('after' => ' ' . $html->link('Cancelar', array('action' => 'index'))));
		?>
		</span>
		<?php		
		echo $form->end();
		?>
				</fieldset>
			</div>
		</td>		
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //c�digo a ejecutar cuando el DOM est� listo para recibir instrucciones.
	$('#editar').validate();
});
</script>