<?php

class Productoscategoria extends AppModel {

    var $name = 'Productoscategoria';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'Producto' => array(
            'className' => 'Producto'
        ),
        'Categoria' => array(
            'className' => 'Categoria'
        )
    );

}

?>