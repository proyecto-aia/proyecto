<?php

class ImagesController extends AppController {

    var $name = 'Images';
    var $components = array('Auth');

    function afterFilter() {
        // Update User last_access datetime
        if ($this->Auth->user()) {
            $this->loadModel('User');
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_access', date('Y-m-d H:i:s'));
        }
    }

    function index($modulo = null, $id = null) {
        //$this->_refreshAuth();
        switch ($this->Auth->user('role_id')) {
            case 1:
                $this->Session->setFlash('Acceso denegado', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
                break;
            case 2:
                if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
                    if ($modulo and $id) {

                        //$array_pantallas = array(12,42,56);
                        //$permiso = $this->permiso_array_pantallas($this->Auth->user('id'),$array_pantallas);
                        $pantalla = null;
                        switch ($modulo) {
                            case 'Noticia':
                                $pantalla = 12;
                                break;
                            case 'Producto':
                                $pantalla = 42;
                                break;
                            case 'Album':
                                $pantalla = 56;
                                break;
                        }
                        $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
                        if ($permiso) {

                            //$this->set($this->paginate());					
                            $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                            $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                            $this->Session->write('modulo', $modulo);
                            $this->set('modulo', $this->Session->read('modulo'));

                            $this->Session->write('modulo_id', $id);
                            $this->set('modulo_id', $this->Session->read('modulo_id'));

                            switch ($this->Session->read('modulo')) {
                                case 'Noticia':
                                    $this->Image->recursive = 1;
                                    $conditions = array('Noticia.id' => $this->Session->read('modulo_id'));
                                    $result = $this->Image->Noticia->find('first', array('conditions' => $conditions));
                                    $this->set('images', $result);

                                    $this->Session->write('modulo_titulo', $result['Noticia']['titulo']);
                                    $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));
                                    break;
                                case 'Producto':
                                    $this->Image->recursive = 1;
                                    $conditions = array('Producto.id' => $this->Session->read('modulo_id'));
                                    $result = $this->Image->Producto->find('first', array('conditions' => $conditions));
                                    $this->set('images', $result);

                                    $this->Session->write('modulo_titulo', $result['Producto']['titulo']);
                                    $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));

                                    $this->Session->write('modulo_codigo', $result['Producto']['codigo']);
                                    $this->set('modulo_codigo', $this->Session->read('modulo_codigo'));
                                    break;
                                case 'Album':
                                    $this->Image->recursive = 1;
                                    $conditions = array('Album.id' => $this->Session->read('modulo_id'));
                                    $result = $this->Image->Album->find('first', array('conditions' => $conditions));
                                    $this->set('images', $result);

                                    $this->Session->write('modulo_titulo', $result['Album']['titulo']);
                                    $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));
                                    break;
                            }
                        } else {
                            $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                            $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
                        }
                    } else {
                        if ($this->Session->check('modulo') and $this->Session->check('modulo_id')) {

                            $pantalla = null;
                            $modulo = $this->Session->read('modulo');
                            switch ($modulo) {
                                case 'Noticia':
                                    $pantalla = 12;
                                    break;
                                case 'Producto':
                                    $pantalla = 42;
                                    break;
                                case 'Album':
                                    $pantalla = 56;
                                    break;
                            }
                            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
                            if ($permiso) {
                                $this->set('usuario', $this->Auth->user('username')); // Usuario
                                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                                $this->set('modulo', $this->Session->read('modulo'));
                                $this->set('modulo_id', $this->Session->read('modulo_id'));

                                if ($this->Session->check('modulo_codigo')) {
                                    $this->set('modulo_codigo', $this->Session->read('modulo_codigo'));
                                }

                                switch ($this->Session->read('modulo')) {
                                    case 'Noticia':
                                        $this->Image->recursive = 1;
                                        $conditions = array('Noticia.id' => $this->Session->read('modulo_id'));
                                        $result = $this->Image->Noticia->find('first', array('conditions' => $conditions));
                                        $this->set('images', $result);

                                        $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));
                                        break;
                                    case 'Producto':
                                        $this->Image->recursive = 1;
                                        $conditions = array('Producto.id' => $this->Session->read('modulo_id'));
                                        $result = $this->Image->Producto->find('first', array('conditions' => $conditions));
                                        $this->set('images', $result);

                                        $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));
                                        $this->set('modulo_codigo', $this->Session->read('modulo_codigo'));
                                        break;
                                    case 'Album':
                                        $this->Image->recursive = 1;
                                        $conditions = array('Album.id' => $this->Session->read('modulo_id'));
                                        $result = $this->Image->Album->find('first', array('conditions' => $conditions));
                                        $this->set('images', $result);

                                        $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));
                                        break;
                                }

                                if (!empty($this->request->data)) {

                                    $modulo = $this->Session->read('modulo');
                                    $pantalla = null;
                                    switch ($modulo) {
                                        case 'Noticia':
                                            $pantalla = 14;
                                            break;
                                        case 'Producto':
                                            $pantalla = 44;
                                            break;
                                        case 'Album':
                                            $pantalla = 58;
                                            break;
                                    }
                                    $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
                                    if ($permiso) {
                                        $this->Image->recursive = -1;   // Profundidad en Image nomas.

                                        $maximo_imagenes = 0;
                                        switch ($this->Session->read('modulo')) {
                                            case 'Noticia':
                                                $all_images = $this->Image->find('all', array('conditions' => array('Image.noticia_id' => $this->Session->read('modulo_id'))));
                                                $maximo_imagenes = 5;
                                                break;
                                            case 'Producto':
                                                $all_images = $this->Image->find('all', array('conditions' => array('Image.producto_id' => $this->Session->read('modulo_id'))));
                                                $maximo_imagenes = 10;
                                                break;
                                            case 'Album':
                                                $all_images = $this->Image->find('all', array('conditions' => array('Image.album_id' => $this->Session->read('modulo_id'))));
                                                $maximo_imagenes = 100;
                                                break;
                                        }

                                        $cantidad = count($all_images);  // Cuenta la cantidad de imagenes.

                                        if ($cantidad < $maximo_imagenes) {
                                            $this->Image->set($this->request->data); // Envia los datos al model					
                                            if ($this->Image->validates()) {
                                                $this->Image->create();
                                                // how to ensure unique file names?
                                                // TODO: Code to warn user about duplicate files
                                                $newName = $this->Image->saveImage($this->request['data']['Image']['location'], 100, "ht", 80);
                                                if (isset($newName)) {
                                                    $this->request['data']['Image']['location'] = $newName;
                                                } else {
                                                    $this->request['data']['Image']['location'] = null;
                                                    // TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
                                                    //die("No se pudo almacenar la Imagen");
                                                    $this->Session->setFlash('No se pudo almacenar la Imagen', 'flash_failure');
                                                    $this->redirect('index');
                                                }

                                                if ($this->Image->save($this->request->data)) {
                                                    $this->Image->saveField('user_created', $this->Auth->user('id'));
                                                    $this->Session->setFlash('La Imagen ha sido almacenada', 'flash_success');
                                                    $this->redirect('index');
                                                } else {
                                                    $this->Session->setFlash('No se pudo almacenar la Imagen', 'flash_failure');
                                                    $this->redirect('index');
                                                }
                                            } else {
                                                $this->Session->setFlash('Error al validar la imagen<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                                                $this->redirect('index');
                                            }
                                        } else {
                                            $this->Session->setFlash('No se puede agregar mas im&aacute;genes', 'flash_failure');
                                            $this->redirect('index');
                                        }
                                    } else {
                                        $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                                        $this->redirect('index');
                                    }
                                }
                            } else {
                                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
                            }
                        } else {
                            $this->Session->setFlash('Error con variables de sesi&oacute;n<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                            $this->redirect('index');
                        }
                        //$this->redirect('index');                    
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
            default:
                $this->redirect(array('controller' => 'publicos', 'action' => 'index'));
        }
    }

    function view($id = null) {
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            //$array_pantallas = array(13,43,57);
            //$permiso = $this->permiso_array_pantallas($this->Auth->user('id'),$array_pantallas);
            $modulo = $this->Session->read('modulo');
            $pantalla = null;
            switch ($modulo) {
                case 'Noticia':
                    $pantalla = 13;
                    break;
                case 'Producto':
                    $pantalla = 43;
                    break;
                case 'Album':
                    $pantalla = 57;
                    break;
            }
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                if ($this->Session->check('modulo') and $this->Session->check('modulo_id') and $this->Session->check('modulo_titulo')) {
                    $this->set('modulo', $this->Session->read('modulo'));
                    $this->set('modulo_id', $this->Session->read('modulo_id'));
                    $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));

                    if ($this->Session->check('modulo_codigo')) {
                        $this->set('modulo_codigo', $this->Session->read('modulo_codigo'));
                    }
                }

                if (!$id) {
                    $this->Session->setFlash('Imagen inv&aacute;lida', 'flash_failure');
                    $this->redirect('index');
                }

                $this->Image->recursive = -1;
                $this->set('image', $this->Image->read(null, $id));
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function add() {
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            //$array_pantallas = array(14,44,58);
            //$permiso = $this->permiso_array_pantallas($this->Auth->user('id'),$array_pantallas);
            $modulo = $this->Session->read('modulo');
            $pantalla = null;
            switch ($modulo) {
                case 'Noticia':
                    $pantalla = 14;
                    break;
                case 'Producto':
                    $pantalla = 44;
                    break;
                case 'Album':
                    $pantalla = 58;
                    break;
            }
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                if ($this->Session->check('modulo') and $this->Session->check('modulo_id') and $this->Session->check('modulo_titulo')) {
                    $this->set('modulo', $this->Session->read('modulo'));
                    $this->set('modulo_id', $this->Session->read('modulo_id'));
                    $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));

                    if ($this->Session->check('modulo_codigo')) {
                        $this->set('modulo_codigo', $this->Session->read('modulo_codigo'));
                    }
                }

                $this->Image->recursive = -1;   // Profundidad en Image nomas.

                $maximo_imagenes = 0;
                switch ($this->Session->read('modulo')) {
                    case 'Noticia':
                        $all_images = $this->Image->find('all', array('conditions' => array('Image.noticia_id' => $this->Session->read('modulo_id'))));
                        $maximo_imagenes = 5;
                        break;
                    case 'Producto':
                        $all_images = $this->Image->find('all', array('conditions' => array('Image.producto_id' => $this->Session->read('modulo_id'))));
                        $maximo_imagenes = 10;
                        break;
                    case 'Album':
                        $all_images = $this->Image->find('all', array('conditions' => array('Image.album_id' => $this->Session->read('modulo_id'))));
                        $maximo_imagenes = 100;
                        break;
                }

                $cantidad = count($all_images);  // Cuenta la cantidad de imagenes.                

                if ($cantidad < $maximo_imagenes) {
                    if (!empty($this->request->data)) {
                        $this->Image->set($this->request->data); // Envia los datos al model					
                        if ($this->Image->validates()) {
                            $this->Image->create();
                            // how to ensure unique file names?
                            // TODO: Code to warn user about duplicate files
                            $newName = $this->Image->saveImage($this->request['data']['Image']['location'], 100, "ht", 80);
                            if (isset($newName)) {
                                $this->request['data']['Image']['location'] = $newName;
                            } else {
                                $this->request['data']['Image']['location'] = null;
                                // TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
                                //die("No se pudo almacenar la Imagen");
                                $this->Session->setFlash('No se pudo almacenar la Imagen', 'flash_failure');
                                $this->redirect('index');
                            }

                            if ($this->Image->save($this->request->data)) {
                                $this->Image->saveField('user_created', $this->Auth->user('id'));
                                $this->Session->setFlash('La Imagen ha sido almacenada', 'flash_success');
                                $this->redirect('index');
                            } else {
                                $this->Session->setFlash('No se pudo almacenar la Imagen', 'flash_failure');
                                $this->redirect('index');
                            }
                        }
                    }
                } else {
                    $this->Session->setFlash('No se puede agregar mas im&aacute;genes', 'flash_failure');
                    $this->redirect('index');
                }
            } else {
                $this->Session->setFlash('No tiene permisos para acceder a esta Pantalla<br>Comun&iacute;quese con el Administrador', 'flash_failure');
                $this->redirect(array('controller' => 'users', 'action' => 'redireccion'));
            }
        } else {
            $this->Session->setFlash('Acceso denegado', 'flash_failure');
            $this->redirect('index');
        }
    }

    function edit($id = null) {
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            //$array_pantallas = array(15,45,59);
            //$permiso = $this->permiso_array_pantallas($this->Auth->user('id'),$array_pantallas);
            $modulo = $this->Session->read('modulo');
            $pantalla = null;
            switch ($modulo) {
                case 'Noticia':
                    $pantalla = 15;
                    break;
                case 'Producto':
                    $pantalla = 45;
                    break;
                case 'Album':
                    $pantalla = 59;
                    break;
            }
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                if ($this->Session->check('modulo') and $this->Session->check('modulo_id') and $this->Session->check('modulo_titulo')) {
                    $this->set('modulo', $this->Session->read('modulo'));
                    $this->set('modulo_id', $this->Session->read('modulo_id'));
                    $this->set('modulo_titulo', $this->Session->read('modulo_titulo'));

                    if ($this->Session->check('modulo_codigo')) {
                        $this->set('modulo_codigo', $this->Session->read('modulo_codigo'));
                    }
                }

                $this->Image->recursive = -1;
                $imageData = $this->Image->read();
                if (!$id && empty($this->request->data)) {
                    $this->Session->setFlash('Imagen inv&aacute;lida', 'flash_failure');
                    $this->redirect('index');
                }

                if (!empty($this->request->data)) {
                    /*
                      // Is there a new picture?
                      if ($this->request['data']['Image']['location']['error'] == 0) {
                      // Delete the picture
                      $this->Image->delImage($imageData['Image']['location']);
                      $newName = $this->Image->saveImage($this->request['data']['Image']['location'],100,"ht",80);
                      if(isset($newName))	{
                      $this->request['data']['Image']['location'] = $newName;
                      } else {
                      $this->request['data']['Image']['location'] = null;
                      // TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
                      die("No se pudo almacenar la Imagen"); // VER!!!
                      }
                      } else {
                      // no new picture so keep the old link-location
                      $this->request['data']['Image']['location'] = $imageData['Image']['location'];
                      }
                     */

                    $this->request['data']['Image']['location'] = $imageData['Image']['location'];

                    if ($this->Image->save($this->request->data)) {
                        $this->Image->saveField('user_modified', $this->Auth->user('id'));
                        $this->Session->setFlash('La Imagen ha sido editada', 'flash_success');
                        $this->redirect('index');
                    } else {
                        $this->Session->setFlash('No se pudo editar la Imagen', 'flash_failure');
                        $this->redirect('index');
                    }
                }

                if (empty($this->request->data)) {
                    $this->request->data = $this->Image->read(null, $id);
                    $this->set('image', $this->request->data);
                }
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
        //$this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            //$array_pantallas = array(16,46,60);
            //$permiso = $this->permiso_array_pantallas($this->Auth->user('id'),$array_pantallas);
            $modulo = $this->Session->read('modulo');
            $pantalla = null;
            switch ($modulo) {
                case 'Noticia':
                    $pantalla = 16;
                    break;
                case 'Producto':
                    $pantalla = 46;
                    break;
                case 'Album':
                    $pantalla = 60;
                    break;
            }
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $imageData = $this->Image->read();
                if (!$id) {
                    $this->Session->setFlash('ID de Imagen inv&aacute;lida', 'flash_failure');
                    $this->redirect('index');
                }
                if ($this->Image->delete($id)) {
                    $this->Image->delImage($imageData['Image']['location']);
                    $this->Session->setFlash('Imagen eliminada', 'flash_success');
                    $this->redirect('index');
                }
                $this->Session->setFlash('No se pudo eliminar la Imagen', 'flash_failure');
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