<ul style="float: right;">
    <li class='has-sub'>    
        <a href='#'>
            <span><?php echo $usuario; ?>&nbsp;></span>
        </a>
        <ul style="width: 150px;">			
                <li><?php echo $this->Html->link('Cerrar Sesi&oacute;n', array('controller' => 'users', 'action' =>'logout')); ?></li>
        </ul>
    </li>
    <li>
        <?php //echo $this->Html->link(__($this->Html->image('../img/icon_user.png', array('width'=>40))),true);
        echo $this->Html->image('../img/icon_user.png', array('width'=>40));?>
    </li>
</ul>