<?php
/************************* ##### CSS ##### *************************/
echo $this->addScript($this->Html->css('reset'));		
echo $this->addScript($this->Html->css('cake.generic'));
echo $this->addScript($this->Html->css('menu'));
/************************* ##### UTILIZADOS ##### *************************/
/*** jQuery - Version ***/
echo $this->addScript($this->Html->script('jquery-1.8.3'));
/*** Estilos para noticias ***/
echo $this->addScript($this->Html->css('noticia'));        
/*** Elimina borde final de las tablas ***/
echo $this->addScript($this->Html->css('estilo_tablas'));
/*** Alinea las imagenes a gestionar ***/
echo $this->addScript($this->Html->css('alineacion_imagenes'));
/*** Carrusel de Imagenes ***/
echo $this->addScript($this->Html->script('jquery.fancybox-1.3.4.pack'));
echo $this->addScript($this->Html->script('jquery.easing-1.3.pack'));
echo $this->addScript($this->Html->script('jquery.mousewheel-3.0.4.pack'));
echo $this->addScript($this->Html->script('fancybox.impl'));
echo $this->addScript($this->Html->script('jquery.form'));
echo $this->addScript($this->Html->script('jquery.metadata'));
echo $this->addScript($this->Html->script('jquery.additional-methods'));
echo $this->addScript($this->Html->css(array('jquery.fancybox-1.3.4'), 'stylesheet', array('media' => 'screen')));/*** Cubo de Imagenes ***/
echo $this->addScript($this->Html->script('jquery.movingboxes'));
echo $this->addScript($this->Html->script('jquery.imagecube'));
echo $this->addScript($this->Html->css('basicCube'));            
?>
<?php echo $this->element('menu_publico'); ?>
<?php echo $this->Session->flash(); ?>

<table class="tabla_normal">
    <tr>        	
        <td style='width: 75%;'>
            <fieldset style='padding:2%'>
                <div class='noticia_fecha_view'><?php echo date('d-m-Y',strtotime($noticia['Noticia']['fecha'])); ?></div>
                <div class='noticia_titulo_view'><?php echo $noticia['Noticia']['titulo']; ?></div>
                <div class='noticia_resumen'><?php echo $noticia['Noticia']['resumen']; ?></div>
                <br/>
                <table class="tabla_imagenes">
                    <tr>
                        <td class="noticia_imagenes_fondo">
                            <?php
                                foreach ($noticia['Image'] as $image):
                            ?>
                            <div class="thumb_img" style="padding:0px; margin:8px;">
                                <?php 
                                    echo $this->Html->link($this->Html->image('thumbnails/' . $image['location'], array('alt' => $image['name'])), '/img/medium/' . $image['location'], array('class' => 'grouped', 'rel' => 'group', 'title' => $image['description'],'escape' => false)); 
                                ?>
                            </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>
                <br/>
                <div class='noticia_contenido'><?php echo $noticia['Noticia']['contenido']; ?></div>
                <br/><br/>
                <div class='noticia'>
                    <div class='noticia_link'><?php echo $this->Html->link('Volver', array('action' => 'index')); ?></div>
                </div>
            </fieldset>			
        </td>

        <td>
            <?php 
                if (count($publicidades)>0){
            ?>
            <div id="basicCube">
                <?php
                    foreach ($publicidades as $publicidad) {
                        echo $this->Html->image('medium/' . $publicidad['Publicidade']['location'], array('alt' => $publicidad['Publicidade']['name'], 'style' => 'border:1px solid #999999'));	
                            //echo "&nbsp&nbsp";
                            //echo $this->Html->image('../img/publicite_aqui.gif', array( 'style' => 'width:50px;height:35px'));
                    }
                ?>
            </div>
            <?php
                }
            ?>      
        </td>

    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(document).ready(function () {
        //código a ejecutar cuando el DOM está listo para recibir instrucciones.
        $('#basicCube').imagecube();
    });
</script>

