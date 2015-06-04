<?php

class Permiso extends AppModel {

    var $name = 'Permiso';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'User' => array(
            'className' => 'User'
        ),
        'Pantalla' => array(
            'className' => 'Pantalla'
        )
    );

}

?>