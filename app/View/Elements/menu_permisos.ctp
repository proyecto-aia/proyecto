<div id='cssmenu'>
    <ul>
        <li><?php echo $this->Html->link('Volver a Usuarios', array('controller' => 'users', 'action' =>'search', 0)); ?></li>
        <li><?php echo $this->Html->link('Permisos', array('controller' => 'permisos', 'action' =>'index')); ?></li>
        <li><?php echo $this->Html->link('Agregar Permisos', array('controller' => 'permisos', 'action' =>'add')); ?></li>
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