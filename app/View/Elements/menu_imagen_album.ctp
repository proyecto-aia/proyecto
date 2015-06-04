<div id='cssmenu'>
    <ul>
        <li><?php echo $this->Html->link('Volver a Albums', array('controller' => 'albums', 'action' =>'search', 0)); ?></li>        
        <li><?php echo $this->Html->link('Im&aacute;genes', array('controller' => 'images', 'action' =>'index')); ?></li>	
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