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
/*** Validate con estilos css modificados en el .js ***/
echo $this->addScript($this->Html->script('jquery.validate'));
echo $this->addScript($this->Html->script('jquery.corner'));
/*** mask - Mascaras para campos ***/
echo $this->addScript($this->Html->script('jquery.mask'));
/*** alertify - Alertas ***/
echo $this->addScript($this->Html->script('alertify'));
echo $this->addScript($this->Html->script('funciones_alertify'));        
echo $this->addScript($this->Html->css('alertify.core'));
echo $this->addScript($this->Html->css('alertify.default'));
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
echo $this->addScript($this->Html->css(array('jquery.fancybox-1.3.4'), 'stylesheet', array('media' => 'screen')));
/*** Estilos para botone/iconos/etc... ***/
echo $this->addScript($this->Html->css('button'));
?>
<?php echo $this->element('menu_gestion'); ?>
<?php echo $this->Session->flash(); ?>

<table class='tabla_normal'>
	<tr>
		<td>
			<div style='width:70%'>
				<fieldset style='padding:3%;'>
					<legend><h3>Agregar Publicidad</h3></legend>
				<?php
					echo $form->create('Publicidade',array('type' => 'file', 'id' => 'agregar'));
					//echo $form->input('name', array('label' => 'Nombre', 'class' => 'required alphanumeric', 'id' => 'name'));
					echo $form->input('location', array('label' => 'Publicidad', 'type' => 'file', 'class' => 'required', 'id' => 'location')); 
				?>	
					<b><i>* Cargar un archivo con entensi&oacute;n jpg, jpeg, png o gif. </i></b>
					<br/><br/>
				<span style='float:right'>	
				<?php
					 echo $form->submit('Agregar', array('after' => ' ' . $html->link('Cancelar', array('action' => 'index'))));
				?>
				</span>
				</fieldset>
			</div>			        
			<div>
				<fieldset>
					<legend><h3>Publicidades</h3></legend>
						<?php
							$i = 0;
							foreach ($publicidades as $publicidad) {
						?>
    						<div class="thumb_img">
    							<?php 
    									$i++;
    								
    									echo $html->link(
    										$html->image('thumbnails/' . $publicidad['Publicidade']['location'], array('alt' => $publicidad['Publicidade']['name'])),
    										'/img/medium/' . $publicidad['Publicidade']['location'],
    										array('class' => 'grouped', 'rel' => 'group', 'escape' => false)
    									); 
    							?>    							
                                <div style="padding-top: 5px;">
    							<?php 
    									//echo $html->link(__('Ver', true), array('action' => 'view', $publicidad['Publicidade']['id']), array('class' => 'thumb_img_action'));
                                        echo $html->link($this->Html->image('../img/icons/Magnifier.png'), array('action' => 'view', $publicidad['Publicidade']['id']), array('class' => 'button1', 'title' => 'Ver'));
                                        
    							?>
                                <!--
    							&nbsp;
    							<?php
    									//echo $this->Html->link(__('Editar', true), array('action' => 'edit', $publicidad['Publicidade']['id']), array('class' => 'thumb_img_action')); 
    							?>
                                -->
    							&nbsp;
    							<?php
                                        //echo $this->Html->link(__('Eliminar', true), array('action' => 'delete', $publicidad['Publicidade']['id']), array('class' => 'thumb_img_action', 'id' => 'eliminar'.$i , 'onclick' => 'return confirmar_eliminar(eliminar'.$i.');'));
                                       echo $html->link($this->Html->image('../img/icons/Cross.png'), array('action' => 'delete', $publicidad['Publicidade']['id']), array('class' => 'button1', 'id' => 'eliminar'.$i , 'onclick' => 'return confirmar_eliminar(eliminar'.$i.');', 'title' => 'Eliminar')); 
    							?>
                                </div>			
    						</div>
						
						<?php } ?>
						<br clear="left" />
						<p style='padding:3%'>
						<i><?php
							//echo $this->Paginator->counter(array('format' => __('Se muestran '.$i.' registro\s.', true)));
							echo "Se muestran ".$i." registro\s.";	
						?></i>
						</p>			
				</fieldset>
			</div>			
		</td>		
	</tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(document).ready(function(){
       //código a ejecutar cuando el DOM está listo para recibir instrucciones. 
        $("#agregar").validate({
           submitHandler: function(form) {
             // do other stuff for a valid form 
             loading("Agregando Imagen...");            
             form.submit();
           }
        });        
    });

    function confirmar_eliminar($link) {
       confirmar_individual("\xbfEst\xe1 seguro que desea eliminar la Imagen seleccionada?",$link);
       return false;
    } 
</script>,