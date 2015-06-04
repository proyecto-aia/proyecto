<div id='cssmenu'>
    <ul>
    	<li><?php echo $this->Html->link('Inicio', array('controller' => 'publicos', 'action' =>'index')); ?></li>
    	<li><?php echo $this->Html->link('Contacto', array('controller' => 'publicos', 'action' =>'contacto')); ?></li>
    </ul>
    <!-- Panel Usuario login --> 
    <?php echo $this->element('panel_usuario_login'); ?> 
</div>
<br/><br/>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
});
</script>