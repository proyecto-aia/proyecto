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
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
    <tr>	
        <td>
            <div>
                <fieldset style='width:50%;margin-left:5%;padding:3%;font-size:110%'>
                    En el modulo "Gesti&oacute;n" Usted podr&aacute; administrar Noticias, Videos, Productos, Albums y Publicidades publicados en la p&aacute;gina de inicio del Sistema
                </fieldset>
                <br/><br/>
                    <?php
                        echo $this->Html->image('../img/prensa02.png', array('style' => 'margin-left:5%'));					
                    ?>
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