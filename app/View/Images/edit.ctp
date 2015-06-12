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
                    <legend><h3>Editar Imagen</h3></legend>
                    <?php
                    echo $this->Form->create('Image', array('type' => 'file', 'id' => 'editar'));
                    echo $this->Form->hidden('id');

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
                    echo $this->Form->hidden('location');

                    echo $this->Html->image('thumbnails/' . $image['Image']['location'], array('alt' => $image['Image']['name']));
                    ?>
                    <br /><br /><br />
                    <?php
                    echo $this->Form->input('description', array('label' => 'Descripci&oacute;n', 'id' => 'description'));
                    ?>
                    <span style='float:right'>
                        <?php
                        echo $this->Form->submit('Editar', array('after' => ' ' . $this->Html->link('Cancelar', array('action' => 'index'))));
                        ?>
                    </span>				
                </fieldset>
            </div>
        </td>		
    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(document).ready(function () {
        //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
        $('#editar').validate();
    });
</script>