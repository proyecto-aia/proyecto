<?php

class User extends AppModel {

    var $name = 'User';
    // setup the belongs to relationships
    var $belongsTo = array(
        'Role' => array(
            'className' => 'Role'
        )
    );
    var $hasMany = array(
        'Permiso' => array(
            'className' => 'Permiso'
        )
    );
    var $virtualFields = array(
        'full_name' => "CONCAT(User.last_name, ', ', User.first_name)",
    );
    var $validate = array(
        'username' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'required' => false,
                'allowEmpty' => true,
                'message' => 'Nombre de Usuario requerido',
            ),
            'minlength' => array(
                'rule' => array('minLength', 4),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Nombre de Usuario debe tener al menos 4 caracteres',
            ),
            'maxlength' => array(
                'rule' => array('maxLength', 20),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Nombre de Ususario no debe ser mayor a 20 caracteres',
            ),
            'alphanum' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Nombre se Usuario solo debe contener letras y/o numeros',
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'required' => true,
                'allowEmpty' => true,
                'message' => 'El Nombre de Ususario ya esta en uso',
            )
        ),
        'clear_password' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false,
                'on' => 'create',
                'message' => 'Clave requerida',
            ),
            'length' => array(
                'rule' => array('minLength', 6),
                'required' => true,
                'allowEmpty' => true,
                'message' => 'La Clave debe tener al menos 6 caracteres',
            )
        ),
        'confirm_password' => array(
            'empty_create' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false,
                'on' => 'create',
                'message' => 'Confirmar la Clave 1',
            ),
            'empty_update' => array(
                'rule' => 'validateConfirmPasswordEmptyUpdate',
                'required' => true,
                'allowEmpty' => true,
                'on' => 'update',
                'message' => 'Confirmar la Clave 2',
            ),
            'match' => array(
                'rule' => 'validateConfirmPasswordMatch',
                'required' => true,
                'allowEmpty' => true,
                'message' => 'Las Claves no coinciden',
            )
        ),
        'email' => array(
            'empty' => array(
                'rule' => 'notEmpty',
                'required' => false,
                'allowEmpty' => true,
                'message' => 'E-Mail requerido',
            ),
            'valid' => array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => true,
                'message' => 'Ingrese un E-Mail valido',
            )
        )
    );

    /**
     * Callback function for confirm_password
     * Used to check the confirm_password field is not empty on update
     * @return bool
     */
    function validateConfirmPasswordEmptyUpdate() {
        return !empty($this->data['User']['clear_password']) && !empty($this->data['User']['confirm_password']);
    }

    /**
     * Callback function for confirm_password
     * Used to check if clear_password and confirm_password match
     * @return bool
     */
    function validateConfirmPasswordMatch() {
        return $this->data['User']['clear_password'] == $this->data['User']['confirm_password'];
    }

}

?>