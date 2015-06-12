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
/* * * alertify - Alertas ** */
echo $this->addScript($this->Html->script('alertify'));
echo $this->addScript($this->Html->script('funciones_alertify'));
echo $this->addScript($this->Html->css('alertify.core'));
echo $this->addScript($this->Html->css('alertify.default'));
/* * * Alinea las imagenes a gestionar ** */
echo $this->addScript($this->Html->css('alineacion_imagenes'));
/* * * Estilos para botone/iconos/etc... ** */
echo $this->addScript($this->Html->css('button'));
/* * * Carrusel de Imagenes ** */
echo $this->addScript($this->Html->script('jquery.fancybox-1.3.4.pack'));
echo $this->addScript($this->Html->script('jquery.easing-1.3.pack'));
echo $this->addScript($this->Html->script('jquery.mousewheel-3.0.4.pack'));
echo $this->addScript($this->Html->script('fancybox.impl'));
echo $this->addScript($this->Html->script('jquery.form'));
echo $this->addScript($this->Html->script('jquery.metadata'));
echo $this->addScript($this->Html->script('jquery.additional-methods'));
echo $this->addScript($this->Html->css(array('jquery.fancybox-1.3.4'), 'stylesheet', array('media' => 'screen')));
?>
<?php
switch ($modulo) {
    case 'Noticia':
        echo $this->element('menu_imagen_noticia');
        break;
    case 'Producto':
        echo $this->element('menu_imagen_producto');
        break;
    case 'Album':
        echo $this->element('menu_imagen_album');
        break;
}
?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
    <tr>
        <td>
            <div style='width:70%'>
                <fieldset>
                    <legend><h3><?php echo $modulo; ?></h3></legend>
                    <div style="padding: 1%;">                        
                        <b><?php echo $modulo_titulo ?></b>
                        <?php
                        switch ($modulo) {
                            case 'Producto':
                                echo "<br/><br/><b><u>C&oacute;digo:</u></b>" . " " . $modulo_codigo;
                                break;
                        }
                        ?>                        
                    </div>
                </fieldset>		
                <br />            
                <fieldset style='padding:3%;'>
                    <legend><h3>Agregar Imagen</h3></legend>
                    <?php
                    echo $this->Form->create('Image', array('type' => 'file', 'id' => 'agregar'));

                    switch ($modulo) {
                        case 'Noticia':
                            echo $this->Form->hidden('noticia_id', array('value' => $modulo_id));
                            break;
                        case 'Producto':
                            echo $this->Form->hidden('producto_id', array('value' => $modulo_id));
                            break;
                        case 'Album':
                            echo $this->Form->hidden('album_id', array('value' => $modulo_id));
                            break;
                    }
                    //echo $this->Form->input('name', array('label' => 'Nombre', 'class' => 'required alphanumeric', 'id' => 'name'));
                    echo $this->Form->input('location', array('label' => 'Imagen', 'type' => 'file', 'class' => 'required', 'id' => 'location'));
                    ?>	
                    <b><i>* Cargar un archivo con entensi&oacute;n jpg, jpeg, png o gif. </i></b>
                    <br/><br/>	
                    <?php
                    echo $this->Form->input('description', array('type' => 'textarea', 'rows' => '2', 'label' => 'Descripci&oacute;n', 'id' => 'description'));
                    ?>
                    <span style='float:right'>
                        <?php
                        echo $this->Form->submit('Agregar', array('after' => ' ' . $this->Html->link('Cancelar', array('action' => 'index'))));
                        ?>
                    </span>
                </fieldset>
            </div>	        
            <div style="width: 90%;">
                <fieldset>
                    <legend><h3>Im&aacute;genes</h3></legend>

                    <?php
                    $i = 0;
                    foreach ($images['Image'] as $image) {
                        ?>
                        <div class="thumb_img">
                            <?php
                            $i++;

                            echo $this->Html->link(
                                    $this->Html->image('thumbnails/' . $image['location'], array('alt' => $image['name'])), '/img/medium/' . $image['location'], array('class' => 'grouped', 'rel' => 'group', 'title' => $image['description'], 'escape' => false)
                            );
                            ?>
                            <div style="padding-top: 5px;">
                                <?php
                                //echo $this->Html->link(__('Ver', true), array('action' => 'view', $image['id']), array('class' => 'thumb_img_action')); 
                                echo $this->Html->image('../img/icons/Magnifier.png', array('url' => array('action' => 'view', $image['id']), 'class' => 'button1', 'title' => 'Ver'));
                                ?>
                                &nbsp;
                                <?php
                                //echo $this->Html->link(__('Editar', true), array('action' => 'edit', $image['id']), array('class' => 'thumb_img_action'));
                                echo $this->Html->image('../img/icons/Pencil.png', array('url' => array('action' => 'edit', $image['id']), 'class' => 'button1', 'title' => 'Editar'));
                                ?>
                                &nbsp;
                                <?php
                                //echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $image['id']), array('class' => 'thumb_img_action', 'id' => 'eliminar'.$i , 'onclick' => 'return confirmar_eliminar(eliminar'.$i.');'));
                                echo $this->Html->image('../img/icons/Cross.png', array('url' => array('action' => 'delete', $image['id']), 'class' => 'button1', 'id' => 'eliminar' . $i, 'onclick' => 'return confirmar_eliminar(eliminar' . $i . ');', 'title' => 'Eliminar'));
                                ?>
                            </div>			
                        </div>

                    <?php } ?>
                    <br clear="left" />
                    <p style='padding:3%'>
                        <i><?php
                            //echo $this->Paginator->counter(array('format' => __('Se muestran '.$i.' registro\s.', true)));
                            echo "Se muestran " . $i . " registro\s.";
                            ?></i>
                    </p>

                </fieldset>
            </div>			
        </td>
    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(document).ready(function () {
        //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
        $("#agregar").validate({
            submitHandler: function (form) {
                // do other stuff for a valid form 
                loading("Agregando Imagen...");
                form.submit();
            }
        });
    });

    function confirmar_eliminar($link) {
        confirmar_individual("\xbfEst\xe1 seguro que desea eliminar la Imagen seleccionada?", $link);
        return false;
    }
</script>