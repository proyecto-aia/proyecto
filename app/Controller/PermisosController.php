<?php

class PermisosController extends AppController {

    var $name = 'Permisos';
    var $components = array('Auth');

    /*
    function afterFilter() {
        // Update User last_access datetime
        if ($this->Auth->user()) {
            $this->loadModel('User');
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_access', date('Y-m-d H:i:s'));
        }
    }
     * 
     */

    function index($user_id = null) {
        //$this->_refreshAuth();
        switch ($this->Auth->user('role_id')) {
            case 1:
                ////$this->_refreshAuth();			
                if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
                    if ($user_id) {
                        $pantalla = 32;
                        $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
                        if ($permiso) {
                            $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                            $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                            //ID del Usuario al que le vamos a insertar o eliminar Permisos
                            $this->Session->write('user_id', $user_id);
                            $this->set('user_id', $this->Session->read('user_id'));

                            // Obtengo USUARIO - su ROL - sus PERMISOS -> pertenece al usuario seleccionado 
                            $this->loadModel('User');
                            $this->User->recursive = 0;
                            $conditions1 = array('User.id' => $this->Session->read('user_id'));
                            $result1 = $this->User->find('first', array('conditions' => $conditions1,
                                'fields' => array('User.id', 'User.username', 'User.full_name', 'User.email', 'Role.id', 'Role.nombre', 'User.status')
                                    )
                            );
                            $this->set('users', $result1);

                            $this->Session->write('user_name', $result1['User']['username']);
                            $this->set('user_name', $this->Session->read('user_name'));

                            $this->Session->write('user_role', $result1['Role']['nombre']);
                            $this->set('user_role', $this->Session->read('user_role'));


                            // Obtengo PERMISO - su USUARIO - su PANTALLA -> pertenece al usuario seleccionado
                            $this->Permiso->recursive = 0;
                            $conditions2 = array('Permiso.user_id' => $this->Session->read('user_id'));
                            $result2 = $this->Permiso->find('all', array('conditions' => $conditions2,
                                'fields' => array('Permiso.id', 'Permiso.created', 'Pantalla.id', 'Pantalla.name')
                                , 'order' => array('Pantalla.id ASC')
                                    )
                            );
                            $this->set('permisos', $result2);
                        } else {
                            $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                            $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
                        }
                    } else {
                        if ($this->Session->check('user_id')) {
                            $pantalla = 32;
                            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
                            if ($permiso) {
                                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado						
                                $this->set('user_id', $this->Session->read('user_id'));
                                $this->set('user_name', $this->Session->read('user_name'));
                                $this->set('user_role', $this->Session->read('user_role'));

                                // Obtengo USUARIO - su ROL - sus PERMISOS -> pertenece al usuario seleccionado 
                                $this->loadModel('User');
                                $this->User->recursive = 0;
                                $conditions1 = array('User.id' => $this->Session->read('user_id'));
                                $result1 = $this->User->find('first', array('conditions' => $conditions1,
                                    'fields' => array('User.id', 'User.username', 'User.full_name', 'User.email', 'Role.id', 'Role.nombre', 'User.status')
                                        )
                                );
                                $this->set('users', $result1);

                                // Obtengo PERMISO - su USUARIO - su PANTALLA -> pertenece al usuario seleccionado
                                $this->Permiso->recursive = 0;
                                $conditions2 = array('Permiso.user_id' => $this->Session->read('user_id'));
                                $result2 = $this->Permiso->find('all', array('conditions' => $conditions2,
                                    'fields' => array('Permiso.id', 'Permiso.created', 'Pantalla.id', 'Pantalla.name')
                                    , 'order' => array('Pantalla.id ASC')
                                        )
                                );
                                $this->set('permisos', $result2);
                            } else {
                                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
                            }
                        } else {
                            $this->Session->setFlash('Error con variables de sesi&oacute;n<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                            $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
                        }
                    }
                } else {
                    if ($this->Auth->user('status') == 'Inactivo') {
                        $this->Session->setFlash('Usuario inactivo', 'flash_failure');
                        $this->redirect(array('controller' => 'users', 'action' => 'inactivo'));
                    } else {
                        $this->Session->setFlash('Acceso denegado', 'flash_failure');
                        $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
                    }
                }
                break;
            case 2:
                $this->Session->setFlash('Acceso denegado', 'flash_failure');
                $this->redirect(array('controller' => 'gestiones', 'action' => 'index'));
                break;
            default:
                $this->redirect(array('controller' => 'publicos', 'action' => 'index'));
        }
    }

