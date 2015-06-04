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
<?php echo $this->element('menu_cambiarpass'); ?>
<?php echo $this->Session->flash(); ?>

<table class="tabla_normal">
	<tr>
		<td>
		    <fieldset style='padding:3%;'><legend><h3>Modificar Contrase&ntilde;a</h3></legend>
		<?php
		echo $form->create('User', array('id' => 'modificar'));
		echo $form->hidden('id');
		echo $form->hidden('username');
		?>
		<b>
		<?php
		echo $form->input('old_password', array('type' => 'password', 'label' => 'Contrase&ntilde;a Actual*', 'class' => 'required', 'minLength' => '6', 'id' => 'old_password'));
		?>
		</b>
		<?php
		echo $form->input('clear_password', array('type' => 'password', 'label' => 'Nueva Contrase&ntilde;a', 'class' => 'required', 'minLength' => '6', 'id' => 'clear_password'));
		echo $form->input('confirm_password', array('type' => 'password', 'label' => 'Confirmar Nueva Contrase&ntilde;a', 'class' => 'required', 'minLength' => '6', 'id' => 'confirm_password'));
		echo $form->hidden('first_name');
		echo $form->hidden('last_name');
		echo $form->hidden('email');
		echo $form->hidden('status', array('options' => array('Activo' => 'Activo', 'Inactivo' => 'Inactivo')));
		echo $form->hidden('role_id', array('label' => 'Tipo de Usuario', 'type' => 'select', 'options' => $roles));
		?>
		<span style='float:right'>
		<?php		
		echo $form->submit('Modificar', array('after' => ' ' . $html->link('Cancelar', array('action' => 'index'))));
		?>
		</span>
		<?php		
		echo $form->end();
		?>		
		      </fieldset>
		</td>	
	
		<td>
			<fieldset style='padding:5%;'><legend><h3>Informaci&oacute;n</h3></legend>

				<table  class='tabla_normal'>
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
		</td>
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#modificar').validate();
});
</script>