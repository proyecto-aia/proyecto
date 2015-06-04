<div id='cssmenu'>
    <ul>
        <li><?php echo $this->Html->link('Inicio', array('controller' => 'gestiones', 'action' =>'index')); ?></li>
        <li><?php echo $this->Html->link('Ir a Albums', array('controller' => 'albums', 'action' =>'search', 0)); ?></li>
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
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
});
</script>