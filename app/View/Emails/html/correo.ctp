<div>
	<fieldset style='padding:3%;'>
		<?php
			if($this->Session->check('asunto_correo') and ($this->Session->read('asunto_correo') != "")) {
                ?>
        <legend>
            <h3>             
                <?php             
				echo $this->Session->read('asunto_correo');
                ?>
            </h3>
        </legend>                
                <?php
			}				
		?>

		<?php
			if($this->Session->check('cuerpo_correo') and ($this->Session->read('cuerpo_correo') != "")) {
				echo $this->Session->read('cuerpo_correo');
			}				
		?>
	</fieldset>
</div>
