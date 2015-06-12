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
/* * * mask - Mascaras para campos ** */
echo $this->addScript($this->Html->script('jquery.mask'));
/* * * Validate con estilos css modificados en el .js ** */
echo $this->addScript($this->Html->script('jquery.validate'));
echo $this->addScript($this->Html->script('jquery.corner'));
/* * * dataTables - Estilo tabla de registros ** */
echo $this->addScript($this->Html->script('swfobject'));
echo $this->addScript($this->Html->script('jquery.dataTables'));
echo $this->addScript($this->Html->script('../js/TableTools/media/js/TableTools'));
echo $this->addScript($this->Html->script('../js/TableTools/media/js/ZeroClipboard'));
echo $this->addScript($this->Html->script('paginador'));
echo $this->addScript($this->Html->css('jquery.dataTables'));
echo $this->addScript($this->Html->css('../js/TableTools/media/css/TableTools'));
//echo $this->Html->css('../js/TableTools/media/css/TableTools_JUI');        
/* * * alertify - Alertas ** */
echo $this->addScript($this->Html->script('alertify'));
echo $this->addScript($this->Html->script('funciones_alertify'));
echo $this->addScript($this->Html->css('alertify.core'));
echo $this->addScript($this->Html->css('alertify.default'));
/* * * datePicker - Calendario ** */
echo $this->addScript($this->Html->script('jquery.datePicker'));
echo $this->addScript($this->Html->script('date'));
echo $this->addScript($this->Html->script('cake.datePicker'));
echo $this->addScript($this->Html->css('datePicker'));
/* * * Estilos para botone/iconos/etc... ** */
echo $this->addScript($this->Html->css('button'));
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
    <tr>
        <td>
            <div>
                <fieldset><legend><h3> Buscar Album/s </h3></legend>
                    <?php
                    echo $this->Form->create('Album', array('action' => 'search', 'id' => 'search'));
                    ?>
                    <table class='tabla_normal'>
                        <tr>
                            <td>
                                <?php
                                //echo $datePicker->picker('fecha_ini', array('id' => 'fecha_ini', 'label' => 'Fecha Inicio', 'empty' => true));
                                echo $this->Form->input('fecha_ini', array('id' => 'fecha_ini', 'label' => 'Fecha Inicio', 'empty' => true));
                                ?>
                            </td>

                            <td>
                                <?php
                                //echo $datePicker->picker('fecha_fin', array('id' => 'fecha_fin', 'label' => 'Fecha Fin', 'empty' => true));
                                echo $this->Form->input('fecha_fin', array('id' => 'fecha_fin', 'label' => 'Fecha Fin', 'empty' => true));
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php
                                echo $this->Form->input('titulo', array('label' => 'T&iacute;tulo', 'id' => 'titulo'));
                                ?>
                            </td>  

                            <td>
                                <?php
                                echo $this->Form->input('status', array('empty' => __(' ', true), 'options' => array('Activo' => 'Activos', 'Inactivo' => 'Inactivos'), 'label' => 'Estado', 'id' => 'status'));
                                ?>
                            </td>                            
                        </tr>		
                    </table>
                    <span style='float:right'>
                        <?php
                        echo $this->Form->submit('Buscar');
                        ?>
                    </span>
                    <?php
                    echo $this->Form->end();
                    ?>
                </fieldset>
            </div>

            <?php
            if ($buscar == 1) {
                ?>
                <br/><br/>		
                <div>
                    <fieldset><legend><h3>Resultado/s de la busqueda</h3></legend>
                        <?php
                        echo $this->Form->create('Album', array('action' => 'delete', 'id' => 'form_album', 'onsubmit' => 'return verificar_checkbox_vacio();'));
                        //echo $this->Form->create('Noticia', array('action' => 'delete'));
                        echo '<table width="100%" id="paginador1">';
                        echo '  <thead>';
                        $cells = array(
                            null,
                            null,
                            null,
                            'Fecha',
                            'Titulo',
                            'Estado',
                            null,
                            null
                        );
                        echo $this->Html->tableHeaders($cells);
                        echo '  </thead>';
                        echo '  <tbody>';
                        foreach ($albums_encontrados as $i) {
                            $cells = array(
                                $this->Form->checkbox('Album.delete.' . $i['Album']['id']),
                                $this->Html->image('../img/icons/Magnifier.png', array('url' => array('action' => 'view', $i['Album']['id']), 'class' => 'button1', 'title' => 'Ver')),
                                $this->Html->image('../img/icons/Pencil.png', array('url' => array('action' => 'edit', $i['Album']['id']), 'class' => 'button1', 'title' => 'Editar')),
                                date('d-m-Y', strtotime($i['Album']['fecha'])),
                                $i['Album']['titulo'],
                                $i['Album']['status'],
                                $this->Html->image('../img/icons/Pictures.png', array('url' => array('controller' => 'images', 'action' => 'index', 'Album', $i['Album']['id']), 'class' => 'button1', 'title' => 'Imagenes')),
                                $this->Html->image('../img/icons/Email.png', array('url' => array('action' => 'pre_send', $i['Album']['id']), 'class' => 'button1', 'title' => 'Enviar')),
                            );
                            echo $this->Html->tableCells($cells);
                        }
                        echo '  </tbody>';
                        echo '</table>';
                        ?>

                        <span>
                            <?php
                            echo $this->Form->end('Eliminar seleccionada\s');
                            ?>
                        </span>

                        <!-- ESTE ES OTRO BOTON CREADO QUE NO FUNCIONA CON SUBMIT
                                <div>
                                            <div class="button button-green">
                        <?php
                        //echo $this->Html->link('Eliminar','javascript:;', array('onclick' => 'verificar_checkbox_vacio()'), false);
                        ?>
                                            </div>
                                </div>   
                        -->               
                    </fieldset>
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
        $('#search').validate();

    });

    function verificar_checkbox_vacio() {
        //Esta funcion la podemos encontrar en funciones_varias.js
        var checkeados = verificar_checkbox('paginador1', 'AlbumDelete');

        if (checkeados) {
            confirmar_varios("\xbfEst\xe1 seguro que desea eliminar los Albums seleccionados?", "form_album");
            return false; //para que no se dispare el submit, asi escucha al confirm nuevo

        } else {
            alerta("Para eliminar debe seleccionar al menos un \xEDtem");
            return false; //para que no se dispare el submmit, asi escucha al confirm nuevo
        }
    }
</script>