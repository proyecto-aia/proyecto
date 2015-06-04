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
<?php echo $this->element('menu_administrador'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
	<tr>
		<td>
			<div style='width:40%'>
				<fieldset style='padding:3%;'><legend><h3>Editar Usuario</h3></legend>
		<?php
		echo $form->create('User', array('id' => 'editar'));
		echo $form->hidden('id');
		echo $form->input('username', array('label' => 'Usuario', 'class' => 'required alphanumeric', 'minlength' => '4', 'id' => 'username'));
		echo $form->input('clear_password', array('type' => 'password', 'label' => 'Nueva Contrase&ntilde;a', 'minLength' => '6', 'id' => 'clear_password'));
		echo $form->input('confirm_password', array('type' => 'password', 'label' => 'Confirmar Nueva Contrase&ntilde;a', 'minLength' => '6', 'id' => 'confirm_password'));
		echo $form->input('first_name', array('label' => 'Nombres', 'id' => 'first_name'));
		echo $form->input('last_name', array('label' => 'Apellidos', 'id' => 'last_name'));
		echo $form->input('email', array('label' => 'E-Mail', 'class' => 'required email', 'id' => 'email'));
		echo $form->input('role_id', array('label' => 'Tipo de Usuario', 'type' => 'select', 'options' => $roles, 'id' => 'role_id'));
		echo $form->input('status', array('options' => array('Activo' => 'Activo', 'Inactivo' => 'Inactivo'), 'label' => 'Estado', 'id' => 'status'));
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
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#editar').validate();
});


</script>