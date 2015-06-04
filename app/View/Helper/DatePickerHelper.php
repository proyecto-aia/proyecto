<?php  
App::import('Helper', 'Form'); 

class DatePickerHelper extends FormHelper { 
    
    var $helpers = array('Html','Javascript');  
    var $format = '%Y-%m-%d'; 
    
    function _setup(){ 
        $format = Configure::read('DatePicker.format'); 
        if($format != null){ 
            $this->format = $format; 
        } 
    } 

    function picker($fieldName, $options = array()) { 
        $this->_setup(); 
        $this->setEntity($fieldName); 
        $htmlAttributes = $this->domId($options);         
        $divOptions['class'] = 'date'; 
        $options['type'] = 'date'; 
        $options['div']['class'] = 'date'; 
    $options['dateFormat'] = 'DMY';
	//$options['empty'] = true;
	//$options['disabled'] = true;
    //$options['readonly'] = true;
        $options['minYear'] = isset($options['minYear']) ? $options['minYear'] : (date('Y') - 20); 
        $options['maxYear'] = isset($options['maxYear']) ? $options['maxYear'] : (date('Y') + 20); 

        $options['after'] = $this->Html->image('Date.png', array('id' => $htmlAttributes['id'], 'style' => 'cursor:pointer;margin-left:10px;', 'class' => 'button1', 'title' => 'Calendario')); 

		if (isset($options['empty'])) { 
			$options['after'] .= $this->Html->image('Draw-Eraser.png', array('id' => $htmlAttributes['id']."_drop", 'style' => 'cursor:pointer;margin-left:5px', 'class' => 'button1', 'title' => 'Borrar Fecha')); 
		} 
		
        $output = $this->input($fieldName, $options); 
        $output .= $this->Javascript->codeBlock("datepick('" . $htmlAttributes['id'] . "','01/01/" . $options['minYear'] . "','31/12/" . $options['maxYear'] . "');");
		
        return $output; 
    } 
    
} 

?>