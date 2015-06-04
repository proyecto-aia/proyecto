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
/*** mask - Mascaras para campos ***/
echo $this->addScript( $this->Html->script('jquery.mask'));
/*** Validate con estilos css modificados en el .js ***/
echo $this->addScript($this->Html->script('jquery.validate'));
echo $this->addScript($this->Html->script('jquery.corner'));           
?>
<?php
    switch($modulo){
        case 'Noticia':
            echo $this->element('menu_imagen_noticia');
            break;
        case 'Producto':
            echo $this->element('menu_imagen_producto');
            break;
        case 'Album':
            echo $this->element('menu_imagen_album');
            break;
    }
?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
	<tr>
		<td>
			<div style='width:70%'>
				<fieldset>
					<legend><h3><?php echo $modulo; ?></h3></legend>
                    <div style="padding: 1%;">                        
    					<b><?php echo $modulo_titulo ?></b>
                        <?php 
                            switch($modulo){
                                case 'Producto':
                                    echo "<br/><br/><b><u>C&oacute;digo:</u></b>"." ".$modulo_codigo;
                                    break;
                            } 
                        ?>                        
                    </div>
				</fieldset>	
                <br />            
				<fieldset style='padding:3%;'>
					<legend><h3>Editar Imagen</h3></legend>
				<?php
					echo $form->create('Image',array('type' => 'file', 'id' => 'editar'));
					echo $form->hidden('id');
					
                    switch($modulo){
                        case 'Noticia':
                            echo $form->hidden('noticia_id', array('value' => $modulo_id));
                            break;
                        case 'Producto':
                            echo $form->hidden('producto_id', array('value' => $modulo_id));
                            break;
                        case 'Album':
                            echo $form->hidden('album_id', array('value' => $modulo_id));
                            break;
                    }
                    echo $form->hidden('location');

                    echo $this->Html->image('thumbnails/' . $image['Image']['location'], array('alt' => $image['Image']['name']));
                ?>
                <br /><br /><br />
                <?php                    
					echo $this->Form->input('description',  array('label' => 'Descripci&oacute;n', 'id' => 'description'));	
				?>
					<span style='float:right'>
				<?php					
					echo $form->submit('Editar', array('after' => ' ' . $html->link('Cancelar', array('action' => 'index'))));
				?>
					</span>				
				</fieldset>
			</div>
		</td>		
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#editar').validate();
});
</script>