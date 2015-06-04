<div id='cssmenu'>
    <ul>
        <li><?php echo $this->Html->link('Inicio', array('controller' => 'users', 'action' =>'home')); ?></li>
        <li class='has-sub'><a href='#'><span>Usuarios ></span></a>
            <ul>
                <li><?php echo $this->Html->link('Buscar', array('controller' => 'users', 'action' =>'search', 0)); ?></li>			
                <li><?php echo $this->Html->link('Agregar', array('controller' => 'users', 'action' =>'add')); ?></li>
            </ul>
        </li>
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