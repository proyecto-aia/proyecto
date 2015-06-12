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
/* * * Carrusel de Imagenes ** */
echo $this->addScript($this->Html->script('jquery.fancybox-1.3.4.pack'));
echo $this->addScript($this->Html->script('jquery.easing-1.3.pack'));
echo $this->addScript($this->Html->script('jquery.mousewheel-3.0.4.pack'));
echo $this->addScript($this->Html->script('fancybox.impl'));
echo $this->addScript($this->Html->script('jquery.form'));
echo $this->addScript($this->Html->script('jquery.metadata'));
echo $this->addScript($this->Html->script('jquery.additional-methods'));
echo $this->addScript($this->Html->css(array('jquery.fancybox-1.3.4'), 'stylesheet', array('media' => 'screen')));
/* * * Alinea las imagenes a gestionar ** */
echo $this->addScript($this->Html->css('alineacion_imagenes'));
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
    <tr>	
        <td>
            <div style='width:75%'>
                <fieldset style='padding:3%;'><legend><h3>Producto</h3></legend>

                    <table>
                        <tr>
                            <td style='text-align:right'><span><b>Fecha:</b></span></td>	
                            <td style='text-align:left'><span><?php echo date('d-m-Y', strtotime($producto['Producto']['fecha'])); ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>T&iacute;tulo:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $producto['Producto']['titulo']; ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>C&oacute;digo:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $producto['Producto']['codigo']; ?></span></td>
                        </tr>                        
                        <tr>
                            <td style='text-align:right'><span><b>Descripci&oacute;n:</b></span></td>	
                            <td style='text-align:justify'><span><?php echo $producto['Producto']['descripcion']; ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>Moneda:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $producto['Moneda']['nombre']; ?></span></td>
                        </tr>                        
                        <tr>
                            <td style='text-align:right'><span><b>Precio Actual:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $producto['Moneda']['simbolo'] . " " . $producto['Producto']['precio_actual']; ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>Precio Anterior:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $producto['Moneda']['simbolo'] . " " . $producto['Producto']['precio_anterior']; ?></span></td>
                        </tr>                                                						
                        <tr>
                            <td style='text-align:right'><span><b>Estado:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $producto['Producto']['status']; ?></span></td>
                        </tr>						
                        <tr>
                            <td style='text-align:right'><span><b>Creado:</b></span></td>	
                            <td style='text-align:left'><span><?php echo date('d-m-Y', strtotime($producto['Producto']['created'])); ?></span></td>
                        </tr>	
                        <tr>
                            <td style='text-align:right'><span><b>Modificado:</b></span></td>	
                            <td style='text-align:left'><span><?php echo date('d-m-Y', strtotime($producto['Producto']['modified'])); ?></span></td>
                        </tr>							
                    </table>

                </fieldset>
            </div>

            <br/>		

            <div  style='width:75%'>
                <fieldset>
                    <legend><h3>Im&aacute;genes</h3></legend>
                    <?php
                    foreach ($producto['Image'] as $image):
                        ?>
                        <div class="thumb_img">
                            <?php
                            echo $this->Html->link(
                                    $this->Html->image('thumbnails/' . $image['location'], array('alt' => $image['name'])), '/img/medium/' . $image['location'], array('class' => 'grouped', 'rel' => 'group', 'title' => $image['description'], 'escape' => false)
                            );
                            ?>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>			
        </td>	
    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(document).ready(function () {
        //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
    });
</script>