    function add() {
        $pantalla = 33;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado						
                $this->set('user_id', $this->Session->read('user_id'));
                $this->set('user_name', $this->Session->read('user_name'));
                $this->set('user_role', $this->Session->read('user_role'));


                // Obtengo USUARIO - su ROL - sus PERMISOS -> pertenece al usuario seleccionado 
                $this->loadModel('User');
                $this->User->recursive = 0;
                $conditions1 = array('User.id' => $this->Session->read('user_id'));
                $result1 = $this->User->find('first', array('conditions' => $conditions1,
                    'fields' => array('User.id', 'User.username', 'User.full_name', 'User.email', 'Role.id', 'Role.nombre', 'User.status')
                        )
                );

                $this->set('users', $result1);


                // Obtengo PERMISO - su USUARIO - su PANTALLA -> pertenece al usuario seleccionado
                $this->Permiso->recursive = 0;
                $conditions2 = array('Permiso.user_id' => $this->Session->read('user_id'));
                $result2 = $this->Permiso->find('all', array('conditions' => $conditions2,
                    'fields' => array('Permiso.id', 'Permiso.created', 'Pantalla.id', 'Pantalla.name')
                    , 'order' => array('Pantalla.id ASC')
                        )
                );


                $this->set('permisos', $result2);



                // Obtengo PANTALLAS a las que el USUARIO tiene acceso de acuerdo a su ROL y no se encuentran agregadas en PERMISOS
                $this->loadModel('Pantalla');
                $this->Pantalla->recursive = 0;
                $conditions3 = array('Pantalla.role_id' => $result1['Role']['id'], 'PermisosJoin.pantalla_id' => null);
                $result3 = $this->Pantalla->find('all', array(
                    'fields' => array('Pantalla.name'),
                    'order' => array('PermisosJoin.pantalla_id ASC'),
                    'joins' => array(
                        array(
                            'table' => 'permisos',
                            'alias' => 'PermisosJoin',
                            'type' => 'left outer',
                            'conditions' => array('PermisosJoin.pantalla_id = Pantalla.id', 'PermisosJoin.user_id = ' . $this->Session->read('user_id') . '')
                        )
                    ),
                    'conditions' => $conditions3
                        )
                );

                $this->set('pantallas_disp', $result3);
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function agregar_varios($id = null) {
        $pantalla = 33;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $add_count = 0;

                if (!empty($this->request->data['Permiso']['add'])) {
                    $arreglo = "";

                    foreach ($this->request->data['Permiso']['add'] as $id => $add) {
                        if ($add == 1) {
                            $arreglo['Permiso'][$add_count]['user_id'] = $this->Session->read('user_id');
                            $arreglo['Permiso'][$add_count]['pantalla_id'] = $id;
                            $arreglo['Permiso'][$add_count]['user_created'] = $this->Auth->user('id');
                            $add_count++;
                        }
                    }

                    if ($this->Permiso->saveAll($arreglo['Permiso'])) {
                        
                    } else {
                        $this->Session->setFlash('Error', 'flash_failure');
                    }
                }
                $this->Session->setFlash($add_count . ' Permiso' . (($add_count == 1) ? ' fue' : 's fueron') . ' agregado/s', 'flash_success');
                $this->redirect('index');
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function delete($id = null) {
        $pantalla = 34;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $delete_count = 0;
                if (!empty($this->request->data['Permiso']['delete'])) {
                    foreach ($this->request->data['Permiso']['delete'] as $id => $delete) {
                        if ($delete == 1) {
                            if ($this->Permiso->delete($id)) {
                                $delete_count++;
                            }
                        }
                    }
                }
                $this->Session->setFlash($delete_count . ' Permiso' . (($delete_count == 1) ? ' fue' : 's fueron') . ' eliminado/s', 'flash_success');
                $this->redirect('index');
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    /**
     * Refreshes the Auth session
     * @param string $field
     * @param string $value
     * @return void 
     */
    /*
    function _refreshAuth($field = '', $value = '') {
        if (!empty($field) && !empty($value)) {
            $this->Session->write($this->Auth->sessionKey . '.' . $field, $value);
        } else {
            if (isset($this->User)) {
                $this->Auth->login($this->User->read(false, $this->Auth->user('id')));
            } else {
                $this->Auth->login(ClassRegistry::init('User')->findById($this->Auth->user('id')));
            }
        }
    }
     * 
     */

}

?>