<?php

class UsersController extends AppController {

    var $name = 'Users';
    var $captcha;
    var $components = array(
        'Auth' => array(
            'autoRedirect' => false,
            'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'publicos', 'action' => 'index'),
        )
    );

    function afterFilter() {
        // Update User last_access datetime
        if ($this->Auth->user()) {
            $this->loadModel('User');
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_access', date('Y-m-d H:i:s'));
        }
    }

    // Para entrar sin login y crear el primer usuario
    /*
      function beforeFilter() {
      $this->Auth->allow('*');
      }
     */

    /**
     * Set this to false if you don't want to store clear passwords in the database
     * @var bool
     * @access private
     */
    var $_store_clear_password = false;

    function index() {
        $this->_refreshAuth();
        switch ($this->Auth->user('role_id')) {
            case 1:
                $this->redirect(array('controller' => 'users', 'action' => 'home'));
                break;
            case 2:
                $this->redirect(array('controller' => 'gestiones', 'action' => 'index'));
                break;
            default:
                $this->redirect(array('controller' => 'publicos', 'action' => 'index'));
        }
    }

    function login() {

        $this->captcha = true; // ATENCION: Poner en 'false' para que funcione el captcha correctamente
        if (isset($this->request->data['User']['ver_code'])) {
            if ($this->Session->read('ver_code') == $this->request->data['User']['ver_code']) {
                $this->captcha = true;
            }
        }

        if (!empty($this->request->data) && $this->Auth->login() && $this->captcha) {
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_login', date('Y-m-d H:i:s'));
            $this->Session->setFlash('Logueado correctamente', 'flash_success');
            $this->redirect(array('action' => 'index'));
        } elseif (!empty($this->request->data) && $this->captcha) {
            $this->request->data['User']['password'] = '';
            $this->request->data['User']['ver_code'] = '';
            $this->Auth->logout();
            $this->Session->setFlash('Usuario o Contrase&ntilde;a incorrectos. Si olvid&oacute; su contrase&ntilde;a comun&iacute;quese con el Administrador', 'flash_failure');
        } elseif (!empty($this->request->data) && !$this->captcha) {
            $this->request->data['User']['password'] = '';
            $this->request->data['User']['ver_code'] = '';
            $this->Auth->logout();
            $this->Session->setFlash('C&oacute;digo de seguridad incorrecto', 'flash_failure');
        }

        $this->create_captcha();
        $this->render();
    }

    function logout() {
        /*
          if ($this->Session->check('noticia_id') || $this->Session->check('noticia_titulo') || $this->Session->check('user_id') || $this->Session->delete('user_name') || $this->Session->delete('user_role')) {
          $this->Session->delete('noticia_id');
          $this->Session->delete('noticia_titulo');
          $this->Session->delete('user_id');
          $this->Session->delete('user_name');
          $this->Session->delete('user_role');
          } */
        if ($this->Session->check('modulo') || $this->Session->check('modulo_id') || $this->Session->check('modulo_titulo') || $this->Session->check('modulo_codigo') || $this->Session->check('user_id') || $this->Session->delete('user_name') || $this->Session->delete('user_role')) {
            $this->Session->delete('modulo');
            $this->Session->delete('modulo_id');
            $this->Session->delete('modulo_titulo');
            $this->Session->delete('modulo_codigo');
            $this->Session->delete('user_id');
            $this->Session->delete('user_name');
            $this->Session->delete('user_role');
        }

        $this->Session->destroy();
        $this->Session->setFlash('Sesi&oacute;n finalizada', 'flash_info');
        $this->redirect($this->Auth->logout());
    }

