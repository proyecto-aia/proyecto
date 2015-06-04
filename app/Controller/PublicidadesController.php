<?php

class PublicidadesController extends AppController {

    var $name = 'Publicidades';
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
                $pantalla = 22;
                if ($this->Auth->user('status') == 'Activo') {
                    $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
                    if ($permiso) {
                        $this->Publicidade->recursive = -1;
                        $this->set('publicidades', $this->paginate());
                        $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                        $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                        // Funcionalidad para agregar im�genes en la misma p�gina
                        if (!empty($this->request->data)) {
                            $pantalla = 24;
                            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
                            if ($permiso) {
                                $all_publicidades = $this->Publicidade->find('all');

                                $maximo_publicidades = 20;
                                $cantidad = count($all_publicidades);  // Cuenta la cantidad de publicidades.

                                if ($cantidad < $maximo_publicidades) {
                                    $this->Publicidade->set($this->request->data); // Envia los datos al model					
                                    if ($this->Publicidade->validates()) {
                                        $this->Publicidade->create();
                                        // how to ensure unique file names?
                                        // TODO: Code to warn user about duplicate files
                                        $newName = $this->Publicidade->savePublicidade($this->request['data']['Publicidade']['location'], 100, "ht", 80);
                                        if (isset($newName)) {
                                            $this->request['data']['Publicidade']['location'] = $newName;
                                        } else {
                                            $this->request['data']['Publicidade']['location'] = null;
                                            // TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
                                            //die("No se pudo almacenar la Imagen");
                                            $this->Session->setFlash('No se pudo almacenar la Publicidad', 'flash_failure');
                                            $this->redirect('index');
                                        }

                                        if ($this->Publicidade->save($this->request->data)) {
                                            $this->Publicidade->saveField('user_created', $this->Auth->user('id'));
                                            $this->Session->setFlash('La Publicidad ha sido almacenada', 'flash_success');
                                            $this->redirect('index');
                                        } else {
                                            $this->Session->setFlash('No se pudo almacenar la Publicidad', 'flash_failure');
                                            $this->redirect('index');
                                        }
                                    }
                                } else {
                                    $this->Session->setFlash('No se puede agregar mas Publicidades', 'flash_failure');
                                }
                            } else {
                                $this->Session->setFlash('No tiene permisos para agregar Publicidades <br>Comun&iacute;quese con el Administrador', 'flash_failure');
                            }
                        }
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
        $pantalla = 23;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                if (!$id) {
                    $this->Session->setFlash('Publicidad inv&aacute;lida', 'flash_failure');
                    $this->redirect('index');
                }
                $this->Publicidade->recursive = -1;
                $this->set('publicidad', $this->Publicidade->read(null, $id));
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
        $pantalla = 24;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                $this->Publicidade->recursive = -1;   // Profundidad en Publicidade nomas.
                $all_publicidades = $this->Publicidade->find('all');

                $maximo_publicidades = 20;
                $cantidad = count($all_publicidades);  // Cuenta la cantidad de publicidades.

                if ($cantidad < $maximo_publicidades) {
                    if (!empty($this->request->data)) {
                        $this->Publicidade->set($this->request->data); // Envia los datos al model					
                        if ($this->Publicidade->validates()) {
                            $this->Publicidade->create();
                            // how to ensure unique file names?
                            // TODO: Code to warn user about duplicate files
                            $newName = $this->Publicidade->savePublicidade($this->request['data']['Publicidade']['location'], 100, "ht", 80);
                            if (isset($newName)) {
                                $this->request['data']['Publicidade']['location'] = $newName;
                            } else {
                                $this->request['data']['Publicidade']['location'] = null;
                                // TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
                                //die("No se pudo almacenar la Imagen");
                                $this->Session->setFlash('No se pudo almacenar la Publicidad', 'flash_failure');
                                $this->redirect('index');
                            }

                            if ($this->Publicidade->save($this->request->data)) {
                                $this->Publicidade->saveField('user_created', $this->Auth->user('id'));
                                $this->Session->setFlash('La Publicidad ha sido almacenada', 'flash_success');
                                $this->redirect('index');
                            } else {
                                $this->Session->setFlash('No se pudo almacenar la Publicidad', 'flash_failure');
                                $this->redirect('index');
                            }
                        }
                    }
                } else {
                    $this->Session->setFlash('No se puede agregar mas Publicidades', 'flash_failure');
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
        $pantalla = 25;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                $this->Publicidade->recursive = -1;
                $imageData = $this->Publicidade->read();
                if (!$id && empty($this->request->data)) {
                    $this->Session->setFlash('Publicidad inv&aacute;lida', 'flash_failure');
                    $this->redirect('index');
                }

                if (!empty($this->request->data)) {
                    // Is there a new picture?
                    if ($this->request['data']['Publicidade']['location']['error'] == 0) {
                        // Delete the picture
                        $this->Publicidade->delPublicidade($imageData['Publicidade']['location']);
                        $newName = $this->Publicidade->savePublicidade($this->request['data']['Publicidade']['location'], 100, "ht", 80);
                        if (isset($newName)) {
                            $this->request['data']['Publicidade']['location'] = $newName;
                        } else {
                            $this->request['data']['Publicidade']['location'] = null;
                            // TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
                            die("No se pudo almacenar la Publicidad"); // VER!!!
                        }
                    } else {
                        // no new picture so keep the old link-location
                        $this->request['data']['Publicidade']['location'] = $imageData['Publicidade']['location'];
                    }
                    if ($this->Publicidade->save($this->request->data)) {
                        $this->Publicidade->saveField('user_modified', $this->Auth->user('id'));
                        $this->Session->setFlash('La Publicidad ha sido editada', 'flash_success');
                        $this->redirect('index');
                    } else {
                        $this->Session->setFlash('No se pudo editar la Publicidad', 'flash_failure');
                        $this->redirect('index');
                    }
                }
                if (empty($this->request->data)) {
                    $this->request->data = $this->Publicidade->read(null, $id);
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

    function delete($id = null) {
        $pantalla = 26;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $imageData = $this->Publicidade->read();
            if (!$id) {
                $this->Session->setFlash('ID de Publicidad inv&aacute;lida', 'flash_failure');
                $this->redirect('index');
            }
            if ($this->Publicidade->delete($id)) {
                $this->Publicidade->delPublicidade($imageData['Publicidade']['location']);
                $this->Session->setFlash('Publicidad eliminada', 'flash_success');
                $this->redirect('index');
            }
            $this->Session->setFlash('No se pudo eliminar la Publicidad', 'flash_failure');
            $this->redirect('index');
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