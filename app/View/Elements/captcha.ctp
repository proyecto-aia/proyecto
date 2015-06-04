<br/>
<div id='captcha_div1' align='center' style='background-color:#CCFFCC;border:1px solid #d3d3d3'>
    <b><i>
            <div style='background-color:#f5f5f5;border:1px solid #d3d3d3;clear:none' id='captcha_div2'>	
        <table style="border: none; padding: 0px; margin: 0px;">
            <tr style="border: none; padding: 0px; margin: 0px;">
                <td style="border: none; padding: 0px; margin: 0px;">
            <?php
                    echo $this->Html->image("captcha/".$captcha_src, array('width' => '150px', 'height' => '70px', 'style' => 'border: 1px solid #d3d3d3', 'id' => 'captcha_img'));
            ?>
                </td>
                <td style="border: none; padding: 0px; margin: 0px;">
            <?php
                    echo $this->Html->image("captcha_logo.png", array('width' => '85px', 'height' => '40px', 'id' => 'captcha'));
            ?>
                </td>
            </tr>
        </table>
            </div>
            <?php
                echo $this->Form->input('ver_code', array('label' => 'Ingresar c&oacute;digo de seguridad','class'=>'required', 'id' => 'cod_seguridad'));
            ?>
    </i></b>
</div>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
	$('#captcha_img').hide();
	$('#captcha_img').show('slow');
	
	$('#captcha_div1').corner();
	$('#captcha_div2').corner();
	
    /*
	$('#cod_seguridad').blur(function(){
        $(this).css('border', 'solid 1px #ccc');
    });
	$('#cod_seguridad').focus(function(){
        $(this).css('border', 'solid 3px #6dc7ec');
    });
    */
	
	/*
	$('#recaptcha').click(function() {
	 // alert("Handler for .click() called.");
		//$(this).load('captcha_img');
		alert('hola');
	});
	*/

});
</script>
