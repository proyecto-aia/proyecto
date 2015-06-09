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
		echo $this->Form->create('User', array('id' => 'modificar'));
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('username');
		?>
		<b>
		<?php
		echo $this->Form->input('old_password', array('type' => 'password', 'label' => 'Contrase&ntilde;a Actual*', 'class' => 'required', 'minLength' => '6', 'id' => 'old_password'));
		?>
		</b>
		<?php
		echo $this->Form->input('clear_password', array('type' => 'password', 'label' => 'Nueva Contrase&ntilde;a', 'class' => 'required', 'minLength' => '6', 'id' => 'clear_password'));
		echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => 'Confirmar Nueva Contrase&ntilde;a', 'class' => 'required', 'minLength' => '6', 'id' => 'confirm_password'));
		echo $this->Form->hidden('first_name');
		echo $this->Form->hidden('last_name');
		echo $this->Form->hidden('email');
		echo $this->Form->hidden('status', array('options' => array('Activo' => 'Activo', 'Inactivo' => 'Inactivo')));
		echo $this->Form->hidden('role_id', array('label' => 'Tipo de Usuario', 'type' => 'select', 'options' => $roles));
		?>
		<span style='float:right'>
		<?php		
		echo $this->Form->submit('Modificar', array('after' => ' ' . $this->Html->link('Cancelar', array('action' => 'index'))));
		?>
		</span>
		<?php		
		echo $this->Form->end();
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
   //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
	$('#modificar').validate();
});
</script>