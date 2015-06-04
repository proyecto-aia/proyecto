<?php

class Noticia extends AppModel {

    var $name = 'Noticia';
    var $hasMany = array(
        'Image' => array(
            'className' => 'Image'
        )
    );
    var $validate = array(
        'titulo' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false,
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
        ),
        'resumen' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Resumen requerido',
            ),
            'minlength' => array(
                'rule' => array('minLength', 3),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Resumen debe tener al menos 3 caracteres',
            ),
            'maxlength' => array(
                'rule' => array('maxLength', 300),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Resumen no debe ser mayor a 300 caracteres',
            )
        ),
        'contenido' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Contenido requerido',
            ),
            'minlength' => array(
                'rule' => array('minLength', 3),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Contenido debe tener al menos 3 caracteres',
            )
        )
    );

}

?>