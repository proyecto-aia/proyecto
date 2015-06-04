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
<?php echo $this->element('menu_publico'); ?>
<?php echo $this->Session->flash(); ?>

<table class="tabla_normal">
    <tr>
        <td>
            <fieldset style='float:left;padding:3%;'><legend><h3>Recuperar Contrase&ntilde;a</h3></legend>
                <fieldset>
                    <p style='text-align:center'><b>Se enviar&aacute; su contrase&ntilde;a <br/> a la cuenta de correo electr&oacute;nico <br/> que tenemos registrado en el Sistema</b></p>	
                </fieldset>
		<?php
		echo $this->Form->create('Publicos', array('action' => 'enviar_pass', 'id'=>'pass'));
		echo $this->Form->input('username', array('label' => 'Usuario*', 'id'=>'username', 'class'=>'required alphanumeric', 'minlength' => '4'));
		?>
		<?php echo $this->element('captcha'); ?>
                <span style='float:right'>
		<?php
		echo $this->Form->end('Enviar');
		?>
                </span>
            </fieldset>
        </td>
        <td>
            <?php
                echo $this->Html->image('../img/rec_pass01.png');			
            ?>	
        </td>
    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(document).ready(function () {
        //código a ejecutar cuando el DOM está listo para recibir instrucciones.
        $('#pass').validate();
    });
</script>