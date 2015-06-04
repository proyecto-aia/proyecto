<div id='cssmenu'>
    <ul>
        <li><?php echo $this->Html->link('Inicio', array('controller' => 'gestiones', 'action' =>'index')); ?></li>            
        <li><?php echo $this->Html->link('Ir a Productos', array('controller' => 'productos', 'action' =>'search', 0)); ?></li>        
        <li><?php echo $this->Html->link('Categor&iacute;as', array('controller' => 'categorias', 'action' =>'index')); ?></li>        
        <li><?php echo $this->Html->link('Agregar Categor&iacute;as', array('controller' => 'categorias', 'action' =>'add')); ?></li>	
    </ul>
    <!-- Panel Usuario Normal -->
    <?php echo $this->element('panel_usuario_normal'); ?>
</div>
<br/><br/>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
});
</script>