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
/*** mask - Mascaras para campos ***/
echo $this->addScript($this->Html->script('jquery.mask'));
/*** Validate con estilos css modificados en el .js ***/
echo $this->addScript($this->Html->script('jquery.validate'));
echo $this->addScript($this->Html->script('jquery.corner'));
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
/*** Estilos para botone/iconos/etc... ***/
echo $this->addScript($this->Html->css('button'));
?>
<?php echo $this->element('menu_administrador'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
	<tr>
		<td>
			<div>
				<fieldset><legend><h3> Buscar Usuario/s </h3></legend>
            		<?php
            			echo $form->create(null,array('action'=>'search', 'id' => 'search'));
            		?>
            		<table class='tabla_normal'>
            			<tr>
            				<td>
            		<?php
            			echo $form->input('username', array('label' => 'Usuario', 'class' => 'alphanumeric', 'id' => 'username'));
            		?>
            				</td>
            				<td>
            		<?php			
            			echo $form->input('first_name', array('label' => 'Nombres', 'id' => 'first_name'));
            		?>
            				</td>
            				<td>
            		<?php			
            			echo $form->input('last_name', array('label' => 'Apellidos', 'id' => 'last_name'));
            		?>
            				</td>
            				<td>
            			</tr>
            			<tr>
            				<td>
            		<?php			
            			echo $form->input('email', array('label' => 'E-Mail', 'class' => 'email', 'id' => 'email'));
            		?>
            				</td>
            				<td>
            		<?php			
            			echo $form->input('role_id', array('label' => 'Tipo de Usuario', 'type' => 'select', 'empty' => __(' ',true), 'options' => $roles, 'id' => 'role_id'));
            		?>
            				</td>
            				<td>		
            		<?php			
            			echo $form->input('status', array('empty' => __(' ',true), 'options' => array('Activo' => 'Activo', 'Inactivo' => 'Inactivo'), 'label' => 'Estado', 'id' => 'status'));
            		?>
            				</td>
            			</tr>		
            		</table>
        			<span style='float:right'>
            		<?php
            			echo $form->submit('Buscar');
            		?>
            			</span>
            		<?php	
            			echo $form->end();
            		?>
				</fieldset>
            </div>

    		<?php
    			if ($buscar==1) { 
            ?>
    		<br/><br/>		
    		<div>
    				<fieldset><legend><h3>Resultado/s de la busqueda</h3></legend>
            	<?php
                    echo $form->create('User', array('action' => 'delete', 'id' => 'form_user', 'onsubmit'=>'return verificar_checkbox_vacio();'));
            		echo '<table width="100%" id="paginador1">';
            		echo '  <thead>';
            		$cells = array(
            			$form->checkbox('check-all',array('id' => 'check-all', 'class' => 'check-all')),
            			null,
            			null,
            			'Usuario',
            			'Nombre',
            			'Rol',
            			'Estado',
            			null,
            		);
            		echo $this->Html->tableHeaders($cells);
            		echo '  </thead>';
            		echo '  <tbody>';
            		foreach($users_encontrados as $i) {
            			$cells = array(
            				$form->checkbox('User.delete.' . $i['User']['id'], array('class' => 'check-item')),
                            $html->link($this->Html->image('../img/icons/Magnifier.png'), array('action' => 'view', $i['User']['id']), array( 'class' => 'button1', 'title' => 'Ver')),
                            $html->link($this->Html->image('../img/icons/Pencil.png'), array('action' => 'edit', $i['User']['id']), array( 'class' => 'button1', 'title' => 'Editar')),
            				$i['User']['username'],
            				$i['User']['full_name'],
            				$i['Role']['nombre'],			
            				$i['User']['status'],
                            $html->link($this->Html->image('../img/icons/Group-Key.png'), array('controller' => 'permisos', 'action' => 'index', $i['User']['id']), array( 'class' => 'button1', 'title' => 'Permisos')),				
            			);
            			echo $this->Html->tableCells($cells);
            		}
            		
            		echo '  </tbody>';
            		echo '</table>';
            		?>
            		<span>
            		<?php
            		if (!empty($users_encontrados)) { 
            			echo $form->end('Eliminar seleccionado\s');
            		}
            		?>
            		</span>    
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
    $(document).ready(function(){
       //código a ejecutar cuando el DOM está listo para recibir instrucciones.
    	$('#search').validate();   
    });
    
    function verificar_checkbox_vacio() {
        //Esta funcion la podemos encontrar en funciones_varias.js
        var checkeados =  verificar_checkbox('paginador1','UserDelete');
        
        //Siempre tener en cuenta el form_'---' (id-formulario) que se envia en la funcion confirmar_varios() que se encuentra en funciones_varias.js
        if (checkeados) {
           confirmar_varios("\xbfEst\xe1 seguro que desea eliminar los Usuarios seleccionados?","form_user");
           return false; //para que no se dispare el submit, asi escucha al confirm nuevo
            
        } else {
           alerta("Para eliminar debe seleccionar al menos un \xEDtem");
           return false; //para que no se dispare el submmit, asi escucha al confirm nuevo
        }
    }
</script>