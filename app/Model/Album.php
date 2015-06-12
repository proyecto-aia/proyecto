<?php

class Album extends AppModel {

    var $name = 'Album';
    var $hasMany = array(
        'Image' => array(
            'className' => 'Image'
        )
    );
    var $validate = array(
        'titulo' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'required' => false,
                'allowEmpty' => true,
                'message' => 'Titulo requerido',
            ),
            'minlength' => array(
                'rule' => array('minLength', 3),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Titulo debe tener al menos 3 caracteres',
            ),
            'maxlength' => array(
                'rule' => array('maxLength', 100),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Titulo no debe ser mayor a 100 caracteres',
            )
        )
    );

}

?>