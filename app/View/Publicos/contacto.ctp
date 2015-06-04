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
        <td style='width:35%;'>
            <div id='contacto'>
                <fieldset  style='padding:3%;'><legend><h3>Contacto</h3></legend>
		<?php
			echo $this->Form->create('Publicos', array('action' => 'contacto', 'id' => 'contact'));
			echo $this->Form->input('name',array('label' => 'Nombre*', 'class' => 'required', 'id' => 'name'));
			echo $this->Form->input('email',array('label' => 'E-Mail*', 'class' => 'required email', 'id' => 'email'));
			echo $this->Form->input('subject',array('label' => 'Asunto*', 'class' => 'required', 'id' => 'subject'));
			echo $this->Form->input('message',array('type' => 'textarea', 'label' => 'Mensaje*', 'class' => 'required', 'id' => 'message'));
		?>	
		<?php echo $this->element('captcha'); ?>
                    <span style='float:right'>
		<?php
			echo $this->Form->submit('Enviar');
		?>
                    </span>
		<?php				
			echo $this->Form->end(); 
		?>
                </fieldset>
            </div>
        </td>
        <td style='font-size:120%'>
			<?php
				echo $this->Html->image('../img/contacto02.png', array('style' => 'margin-left:10%;'));				
			?>
            <fieldset style='padding:3%;'>
                Cont&aacute;ctenos. Env&iacute;enos su consulta, sugerencia o inquietud. Nos comunicaremos con usted para poner nuestros conocimientos y experiencia a su disposi&oacute;n y ayudarlo en todo lo que est&eacute; a nuestro alcance.
                Telef&oacute;nicamente al <b>(Tel&eacute;fono de la Empresa)</b>. Si llama desde el exterior deber&aacute; marcar <b>+54 </b><b>(Tel&eacute;fono de la Empresa)</b>. O si prefiere v&iacute;a e-mail a <b>usuario@cliente.com</b>, o complete el siguiente formulario y env&iacute;enos directamente su consulta.
                No dude en contactarnos. Con gusto responderemos a su consulta.<br/><br/><br/>

                <b>Nuestras Oficinas</b><br/>
                <i>Calle Nro. (<i>CP</i>)</i><br/>
                <i>Paran&aacute; - Entre R&iacute;os - Rep&uacute;blica Argentina</i><br/><br/>

                <b>Tel&eacute;fonos</b><br/>
                <i>88888888 - 88888888 - 88888888 - 88888888</i><br/><br/>

                <b>Si llama desde el exterior</b><br/>
                <i>0054 </i><i>343 88888888 - 88888888 - 88888888 - 88888888</i><br/><br/>

                <b>E-mail</b><br/>
                <i>usuario@cliente.com</i>
            </fieldset>
        </td>
    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(document).ready(function () {
        //código a ejecutar cuando el DOM está listo para recibir instrucciones.
        $('#contact').validate();
    });
</script>