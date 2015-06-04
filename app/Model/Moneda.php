<?php

class Moneda extends AppModel {

    var $name = "Moneda";
    // setup the has many relationships
    var $hasMany = array(
        'Producto' => array(
            'className' => 'Producto'
        )
    );
    var $displayField = 'nombre';

}

?>
