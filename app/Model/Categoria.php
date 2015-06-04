<?php

class Categoria extends AppModel {

    var $name = 'Categoria';
    var $hasMany = array(
        'Productoscategoria' => array(
            'className' => 'Productoscategoria'
        )
    );
    var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Nombre requerido.',
        ),
    );
    var $displayField = 'nombre';

}

?>
