<?php

class Role extends AppModel {

    var $name = "Role";
    // setup the has many relationships
    var $hasMany = array(
        'User' => array(
            'className' => 'User'
        ),
        'Pantalla' => array(
            'className' => 'Pantalla'
        )
    );
    var $displayField = 'nombre';

}

?>
