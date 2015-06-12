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
/* * * Estilos para botone/iconos/etc... ** */
echo $this->addScript($this->Html->css('button'));
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
    <tr>	
        <td>
            <div>
                <fieldset><legend><h3>Administrar Enlaces a Videos</h3></legend>
                    <?php
                    if (!empty($videos)) {
                        echo $this->Form->create('Video', array('action' => 'delete', 'id' => 'form_video', 'onsubmit' => 'return verificar_checkbox_vacio();'));
                        echo '<table width="100%" id="paginador3">';
                        echo '  <thead>';
                        $cells = array(
                            $this->Form->checkbox('check-all', array('id' => 'check-all', 'class' => 'check-all')),
                            null,
                            null,
                            'Fecha',
                            'Nombre',
                            'Descripcion'
                        );
                        echo $this->Html->tableHeaders($cells);
                        echo '  </thead>';
                        echo '  <tbody>';
                        foreach ($videos as $i) {
                            $cells = array(
                                $this->Form->checkbox('Video.delete.' . $i['Video']['id'], array('class' => 'check-item')),
                                $this->Html->image('../img/icons/Magnifier.png', array('url' => array('action' => 'view', $i['Video']['id']), 'class' => 'button1', 'title' => 'Ver')),
                                $this->Html->image('../img/icons/Pencil.png', array('url' => array('action' => 'edit', $i['Video']['id']), 'class' => 'button1', 'title' => 'Editar')),
                                date('d-m-Y', strtotime($i['Video']['created'])),
                                $i['Video']['name'],
                                $i['Video']['description'],
                            );
                            echo $this->Html->tableCells($cells);
                        }
                        echo '  </tbody>';
                        echo '</table>';
                        ?>
                        <span>
                            <?php
                            echo $this->Form->end('Eliminar seleccionado\s');
                            /*
                              $options=array('type'=>'image', 'style'=>'width:32px; display:block;', 'class' => 'button', 'label' => 'Eliminar');
                              echo $this->Form->submit('/img/cake.icon.png', $options);
                              echo $this->Form->end();
                             */
                            ?>
                        </span>        
                        <?php
                    } else {
                        echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;<b>No se agregaron Videos</b><br>&nbsp;";
                    }
                    ?>	

                </fieldset>
            </div>
        </td>		
    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    function verificar_checkbox_vacio() {
        //Esta funcion la podemos encontrar en funciones_varias.js
        var checkeados = verificar_checkbox('paginador3', 'VideoDelete');

        if (checkeados) {
            confirmar_varios("\xbfEst\xe1 seguro que desea eliminar los Videos seleccionados?", "form_video");
            return false; //para que no se dispare el submit, asi escucha al confirm nuevo

        } else {
            alerta("Para eliminar debe seleccionar al menos un \xEDtem");
            return false; //para que no se dispare el submmit, asi escucha al confirm nuevo
        }
    }
</script>