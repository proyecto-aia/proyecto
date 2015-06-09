<?php
/************************* ##### CSS ##### *************************/
echo $this->addScript($this->Html->css('reset'));		
echo $this->addScript($this->Html->css('cake.generic'));
echo $this->addScript($this->Html->css('menu'));
/************************* ##### JS ##### *************************/
echo $this->addScript($this->Html->script('funciones_varias'));
/************************* ##### UTILIZADOS ##### *************************/
/*** jQuery - Version ***/
echo $this->addScript($this->Html->script('jquery-1.8.3'));
/*** Elimina borde final de las tablas ***/
echo $this->addScript($this->Html->css('estilo_tablas'));
/*** dataTables - Estilo tabla de registros ***/
echo $this->addScript($this->Html->script('swfobject'));		
echo $this->addScript($this->Html->script('jquery.dataTables'));
echo $this->addScript($this->Html->script('../js/TableTools/media/js/TableTools'));
echo $this->addScript($this->Html->script('../js/TableTools/media/js/ZeroClipboard'));
echo $this->addScript($this->Html->script('paginador'));        
echo $this->addScript($this->Html->css('jquery.dataTables'));
echo $this->addScript($this->Html->css('../js/TableTools/media/css/TableTools'));
//echo $this->Html->css('../js/TableTools/media/css/TableTools_JUI');        
/*** alertify - Alertas ***/
echo $this->addScript($this->Html->script('alertify'));
echo $this->addScript($this->Html->script('funciones_alertify'));        
echo $this->addScript($this->Html->css('alertify.core'));
echo $this->addScript($this->Html->css('alertify.default'));
?>
<?php echo $this->element('menu_permisos'); ?>
<?php echo $this->Session->flash(); ?>

<table class="tabla_normal">
	<tr>	
		<td>
			<div style='width:85%;'>
				<fieldset>
					<legend><h3>Permisos en Usuario</h3></legend>
                    <div style="padding: 1%;">                        
    					<b><u>Usuario:</u></b><?php echo " ".$user_name ?>
                        <br /><br />
                        <b><u>Rol:</u></b><?php echo " ".$user_role ?>
                    </div>
				</fieldset>	
                <br />            
				<fieldset><legend><h3>Permisos Agregados</h3></legend>
		<?php
		if (!empty($permisos)) {
		echo $this->Form->create('Permiso', array('action' => 'delete', 'id' => 'form_permiso', 'onsubmit'=>'return verificar_checkbox_vacio();'));
		echo '<table width="100%" id="paginador1">';
		echo '  <thead>';
		$cells = array(
			$this->Form->checkbox('check-all',array('id' => 'check-all', 'class' => 'check-all')),
			'Pantalla',
			'Fecha'
		);
		echo $this->Html->tableHeaders($cells);
		echo '  </thead>';
		echo '  <tbody>';
		foreach($permisos as $i) {
			$cells = array(
				$this->Form->checkbox('Permiso.delete.' . $i['Permiso']['id'], array('class' => 'check-item')),
				$i['Pantalla']['name'],
				date('d-m-Y',strtotime($i['Permiso']['created'])),
			);
			echo $this->Html->tableCells($cells);
		}
		echo '  </tbody>';
		echo '</table>';
		?>
		<span>
		<?php
		echo $this->Form->end('Eliminar seleccionado\s');
		?>
		</span>
		<?php
		}  else {
			echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;<b>No se agregaron Permisos</b><br>&nbsp;";
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
        var checkeados =  verificar_checkbox('paginador1','PermisoDelete');
        
        if (checkeados) {
           confirmar_varios("\xbfEst\xe1 seguro que desea eliminar los Permisos seleccionados?","form_permiso");
           return false; //para que no se dispare el submit, asi escucha al confirm nuevo
            
        } else {
           alerta("Para eliminar debe seleccionar al menos un \xEDtem");
           return false; //para que no se dispare el submmit, asi escucha al confirm nuevo
        }
    }
</script>