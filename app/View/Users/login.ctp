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
            <fieldset style='float:left;padding:3%;'><legend><h3>Login</h3></legend>
		<?php
                    echo $this->Form->create('User', array('action' => 'login', 'id'=>'user'));
                    echo $this->Form->input('username', array('label' => 'Usuario*', 'id'=>'username', 'class'=>'required alphanumeric', 'minlength' => '4'));
		?>
                <b>
		<?php
                    echo $this->Form->input('password', array('label' => 'Contrase&ntilde;a*', 'class'=>'required', 'minLength' => '6', 'id' => 'password'));
		?>
		<?php echo $this->element('captcha'); ?>
                    <span style='float:right'>
		<?php
                    echo $this->Form->end('Login');
		?>
                    </span>
            </fieldset>
        </td>
        <td style='text-align: center;'>
            <div style="padding: 3%;">
                <?php
                    echo $this->Html->image('../img/login02.png');				
                ?>
            </div>	
            <fieldset>
                <div style='text-decoration:underline;text-align:center;color:#0033CC; padding:3%'>
                    <?php
                            echo $this->Html->link('¿Olvidó su contraseña?', array('controller' => 'publicos', 'action' => 'enviar_pass'));
                    ?>
                </div>	
            </fieldset>
        </td>
    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(document).ready(function () {
        //código a ejecutar cuando el DOM está listo para recibir instrucciones.
        $('#user').validate();
    });
</script>
