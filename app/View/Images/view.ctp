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
			<div style='width:60%'>
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
					<legend><h3>Imagen</h3></legend>

						<table  class='tabla_normal'>
                        <!--
							<tr>
								<td style='text-align:right'><span><b>Nombre:</b></span></td>	
								<td style='text-align:left'><span><?php //echo $image['Image']['name']; ?></span></td>
							</tr>
						-->
                        	<tr>
								<td style='text-align:right'><span><b>Imagen:</b></span></td>	
								<td style='text-align:left'><span><?php  echo $this->Html->image('thumbnails/' . $image['Image']['location'], array('alt' => $image['Image']['name'])); ?></span></td>
							</tr>

							<tr>
								<td style='text-align:right'><span><b>Creada:</b></span></td>	
								<td style='text-align:left'><span><?php echo $image['Image']['created']; ?></span></td>
							</tr>	

							<tr>
								<td style='text-align:right'><span><b>Modificada:</b></span></td>	
								<td style='text-align:left'><span><?php echo $image['Image']['modified']; ?></span></td>
							</tr>							

							<tr>
								<td style='text-align:right'><span><b>Descripci&oacute;n:</b></span></td>	
								<td style='text-align:left'><span><?php echo $image['Image']['description']; ?></span></td>
							</tr>
						</table>
						
						<br/><br/>
						
						<?php  echo $this->Html->image('medium/' . $image['Image']['location'], array('alt' => $image['Image']['name'], 'style' => 'max-width:100%')); ?>
						
				</fieldset>
			</div>			
		</td>	
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
});
</script>

