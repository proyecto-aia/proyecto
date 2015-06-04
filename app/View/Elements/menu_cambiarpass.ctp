<div id='cssmenu'>
    <ul>
        <li><?php echo $this->Html->link('Volver a Inicio', array('controller' => 'users', 'action' =>'index')); ?></li>
    </ul>    
    <!-- Panel Usuario Limitado -->
    <?php echo $this->element('panel_usuario_limitado'); ?>
</div>
<br/><br/>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //codigo a ejecutar cuando el DOM esta listo para recibir instrucciones.
});
</script>