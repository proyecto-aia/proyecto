<?php
/* * *********************** ##### CSS ##### ************************ */
echo $this->addScript($this->Html->css('reset'));
echo $this->addScript($this->Html->css('cake.generic'));
echo $this->addScript($this->Html->css('menu'));
/* * *********************** ##### JS ##### ************************ */
echo $this->addScript($this->Html->script('funciones_varias'));
/* * *********************** ##### UTILIZADOS ##### ************************ */
/* * * jQuery - Version ** */
echo $this->addScript($this->Html->script('jquery-1.8.3'));
/* * * Elimina borde final de las tablas ** */
echo $this->addScript($this->Html->css('estilo_tablas'));
/* * * alertify - Alertas ** */
echo $this->addScript($this->Html->script('alertify'));
echo $this->addScript($this->Html->script('funciones_alertify'));
echo $this->addScript($this->Html->css('alertify.core'));
echo $this->addScript($this->Html->css('alertify.default'));
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
    <tr>
        <td width="75%">
            <div>
                <fieldset  style='padding:3%;'><legend><h3>Enviar Album</h3></legend>

                    <table  class='tabla_normal'>
                        <tr>
                            <td width="75%">
                                <table  class='tabla_normal'>    

                                    <tr>
                                        <td style='text-align:right'><span><b>Fecha:&nbsp;&nbsp;&nbsp;</b></span></td>	
                                        <td style='text-align:left'><span><?php echo date('d-m-Y', strtotime($album['Album']['fecha'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td style='text-align:right'><span><b>T&iacute;tulo:&nbsp;&nbsp;&nbsp;</b></span></td>	
                                        <td style='text-align:left'><span><?php echo $album['Album']['titulo']; ?></span></td>
                                    </tr>
                                </table>                           
                            </td>

                            <td>
                                <?php
                                if ($album['Image'] != null) {
                                    echo $this->Html->image('thumbnails/' . $album['Image'][0]['location'], array('alt' => $album['Image'][0]['name']));
                                }
                                ?>                             
                            </td>
                        </tr>

                    </table>

                    <br/><br /><br />

                    <div>
                        <fieldset>               
                            <?php
                            echo $this->Form->create('Album', array('action' => 'send', 'id' => 'form_send', 'onsubmit' => 'return verificar_checkbox_vacio();'));
                            echo $this->Form->hidden('id_album', array('value' => $album['Album']['id']));
                            ?>
                            <table class='tabla_normal' id="tabla_seleccion">
                                <tr>
                                    <td>                    
                                        <?php
                                        echo $this->Form->input('directores', array('type' => 'checkbox', 'label' => 'Directores', 'id' => 'CheckDirectores'));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $this->Form->input('postulantes', array('type' => 'checkbox', 'label' => 'Postulantes', 'id' => 'CheckPostulantes'));
                                        ?>   
                                    </td>
                                    <td>
                                        <?php
                                        echo $this->Form->input('empresas', array('type' => 'checkbox', 'label' => 'Empresas', 'id' => 'CheckEmpresas'));
                                        ?>                             
                                    </td>
                                </tr>
                                <tr>
                                    <td>                    
                                        <?php
                                        echo $this->Form->input('uvts', array('type' => 'checkbox', 'label' => 'UVTs', 'id' => 'CheckUvts'));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $this->Form->input('beneficiarias', array('type' => 'checkbox', 'label' => 'Entidades Beneficiarias', 'id' => 'CheckBeneficiarias'));
                                        ?>   
                                    </td>
                                    <td>
                                        <?php
                                        echo $this->Form->input('instituciones', array('type' => 'checkbox', 'label' => 'Instituciones', 'id' => 'CheckInstituciones'));
                                        ?>                             
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        echo $this->Form->input('municipios', array('type' => 'checkbox', 'label' => 'Municipios y Comunas', 'id' => 'CheckMunicipios'));
                                        ?>                                 
                                    </td>
                                </tr>
                            </table>
                            <br />
                            <span style='float:right'>
                                <?php
                                echo $this->Form->submit('Enviar', array('after' => ' ' . $this->Html->link('Cancelar', array('action' => 'index'))));
                                ?>
                            </span>
                            <?php
                            echo $this->Form->end();
                            ?>                    
                        </fieldset>
                    </div>

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

    function verificar_checkbox_vacio() {
        //Esta funcion la podemos encontrar en funciones_varias.js
        var checkeados = verificar_checkbox('tabla_seleccion', 'Check');

        if (checkeados) {
            confirmar_varios("\xbfEst\xe1 seguro que desea enviar el Album seleccionado?", "form_send");
            return false; //para que no se dispare el submit, asi escucha al confirm nuevo

        } else {
            alerta("Para enviar debe seleccionar al menos un \xEDtem");
            return false; //para que no se dispare el submmit, asi escucha al confirm nuevo
        }
    }
</script>