<div id='cssmenu'>
    <ul>
        <li><?php echo $this->Html->link('Inicio', array('controller' => 'gestiones', 'action' =>'index')); ?></li>
        <li class='has-sub'><a href='#'><span>Noticias ></span></a>
            <ul>
                <li><?php echo $this->Html->link('Buscar', array('controller' => 'noticias', 'action' =>'search', 0)); ?></li>			
                <li><?php echo $this->Html->link('Agregar', array('controller' => 'noticias', 'action' =>'add')); ?></li>
                <li><?php echo $this->Html->link('Administrar Categorias', array('controller' => 'categorias', 'action' =>'index', 'Noticia', 2)); ?></li>
            </ul>
        </li>
        <li class='has-sub'><a href='#'><span>Videos ></span></a>
            <ul>
                <li><?php echo $this->Html->link('Administrar', array('controller' => 'videos', 'action' =>'index')); ?></li>			
                <li><?php echo $this->Html->link('Agregar', array('controller' => 'videos', 'action' =>'add')); ?></li>
            </ul>
        </li>
        <li><?php echo $this->Html->link('Publicidades', array('controller' => 'publicidades', 'action' =>'index')); ?></li>
        <li class='has-sub'><a href='#'><span>Productos ></span></a>
            <ul>
                <li><?php echo $this->Html->link('Buscar', array('controller' => 'productos', 'action' =>'search', 0)); ?></li>			
                <li><?php echo $this->Html->link('Agregar', array('controller' => 'productos', 'action' =>'add')); ?></li>
                <li><?php echo $this->Html->link('Administrar Categorias', array('controller' => 'categorias', 'action' =>'index', 'Producto', 3)); ?></li>
            </ul>
        </li>
        <li class='has-sub'><a href='#'><span>Albums ></span></a>
            <ul>
                <li><?php echo $this->Html->link('Buscar', array('controller' => 'albums', 'action' =>'search', 0)); ?></li>			
                <li><?php echo $this->Html->link('Agregar', array('controller' => 'albums', 'action' =>'add')); ?></li>
                <li><?php echo $this->Html->link('Administrar Categorias', array('controller' => 'categorias', 'action' =>'index', 'Album', 1)); ?></li>
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