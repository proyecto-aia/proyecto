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
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
    <tr>
        <td>
            <div style='width:60%'>
                <fieldset style='padding:3%;'>
                    <legend><h3>Publicidad</h3></legend>

                    <table  class='tabla_normal'>
                        <!--
                                                        <tr>
                                                                <td style='text-align:right'><span><b>Nombre:</b></span></td>	
                                                                <td style='text-align:left'><span><?php //echo $publicidad['Publicidade']['name'];  ?></span></td>
                                                        </tr>
                        -->
                        <tr>
                            <td style='text-align:right'><span><b>Imagen:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $this->Html->image('thumbnails/' . $publicidad['Publicidade']['location'], array('alt' => $publicidad['Publicidade']['name'])); ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>Creada:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $publicidad['Publicidade']['created']; ?></span></td>
                        </tr>
                        <tr>
                            <td style='text-align:right'><span><b>Modificada:</b></span></td>	
                            <td style='text-align:left'><span><?php echo $publicidad['Publicidade']['modified']; ?></span></td>
                        </tr>							
                    </table>

                    <br/><br/>

                    <?php echo $this->Html->image('medium/' . $publicidad['Publicidade']['location'], array('alt' => $publicidad['Publicidade']['name'], 'style' => 'max-width:100%')); ?>

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

