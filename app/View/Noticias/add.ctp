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

/* * * datePicker - Calendario ** */
echo $this->addScript($this->Html->script('jquery-ui'));
echo $this->addScript($this->Html->script('jquery-ui.datepicker'));
echo $this->addScript($this->Html->css('jquery-ui'));

/* * * tinymce - Editor de texto ** */
echo $this->addScript($this->Html->script('../js/tinymce/tinymce.min'));
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>


<table class='tabla_normal'>
    <tr>
        <td>
            <div style='width:75%'>
                <fieldset style='padding:3%;'><legend><h3>Agregar nueva Noticia</h3></legend>
                    <?php
                    echo $this->Form->create('Noticia', array('id' => 'agregar'));
                    
                    echo $this->Form->input('fecha', array(   'id'=>'datepicker1',  /*Id que llamara al script de "datepicker"*/
                                                              'type'=>'text',
                                                              'placeholder' => 'Seleccione una fecha...',
                                                              'readonly' => 'readonly'
                                                              /*'class' => 'required'*/));
                  
                    echo $this->Form->input('titulo', array('label' => 'T&iacute;tulo', 'class' => 'required', 'minLength' => '3', 'id' => 'titulo'));
                    echo $this->Form->input('resumen', array('type' => 'textarea', 'label' => 'Resumen', 'class' => 'required', 'minLength' => '3', 'rows' => '2', 'id' => 'resumen'));
                    //echo $this->Form->input('resumen', array('label' => 'Resumen', 'class' => 'required', 'minLength' => '3', 'id' => 'resumen'));
                    echo $this->Form->input('contenido', array('type' => 'textarea', 'label' => 'Contenido', 'class' => 'required', 'minLength' => '3', 'id' => 'contenido'));
                    echo $this->Form->input('status', array('options' => array('Activa' => 'Activa', 'Inactiva' => 'Inactiva'), 'label' => 'Estado', 'id' => 'status'));
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
        //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
        $('#agregar').validate();

        jQuery(function ($) {
            tinymce.init({
                mode: "exact",
                elements: "contenido",
                plugins: [
                    "link print preview paste"
                ],
                paste_auto_cleanup_on_paste: true,
                invalid_elements: "span",
                paste_data_images: false,
                toolbar: "",
                statusbar: false,
                language: "es",
                element_format: "html",
                height: 280,
                readonly: false

                        // Las siguientes opciones no son necesarias:
                        /*
                         toolbar: "none",
                         menubar : false,
                         skin : "lightgray",
                         paste_strip_class_attributes : "all",
                         paste_remove_styles: true,
                         cleanup : true,
                         paste_convert_middot_lists: false
                         */
            });
        });
    });
</script>