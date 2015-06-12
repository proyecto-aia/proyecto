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
            <div style='width:75%;'>
                <fieldset style='padding:3%;'><legend><h3>Noticia</h3></legend>
                    <table>
                        <tr>
                            <td style='text-align:right'><span><b>Fecha:</b></span></td>	
                            <td style='text-align:left'><span><?php echo date('d-m-Y', strtotime($noticia['Noticia']['fecha'])); ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>T&iacute;tulo:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $noticia['Noticia']['titulo']; ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>Resumen:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $noticia['Noticia']['resumen']; ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>Contenido:</b></span></td>	
                            <td style='text-align:justify'><span><?php echo $noticia['Noticia']['contenido']; ?></span></td>
                        </tr>						
                        <tr>
                            <td style='text-align:right'><span><b>Estado:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $noticia['Noticia']['status']; ?></span></td>
                        </tr>						
                        <tr>
                            <td style='text-align:right'><span><b>Creada:</b></span></td>	
                            <td style='text-align:left'><span><?php echo date('d-m-Y', strtotime($noticia['Noticia']['created'])); ?></span></td>
                        </tr>	
                        <tr>
                            <td style='text-align:right'><span><b>Modificada:</b></span></td>	
                            <td style='text-align:left'><span><?php echo date('d-m-Y', strtotime($noticia['Noticia']['modified'])); ?></span></td>
                        </tr>							
                    </table>
                </fieldset>
            </div>
            <br/>
            <div  style='width:75%'>
                <fieldset>
                    <legend><h3>Im&aacute;genes</h3></legend>
                    <?php
                    foreach ($noticia['Image'] as $image):
                        ?>
                        <div class="thumb_img">
                            <?php
                            echo $this->Html->link($this->Html->image('thumbnails/' . $image['location'], array('alt' => $image['name'])), '/img/medium/' . $image['location'], array('class' => 'grouped', 'rel' => 'group', 'title' => $image['description'], 'escape' => false));
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
        //código a ejecutar cuando el DOM está listo para recibir instrucciones.
    });
</script>