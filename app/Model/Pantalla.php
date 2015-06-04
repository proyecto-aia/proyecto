<?php

class Pantalla extends AppModel {

    var $name = 'Pantalla';
    var $hasMany = array(
        'Permiso' => array(
            'className' => 'Permiso'
        )
    );
    var $belongsTo = array(
        'Role' => array(
            'className' => 'Role'
        )
    );
    var $displayField = 'name';

}

?>