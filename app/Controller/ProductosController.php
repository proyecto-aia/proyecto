<?php

class ProductosController extends AppController {

    var $name = 'Productos';
    var $components = array('Auth', 'Email');

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
                $this->redirect(array('controller' => 'productos', 'action' => 'search', 0));
                break;
            default:
                $this->redirect(array('controller' => 'publicos', 'action' => 'index'));
        }
    }

    function search($buscar = 1) {
        $pantalla = 36;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado	
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                if ($this->Session->check('modulo') || $this->Session->check('modulo_id') || $this->Session->check('modulo_titulo') || $this->Session->check('modulo_codigo')) {
                    $this->Session->delete('modulo');
                    $this->Session->delete('modulo_id');
                    $this->Session->delete('modulo_titulo');
                    $this->Session->delete('modulo_codigo');
                }

                // lista de MONEDAS
                $this->loadModel('Moneda');
                $this->Moneda->recursive = -1;
                $monedas = $this->Moneda->find('list');
                $this->set('monedas', $monedas);

                if ($buscar == 1) {

                    $titulo = $this->request->data['Producto']['titulo'];
                    $codigo = $this->request->data['Producto']['codigo'];
                    $moneda = $this->request->data['Producto']['moneda_id'];
                    $estado = $this->request->data['Producto']['status'];

                    if ($codigo != "") {
                        //$conditions1 = array('User.username' => $username); 
                        $conditions5 = array('Producto.codigo LIKE' => "%" . $codigo . "%");
                    } else {
                        $conditions5 = "true";
                    }

                    if ($titulo != "") {
                        //$conditions1 = array('User.username' => $username); 
                        $conditions4 = array('Producto.titulo LIKE' => "%" . $titulo . "%");
                    } else {
                        $conditions4 = "true";
                    }

                    if ($moneda != "") {
                        $conditions3 = array('Producto.moneda_id' => $moneda);
                    } else {
                        $conditions3 = "true";
                    }

                    if ($estado != "") {
                        $conditions2 = array('Producto.status' => $estado);
                    } else {
                        $conditions2 = "true";
                    }

                    if (($this->request->data['Producto']['fecha_ini']['year'] != "") AND ( $this->request->data['Producto']['fecha_ini']['month'] != "") AND ( $this->request->data['Producto']['fecha_ini']['day'] != "") AND ( $this->request->data['Producto']['fecha_fin']['year'] != "") AND ( $this->request->data['Producto']['fecha_fin']['month'] != "") AND ( $this->request->data['Producto']['fecha_fin']['day'] != "")
                    ) {

                        $fecha_ini = $this->request->data['Producto']['fecha_ini']['year'] . "-" . $this->request->data['Producto']['fecha_ini']['month'] . "-" . $this->request->data['Producto']['fecha_ini']['day'];
                        $fecha_fin = $this->request->data['Producto']['fecha_fin']['year'] . "-" . $this->request->data['Producto']['fecha_fin']['month'] . "-" . $this->request->data['Producto']['fecha_fin']['day'];

                        if ((date(strtotime($fecha_ini))) <= (date(strtotime($fecha_fin)))) {

                            $conditions1 = array('Producto.fecha between ? and ?' => array($fecha_ini, $fecha_fin));
                        } else {
                            $this->Session->setFlash('La fecha de Inicio es mayor que la fecha de Fin', 'flash_failure');
                            $this->redirect('index');
                        }
                    } else if (($this->request->data['Producto']['fecha_ini']['year'] == "") AND ( $this->request->data['Producto']['fecha_ini']['month'] == "") AND ( $this->request->data['Producto']['fecha_ini']['day'] == "") AND ( $this->request->data['Producto']['fecha_fin']['year'] == "") AND ( $this->request->data['Producto']['fecha_fin']['month'] == "") AND ( $this->request->data['Producto']['fecha_fin']['day'] == "")
                    ) {

                        $conditions1 = "true";
                    } else if (($this->request->data['Producto']['fecha_ini']['year'] == "") AND ( $this->request->data['Producto']['fecha_ini']['month'] == "") AND ( $this->request->data['Producto']['fecha_ini']['day'] == "") AND ( $this->request->data['Producto']['fecha_fin']['year'] != "") AND ( $this->request->data['Producto']['fecha_fin']['month'] != "") AND ( $this->request->data['Producto']['fecha_fin']['day'] != "")
                    ) {


                        $fecha_fin = $this->request->data['Producto']['fecha_fin']['year'] . "-" . $this->request->data['Producto']['fecha_fin']['month'] . "-" . $this->request->data['Producto']['fecha_fin']['day'];

                        $conditions1 = array('Producto.fecha <= ?' => array($fecha_fin));
                    } else if (($this->request->data['Producto']['fecha_ini']['year'] != "") AND ( $this->request->data['Producto']['fecha_ini']['month'] != "") AND ( $this->request->data['Producto']['fecha_ini']['day'] != "") AND ( $this->request->data['Producto']['fecha_fin']['year'] == "") AND ( $this->request->data['Producto']['fecha_fin']['month'] == "") AND ( $this->request->data['Producto']['fecha_fin']['day'] == "")
                    ) {


                        $fecha_ini = $this->request->data['Producto']['fecha_ini']['year'] . "-" . $this->request->data['Producto']['fecha_ini']['month'] . "-" . $this->request->data['Producto']['fecha_ini']['day'];

                        $conditions1 = array('Producto.fecha >= ?' => array($fecha_ini));
                    } else {
                        $this->Session->setFlash('Debe ingresar una Fecha v&aacute;lida', 'flash_failure');
                        $this->redirect('index');
                    }


                    $this->Producto->recursive = 0;
                    $productos_encontrados = $this->Producto->find('all', array('conditions' => array($conditions1, $conditions2, $conditions3, $conditions4, $conditions5), 'order' => array('Producto.fecha DESC', 'Producto.status ASC')));
                } else {
                    $productos_encontrados = array();
                }

                $this->set('productos_encontrados', $productos_encontrados);
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
        $pantalla = 37;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado			
                //Obtengo los datos de la notica que queremos ver con el ID pasado por parametro. 
                $this->Producto->recursive = 1;
                $this->set('producto', $this->Producto->read(null, $id));
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
        $pantalla = 38;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                // lista de MONEDAS
                $this->loadModel('Moneda');
                $this->Moneda->recursive = -1;
                $monedas = $this->Moneda->find('list');
                $this->set('monedas', $monedas);

                if (!empty($this->request->data)) {
                    $this->Producto->set($this->request->data);
                    if ($this->Producto->validates()) {
                        $this->Producto->save($this->request->data, false);

                        $this->Producto->saveField('user_created', $this->Auth->user('id'));

                        $this->Session->setFlash('Producto agregado correctamente', 'flash_success');
                        $this->redirect('index');
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
        $pantalla = 39;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                // lista de MONEDAS
                $this->loadModel('Moneda');
                $this->Moneda->recursive = -1;
                $monedas = $this->Moneda->find('list');
                $this->set('monedas', $monedas);

                if (!empty($this->request->data)) {
                    $this->Producto->set($this->request->data);
                    if ($this->Producto->validates()) {
                        $this->Producto->save($this->request->data, false);

                        $this->Producto->saveField('user_modified', $this->Auth->user('id'));

                        $this->Session->setFlash('Producto actualizado correctamente', 'flash_success');
                        $this->redirect('index');
                    }
                } else {
                    $this->Producto->recursive = -1;
                    $producto = $this->Producto->findById($id);
                    if (empty($producto)) {
                        $this->Session->setFlash('ID de Producto inv&aacute;lido', 'flash_failure');
                        $this->redirect('add');
                    } else {
                        $this->request->data = $producto;
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
        $pantalla = 40;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado
                $delete_count = 0;
                if (!empty($this->request->data['Producto']['delete'])) {
                    foreach ($this->request->data['Producto']['delete'] as $id => $delete) {
                        if ($delete == 1) {
                            if ($this->Producto->delete($id)) {
                                $conditions = array('Image.producto_id' => $id);
                                $results = $this->Producto->Image->find('all', array('conditions' => $conditions));
                                foreach ($results as $result) {
                                    if ($this->Producto->Image->delete($result['Image']['id'])) {
                                        $this->Producto->Image->delImage($result['Image']['location']);
                                    }
                                }
                                $delete_count++;
                            }
                        }
                    }
                }
                $this->Session->setFlash($delete_count . ' Producto' . (($delete_count == 1) ? ' fue' : 's fueron') . ' eliminado/s', 'flash_success');
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

    function pre_send($id = null) {
        $pantalla = 41;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                if ($id) {
                    $this->set('usuario', $this->Auth->user('username')); // Usuario Logeado
                    $this->set('usuario_id', $this->Auth->user('id')); // Usuario Logeado

                    $this->Producto->recursive = 1;
                    $producto = $this->Producto->findById($id);
                    if (empty($producto)) {
                        $this->Session->setFlash('ID de Producto inv&aacute;lido', 'flash_failure');
                        $this->redirect('index');
                    } else {
                        $this->set('producto', $producto);
                    }
                } else {
                    $this->Session->setFlash('ID de Producto inv&aacute;lido', 'flash_failure');
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

    function send() {
        $pantalla = 41;
        $this->_refreshAuth();
        if (($this->Auth->user('role_id') == 2) && ($this->Auth->user('status') == 'Activo')) {
            $permiso = $this->permiso_pantalla($this->Auth->user('id'), $pantalla);
            if ($permiso) {
                if ($this->request->data['Producto']['id_producto'] != "") {
                    //completar 
                    // Obtengo el correo de cada USUARIO
                    $this->loadModel('User');
                    $this->User->recursive = -1;
                    $result1 = $this->User->find('all', array('fields' => array('User.email')
                            )
                    );

                    // Obtengo el Producto a enviar 
                    $this->Producto->recursive = 0;
                    $producto = $this->Producto->findById($this->request->data['Producto']['id_producto']);

                    /*
                      $emails = "";
                      foreach($result1 as $r1) {
                      $emails .= $r1['User']['email'].",";
                      }

                      if ($emails != ""){
                      $emails = substr($emails,0,strlen($emails)-1);
                      }
                     */

                    $emails = array();
                    if (is_array($emails)) {
                        foreach ($result1 as $r1) {
                            $emails[] = $r1['User']['email'];
                        }
                    }

                    $this->Email->delivery = 'smtp';
                    $this->Email->smtpOptions = array(
                        'port' => '465',
                        'timeout' => '30',
                        'host' => 'ssl://smtp.gmail.com',
                        'username' => 'el.viejo.martin.webmaster@gmail.com',
                        'password' => 'fedora1234',
                        'auth' => true,
                    );

                    //$this->Email->from = 'el.viejo.martin.webmaster@gmail.com';  				 
                    $this->Email->to = 'el.viejo.martin.webmaster@gmail.com';
                    //$this->Email->to = $emails;
                    $this->Email->bcc = $emails;
                    //$this->Email->replyTo = $this->request->data['Publicos']['name'].' <'.$this->request->data['Publicos']['email'].'>'; 
                    //$this->Email->bcc = array('el.viejo.martin@gmail.com');      
                    $this->Email->subject = "Config Sistemas - Productos destacados";
                    $this->Email->sendAs = 'both';

                    $cuerpo_correo = "
                    <table style='padding:2%'>
                        <tbody>
                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                    			<td style='text-align:right'><span><b>Fecha:</b></span></td>	
                                    			<td style='text-align:left'><span>" . date('d-m-Y', strtotime($producto['Producto']['fecha'])) . "</span></td>
                                    		</tr>
                                    		<tr>
                                    			<td style='text-align:right'><span><b>T&iacute;tulo:</b></span></td>	
                                    			<td style='text-align:left'><span>" . $producto['Producto']['titulo'] . "</span></td>
                                  		    </tr>
                                    		<tr>
                                    			<td style='text-align:right'><span><b>C&oacute;digo:</b></span></td>	
                                    			<td style='text-align:left'><span>" . $producto['Producto']['codigo'] . "</span></td>
                                  		    </tr>                                          
                                    		<tr>
                                    			<td style='text-align:right'><span><b>Contenido:</b></span></td>	
                                    			<td style='text-align:left'><span>" . $producto['Producto']['descripcion'] . "</span></td>
                                    		</tr>
                    						<tr>
                    							<td style='text-align:right'><span><b>Moneda:</b></span></td>	
                    							<td style='text-align:left'><span>" . $producto['Moneda']['nombre'] . "</span></td>
                    						</tr>                        
                    						<tr>
                    							<td style='text-align:right'><span><b>Precio Actual:</b></span></td>	
                    							<td style='text-align:left'><span>" . $producto['Moneda']['simbolo'] . " " . $producto['Producto']['precio_actual'] . "</span></td>
                    						</tr>
                    						<tr>
                    							<td style='text-align:right'><span><b>Precio Anterior:</b></span></td>	
                    							<td style='text-align:left'><span>" . $producto['Moneda']['simbolo'] . " " . $producto['Producto']['precio_anterior'] . "</span></td>
                    						</tr>
                                            <tr>
                                                <td>
                                                    <br/>
                                                </td>
                                            </tr>                                            
                                    		<tr>
                                    			<td style='text-align:right'></td>	
                                    			<td style='text-align:left'><span><a href='http://www.configsistemas.com/publicos/view_producto/" . $producto['Producto']['id'] . "' target='_blank'>Ir al Producto</a></span></td>
                                    		</tr>                           
                                        </tbody>
                                    </table>                           
                                </td>
                            </tr>      
                    	</tbody>
                    </table>
                    ";
                    $asunto_correo = $producto['Producto']['titulo'];

                    $this->Session->write('cuerpo_correo', $cuerpo_correo);
                    $this->Session->write('asunto_correo', $asunto_correo);
                    $this->Email->template = 'correo';

                    if ($this->Email->send()) {
                        $this->Session->setFlash('Producto Enviado', 'flash_success');
                        $this->redirect('index');
                    } else {
                        $this->Session->setFlash('Producto no enviado', 'flash_failure');
                        $this->redirect('index');
                    }

                    if ($this->Session->check('cuerpo_correo') || $this->Session->check('asunto_correo')) {
                        $this->Session->delete('cuerpo_correo');
                        $this->Session->delete('asunto_correo');
                    }
                } else {
                    $this->Session->setFlash('ID de Producto inv&aacute;lido', 'flash_failure');
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