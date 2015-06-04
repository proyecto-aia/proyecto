<?php

class Video extends AppModel {

    var $name = 'Video';
    var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Nombre requerido.',
        ),
        'link' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Enlace a Video Youtube requerido.',
        )
    );

}

?>