    function home() {
        $this->_refreshAuth();
        switch ($this->Auth->user('role_id')) {
            case 1:
                if ($this->Auth->user('status') == 'Activo') {
                    $this->set('home');
                    $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                    $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado	
                    if ($this->Session->check('user_id') || $this->Session->check('user_name') || $this->Session->check('user_role')) {
                        $this->Session->delete('user_id');
                        $this->Session->delete('user_name');
                        $this->Session->delete('user_role');
                    }
                } elseif ($this->Auth->user('status') == 'Inactivo') {
                    $this->Session->setFlash('Usuario inactivo', 'flash_failure');
                    $this->redirect('inactivo');
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

    function inactivo() {
        $this->_refreshAuth();
        if ($this->Auth->user('status') == 'Inactivo') {
            $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado	
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function search($buscar = 1) {
        $pantalla = 1;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado	
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                if ($this->Session->check('user_id') || $this->Session->check('user_name') || $this->Session->check('user_role')) {
                    $this->Session->delete('user_id');
                    $this->Session->delete('user_name');
                    $this->Session->delete('user_role');
                }

                // lista de ROLES para el buscador
                $this->loadModel('Role');
                $this->Role->recursive = -1;
                $roles = $this->Role->find('list');
                $this->set('roles', $roles);

                if ($buscar == 1) {

                    $id = $this->Auth->user('id');
                    $username = $this->request->data['User']['username'];
                    $nombre = $this->request->data['User']['first_name'];
                    $apellido = $this->request->data['User']['last_name'];
                    $email = $this->request->data['User']['email'];
                    $rol = $this->request->data['User']['role_id'];
                    $estado = $this->request->data['User']['status'];

                    // Para que no muestre el administrador en caso que el usuario no sea el administrador
                    if ($id != 1) {
                        $conditions_admin = array('User.id !=' => 1);
                    } else {
                        $conditions_admin = "true";
                    }

                    if ($username != "") {
                        //$conditions1 = array('User.username' => $username); 
                        $conditions1 = array('User.username LIKE' => "%" . $username . "%");
                    } else {
                        $conditions1 = "true";
                    }

                    if ($nombre != "") {
                        //$conditions2 = array('User.first_name' => $nombre); 
                        $conditions2 = array('User.first_name LIKE' => "%" . $nombre . "%");
                    } else {
                        $conditions2 = "true";
                    }

                    if ($apellido != "") {
                        //$conditions3 = array('User.last_name' => $apellido); 
                        $conditions3 = array('User.last_name LIKE' => "%" . $apellido . "%");
                    } else {
                        $conditions3 = "true";
                    }

                    if ($email != "") {
                        //$conditions4 = array('User.email' => $email); 
                        $conditions4 = array('User.email LIKE' => "%" . $email . "%");
                    } else {
                        $conditions4 = "true";
                    }

                    if ($rol != "") {
                        $conditions5 = array('User.role_id' => $rol);
                    } else {
                        $conditions5 = "true";
                    }

                    if ($estado != "") {
                        $conditions6 = array('User.status' => $estado);
                    } else {
                        $conditions6 = "true";
                    }

                    $this->User->recursive = 0;
                    $users_encontrados = $this->User->find('all', array('conditions' => array($conditions_admin, $conditions1, $conditions2, $conditions3, $conditions4, $conditions5, $conditions6),
                        'order' => array('User.role_id ASC', 'User.status ASC'),
                    ));
                } else {
                    $users_encontrados = array();
                }

                $this->set('users_encontrados', $users_encontrados);
                $this->set('buscar', $buscar);
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function view($id = null) {
        $pantalla = 2;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                //Obtengo los datos del usuario que queremos ver con el ID pasado por parametro. 
                $user = $this->User->read(null, $id);
                $this->set('user', $user);
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function add() {
        $pantalla = 3;
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $roles = $this->User->Role->find('list');
                $this->set(compact('roles'));
                if (!empty($this->request->data)) {
                    $this->User->set($this->request->data);
                    if ($this->User->validates()) {
                        $this->request->data['User']['password'] = $this->request->data['User']['clear_password'];
                        $this->request->data = $this->Auth->hashPasswords($this->request->data);
                        if (!$this->_store_clear_password) {
                            unset($this->request->data['User']['clear_password']);
                        }

                        $this->User->save($this->request->data, false);
                        $this->User->saveField('user_created', $this->Auth->user('id'));

                        $this->Session->setFlash('Usuario agregado correctamente', 'flash_success');
                        $this->redirect('search');
                    }
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function edit($id = null) {
        $pantalla = 4;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $roles = $this->User->Role->find('list');
                $this->set(compact('roles'));
                if (!empty($this->request->data)) {
                    $fields = array_keys($this->request->data['User']);
                    if (!empty($this->request->data['User']['clear_password']) || !empty($this->request->data['User']['confirm_password'])) {
                        $fields[] = 'password';
                    } else {
                        $fields = array_diff($fields, array('clear_password', 'confirm_password'));
                    }
                    $this->User->set($this->request->data);
                    if ($this->User->validates()) {
                        if (!empty($this->request->data['User']['clear_password'])) {
                            $this->request->data['User']['password'] = $this->request->data['User']['clear_password'];
                        }
                        $this->request->data = $this->Auth->hashPasswords($this->request->data);
                        if (!$this->_store_clear_password) {
                            unset($this->request->data['User']['clear_password']);
                        }

                        $this->User->save($this->request->data, false, $fields);

                        // De esta manera solo edita lo que no esta en el form
                        $this->User->saveField('user_modified', $this->Auth->user('id'));

                        $this->_refreshAuth(); // Actualiza en componente Auth
                        $this->Session->setFlash('Usuario actualizado correctamente', 'flash_success');
                        $this->redirect('search');
                    }
                } else {
                    $user = $this->User->findById($id);
                    if (empty($user)) {
                        $this->Session->setFlash('ID de Usuario inv&aacute;lido', 'flash_failure');
                        $this->redirect('add');
                    } else {
                        unset($user['User']['clear_password']);
                        $this->request->data = $user;
                    }
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function delete() {
        $pantalla = 5;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 1) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $delete_count = 0;

                // Busco si el usuario se quiere eliminar a si mismo
                $bandera_eliminar = true;
                if (!empty($this->request->data['User']['delete'])) {
                    foreach ($this->request->data['User']['delete'] as $id => $delete) {
                        if ($delete == 1) {
                            if ($id == $this->Auth->user('id')) {
                                $bandera_eliminar = false;
                            }
                        }
                    }
                }

                if ($bandera_eliminar) {

                    // Borro usuarios seleccionados
                    if (!empty($this->request->data['User']['delete'])) {
                        foreach ($this->request->data['User']['delete'] as $id => $delete) {
                            if ($delete == 1) {
                                if ($this->User->delete($id)) {
                                    $delete_count++;
                                }
                            }
                        }
                    }

                    $this->Session->setFlash($delete_count . ' Usuario' . (($delete_count == 1) ? ' fue' : 's fueron') . ' eliminado/s', 'flash_success');
                    $this->redirect('search');
                } else {
                    $this->Session->setFlash('No puede eliminar su Usuario', 'flash_failure');
                    $this->redirect('search');
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function editpassword($id = null) {
        $pantalla = 6;
        $this->_refreshAuth();
        if ($this->Auth->user('status') == 'Activo') {
            //$permiso = $this->permiso_pantalla($this->Auth->user('id'),$pantalla);
            //No se evalua el permiso ya que el usuario siempre va a poder acceder a esta pantalla

            $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado	
            $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado	
            $this->set('user', $this->User->read(null, $id)); // Datos del Usuario
            $roles = $this->User->Role->find('list');
            $this->set(compact('roles'));
            if (!empty($this->request->data)) {
                $fields = array_keys($this->request->data['User']);
                if (!empty($this->request->data['User']['clear_password']) || !empty($this->request->data['User']['confirm_password'])) {
                    $fields[] = 'password';
                } else {
                    $fields = array_diff($fields, array('clear_password', 'confirm_password'));
                }
                $this->User->set($this->request->data);
                if ($this->User->validates()) {
                    if ($this->request->data['User']['old_password'] == $this->Auth->user('clear_password')) {
                        if (!empty($this->request->data['User']['clear_password'])) {
                            $this->request->data['User']['password'] = $this->request->data['User']['clear_password'];
                        }
                        $this->request->data = $this->Auth->hashPasswords($this->request->data);
                        if (!$this->_store_clear_password) {
                            unset($this->request->data['User']['clear_password']);
                        }
                        $this->User->save($this->request->data, false, $fields);
                        $this->Session->setFlash('Contrase&ntilde;a actualizada correctamente', 'flash_success');
                        $this->_refreshAuth(); // Actualiza en componente Auth para que refresque la clave
                        $this->redirect('index');
                    } else {
                        $this->Session->setFlash('Contrase&ntilde;a actual incorrecta. Si olvid&oacute; su contrase&ntilde;a comun&iacute;quese con el Administrador', 'flash_failure');
                    }
                }
            } else {
                $user = $this->User->findById($id);
                if (empty($user)) {
                    $this->Session->setFlash('ID de Usuario inv&aacute;lido', 'flash_failure');
                    $this->redirect('home');
                } else {
                    unset($user['User']['old_password']);
                    unset($user['User']['clear_password']);
                    unset($user['User']['confirm_password']);
                    $this->request->data = $user;
                }
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

}

?>