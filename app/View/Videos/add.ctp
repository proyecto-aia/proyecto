<?php
/* * *********************** ##### CSS ##### ************************ */
echo $this->addScript($this->Html->css('reset'));
echo $this->addScript($this->Html->css('cake.generic'));
echo $this->addScript($this->Html->css('menu'));
/* * *********************** ##### UTILIZADOS ##### ************************ */
/* * * jQuery - Version ** */
echo $this->addScript($this->Html->script('jquery-1.8.3'));
/* * * Elimina borde final de las tablas ** */
echo $this->addScript($this->Html->css('estilo_tablas'));
/* * * mask - Mascaras para campos ** */
echo $this->addScript($this->Html->script('jquery.mask'));
/* * * Validate con estilos css modificados en el .js ** */
echo $this->addScript($this->Html->script('jquery.validate'));
echo $this->addScript($this->Html->script('jquery.corner'));
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
    <tr>	
        <td>
            <div style='width:50%'>
                <fieldset style='padding:3%;'><legend><h3>Agregar Enlace a Video</h3></legend>
                    <?php
                    echo $this->Form->create('Video', array('id' => 'agregar'));
                    echo $this->Form->input('name', array('label' => 'Nombre', 'class' => 'required', 'minLength' => '3', 'id' => 'name'));
                    //echo $this->Form->input('link', array('type' => 'textarea', 'label' => 'Enlace a Video Youtube', 'class' => 'required', 'id' => 'link'));
                    echo $this->Form->input('link', array('label' => 'Enlace a Video Youtube', 'class' => 'required', 'rows' => '2', 'id' => 'link'));
                    echo $this->Form->input('description', array('label' => 'Descripci&oacute;n', 'id' => 'description'));
                    ?>
                    <span style='float:right'>
                        <?php
                        echo $this->Form->submit('Agregar', array('after' => ' ' . $this->Html->link('Cancelar', array('action' => 'index'))));
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
    $(document).ready(function () {
        //código a ejecutar cuando el DOM está listo para recibir instrucciones.
        $('#agregar').validate();
    });
</script>