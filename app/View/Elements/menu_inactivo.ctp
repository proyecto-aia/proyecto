<div id='cssmenu'>
    <ul>
        <li><?php echo $this->Html->link('Inicio', array('controller' => 'users', 'action' =>'home')); ?></li>
    </ul>    
    <!-- Panel Usuario Limitado -->
    <?php echo $this->element('panel_usuario_limitado'); ?>
</div>
<br/><br/>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
});
</script>