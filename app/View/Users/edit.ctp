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
		echo $this->Form->create('User', array('id' => 'editar'));
		echo $this->Form->hidden('id');
		echo $this->Form->input('username', array('label' => 'Usuario', 'class' => 'required alphanumeric', 'minlength' => '4', 'id' => 'username'));
		echo $this->Form->input('clear_password', array('type' => 'password', 'label' => 'Nueva Contrase&ntilde;a', 'minLength' => '6', 'id' => 'clear_password'));
		echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => 'Confirmar Nueva Contrase&ntilde;a', 'minLength' => '6', 'id' => 'confirm_password'));
		echo $this->Form->input('first_name', array('label' => 'Nombres', 'id' => 'first_name'));
		echo $this->Form->input('last_name', array('label' => 'Apellidos', 'id' => 'last_name'));
		echo $this->Form->input('email', array('label' => 'E-Mail', 'class' => 'required email', 'id' => 'email'));
		echo $this->Form->input('role_id', array('label' => 'Tipo de Usuario', 'type' => 'select', 'options' => $roles, 'id' => 'role_id'));
		echo $this->Form->input('status', array('options' => array('Activo' => 'Activo', 'Inactivo' => 'Inactivo'), 'label' => 'Estado', 'id' => 'status'));
		?>
		<span style='float:right'>
		<?php		
		echo $this->Form->submit('Editar', array('after' => ' ' . $this->Html->link('Cancelar', array('action' => 'index'))));
		?>
		</span>
		<?php
		echo $this->Form->end();
		?>
				</fieldset>
			</div>
		</td>		
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
	$('#editar').validate();
});


</script>