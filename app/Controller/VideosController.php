<?php

class VideosController extends AppController {

    var $name = 'Videos';
    var $components = array('Auth');

    function afterFilter() {
        // Update User last_access datetime
        if ($this->Auth->user()) {
            $this->loadModel('User');
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_access', date('Y-m-d H:i:s'));
        }
    }

    function index() {
        $this->_refreshAuth();
        switch ($this->Auth->user('role_id')) {
            case 1:
                $this->Session->setFlash('Acceso denegado', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'home'));
                break;
            case 2:
                $pantalla = 27;
                if ($this->Auth->user('status') == 'Activo') {
                    $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
                    if ($permiso) {
                        $this->Video->recursive = -1;
                        $result1 = $this->Video->find('all', array('order' => array('Video.created DESC')));
                        $this->set('videos', $result1);

                        $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                        $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                    } else {
                        $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                        $this->redirect(array('controller' => 'users', 'action' => 'index'));
                    }
                } elseif ($this->Auth->user('status') == 'Inactivo') {
                    $this->Session->setFlash('Usuario inactivo', 'flash_failure');
                    $this->redirect(array('controller' => 'users', 'action' => 'inactivo'));
                }
                break;
            default:
                $this->redirect(array('controller' => 'publicos', 'action' => 'index'));
        }
    }

    function view($id = null) {
        $pantalla = 28;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado			
                //Obtengo los datos de la notica que queremos ver con el ID pasado por parametro. 
                $this->Video->recursive = 1;
                $this->set('video', $this->Video->read(null, $id));

                // Obtengo el codigo de los videos de Youtube
                $video = $this->Video->read(null, $id);
                $tamanio_codigo = strlen($video['Video']['link']);
                $codigo = substr($video['Video']['link'], $tamanio_codigo - 11, 11);
                $this->set('codigo', $codigo);
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
        $pantalla = 29;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                $all_videos = $this->Video->find('all');
                $maximo_videos = 6;
                $cantidad = count($all_videos);

                if ($cantidad < $maximo_videos) {
                    if (!empty($this->request->data)) {
                        $this->Video->set($this->request->data);
                        if ($this->Video->validates()) {
                            $this->Video->save($this->request->data, false);
                            $this->Video->saveField('user_created', $this->Auth->user('id'));

                            $this->Session->setFlash('Enlace a Video Youtube agregado correctamente', 'flash_success');
                            $this->redirect('index');
                        }
                    }
                } else {
                    $this->Session->setFlash('No se puede agregar mas videos', 'flash_failure');
                    $this->redirect('index');
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
        $pantalla = 30;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                if (!empty($this->request->data)) {
                    $this->Video->set($this->request->data);
                    if ($this->Video->validates()) {
                        $this->Video->save($this->request->data, false);
                        $this->Video->saveField('user_modified', $this->Auth->user('id'));

                        $this->Session->setFlash('Enlace a Video Youtube actualizado correctamente', 'flash_success');
                        $this->redirect('index');
                    }
                } else {
                    $this->Video->recursive = -1;
                    $video = $this->Video->findById($id);
                    if (empty($video)) {
                        $this->Session->setFlash('ID de Video inv&aacute;lido', 'flash_failure');
                        $this->redirect('add');
                    } else {
                        $this->request->data = $video;
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
        $pantalla = 31;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $delete_count = 0;
                if (!empty($this->request->data['Video']['delete'])) {
                    foreach ($this->request->data['Video']['delete'] as $id => $delete) {
                        if ($delete == 1) {
                            if ($this->Video->delete($id)) {
                                $delete_count++;
                            }
                        }
                    }
                }
                $this->Session->setFlash($delete_count . ' Video' . (($delete_count == 1) ? ' fue' : 's fueron') . ' eliminado/s', 'flash_success');
                $this->redirect('index');
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
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