<?php
App::uses('AppController', 'Controller');
/**
 * Tumbas Controller
 *
 * @property Tumba $Tumba
 */
class TumbasController extends AppController {
//public $theme= 'Muertos';
public $theme= '960-fluid';
public $uses = array('Tumba', 'Columbario', 'Exterior', 'Nicho', 'Panteon', 'TrasladoTumba');

/*	private function beforeFilter() {

		if($this->Tumba->id == $this->Tumba->Columbario->id){
			$this->Tumba->identificador = $this->Tumba->columbario_id;

		}

	}*/

/**
 * Components
 *
 * @var array
 */
	public $components = array('Session','Search.Prg','RequestHandler');

	public $presetVars = true; // using the model configuration

/**
 * index method
 *
 * @return void
 */
    public function index() {
        
        //Establecer nivel de profundidad de búsqueda
        $this->Tumba->recursive = 0;
        
        //Establecer parámetros de paginación
        $this->Prg->commonProcess();
        $this->paginate = array( 
            'conditions' => $this->Tumba->parseCriteria($this->params->query),
            'contain' => array(
             'Columbario','Nicho','Panteon','Exterior'
            ),
        );
        
        //Devolver paginación
        $this->set('tumbas', $this->paginate());
        
    }

/**
 * add method
 *
 * @return void
 */
    public function nuevo() {
        
        //Devolver las opciones de selección de tipo de tumba
        $this->set('tipo', $this->Tumba->tipo);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            //Crear nueva tumba con id único
            $this->Tumba->create();
            //Asignar población inicial de la tumba
            $this->request->data['Tumba']['poblacion'] = 0;
            //Comprobar el tipo de tumba
            if ($this->request->data['Tumba']['tipo'] == "Columbario") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Columbario->validate['tumba_id']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Nicho") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Nicho->validate['tumba_id']);
                unset($this->request->data['Columbario']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Panteón") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Panteon->validate['tumba_id']);
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Exterior") {
                //Truco del almendruco para guardar una entidad vacía salvo id y clave externa
                $this->request->data['Exterior']['algo'] = "";
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            //Guardar y comprobar éxito
            if ($this->Tumba->saveAssociated($this->request->data)) {
                $this->Session->setFlash(__('La tumba ha sido guardada correctamente.'));
                //Obtener a donde se redireccionará
                $accion = $this->request->query['accion'];
                //Redireccionar según corresponda
                if ($accion == 'guardar_y_nuevo') {
                    $this->redirect(array('action' => 'nuevo'));
                }
                else {
                    $this->redirect(array('action' => 'index'));
                }
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser guardada.'));
            }
        }
        
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function ver($id = null) {
        
        //Asignar id
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
         throw new NotFoundException(__('La tumba especificada no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con la tumba
        $this->Tumba->recursive = -1;
        $tumba = $this->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $id
         ),
         'contain' => array(
          'Columbario','Nicho','Panteon','Exterior',
          'ArrendatarioTumba' => array(
           'conditions' => array(
            'ArrendatarioTumba.estado' => "Actual"
           ),
           'Arrendatario' => array(
            'Persona' => array(
             'fields' => array(
              'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
             ),
            ),
            'fields' => array(
             'Arrendatario.id', 'Arrendatario.persona_id', 'Arrendatario.direccion', 'Arrendatario.localidad', 'Arrendatario.provincia', 'Arrendatario.pais', 'Arrendatario.codigo_postal', 'Arrendatario.telefono', 'Arrendatario.correo_electronico'
            ),
           ),
          ),
          'Enterramiento' => array(
           'Licencia' => array(
            'fields' => array(
             'Licencia.id', 'Licencia.identificador'
            ),
           ),
           'Difunto' => array(
            'Persona' => array(
             'fields' => array(
              'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
             ),
            ),
            'fields' => array(
             'Difunto.id', 'Difunto.persona_id'
            ),
           ),
           'fields' => array(
            'Enterramiento.id', 'Enterramiento.difunto_id', 'Enterramiento.licencia_id', 'Enterramiento.tumba_id', 'Enterramiento.fecha'
           ),
          ),
          'Difunto' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Difunto.id', 'Difunto.persona_id', 'Difunto.estado', 'Difunto.fecha_defuncion', 'Difunto.edad_defuncion', 'Difunto.causa_defuncion'
           ),
          ),
          'TrasladoTumba' => array(
           'Traslado' => array(
            'fields' => array(
             'Traslado.id', 'Traslado.fecha', 'Traslado.cementerio_origen', 'Traslado.cementerio_destino', 'Traslado.motivo'
            ),
           ),
           'Tumba' => array(
            'Columbario','Nicho','Panteon','Exterior',
            'fields' => array(
             'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
            ),
           ),
          ),
         ),
        ));
        
        //Ñapa para evitar la recursividad de la entidad sobre la que se busca (Tumba)
        //Cargar toda la información relevante relacionada con los traslados de la tumba
        /*$tumba['TrasladoTumba'] = $this->TrasladoTumba->find('all', array(
         'conditions' => array(
          'TrasladoTumba.tumba_id' => $id
         ),
         'contain' => array(
          'Traslado' => array(
           'fields' => array(
            'Traslado.id', 'Traslado.fecha', 'Traslado.cementerio_origen', 'Traslado.cementerio_destino', 'Traslado.motivo'
           ),
          ),
          'Tumba' => array(
           'Columbario','Nicho','Panteon','Exterior',
           'fields' => array(
            'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
           ),
          ),
         ),
        ));*/
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('tumba'));
        
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function editar($id = null) {
        
        //Devolver las opciones de selección de tipo de tumba
        $this->set('tipo', $this->Tumba->tipo);
        
        //Asignar id
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
            throw new NotFoundException(__('La tumba especificada no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            //Comprobar el tipo de tumba
            if ($this->request->data['Tumba']['tipo'] == "Columbario") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Columbario->validate['tumba_id']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Nicho") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Nicho->validate['tumba_id']);
                unset($this->request->data['Columbario']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Panteón") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Panteon->validate['tumba_id']);
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Exterior") {
                //Truco del almendruco para guardar una entidad vacía salvo id y clave externa
                $this->request->data['Exterior']['algo'] = "";
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            
            //Cargar datos de sesión
            $this->request->data['Tumba']['poblacion'] = $this->Session->read('Tumba.poblacion');
            $this->request->data['Tumba']['id'] = $this->Session->read('Tumba.id');
            if ($this->request->data['Tumba']['tipo'] == $this->Session->read('Tumba.tipo')) {
                if (($this->request->data['Tumba']['tipo'] == "Columbario") && ($this->Session->read('Columbario.id'))) {
                    $this->request->data['Columbario']['id'] = $this->Session->read('Columbario.id');
                }
                elseif (($this->request->data['Tumba']['tipo'] == "Nicho") && ($this->Session->read('Nicho.id'))) {
                    $this->request->data['Nicho']['id'] = $this->Session->read('Nicho.id');
                }
                elseif (($this->request->data['Tumba']['tipo'] == "Panteón") && ($this->Session->read('Panteon.id'))) {
                    $this->request->data['Panteon']['id'] = $this->Session->read('Panteon.id');
                }
                elseif (($this->request->data['Tumba']['tipo'] == "Exterior") && ($this->Session->read('Exterior.id'))) {
                    $this->request->data['Exterior']['id'] = $this->Session->read('Exterior.id');
                }
            }
            
            //Guardar y comprobar éxito
            if ($this->Tumba->saveAssociated($this->request->data)) {
                $this->Session->setFlash(__('La tumba ha sido actualizada correctamente.'));
                //Borrar la tumba anterior en caso de ser de distinto tipo
                if ($this->request->data['Tumba']['tipo'] != $this->Session->read('Tumba.tipo')) {
                    if ($this->Session->read('Tumba.tipo') == "Columbario") {
                        $this->Tumba->Columbario->deleteAll(array('Columbario.tumba_id' => $id), false, false);
                    }
                    elseif ($this->Session->read('Tumba.tipo') == "Nicho") {
                        $this->Tumba->Nicho->deleteAll(array('Nicho.tumba_id' => $id), false, false);
                    }
                    elseif ($this->Session->read('Tumba.tipo') == "Panteón") {
                        $this->Tumba->Panteon->deleteAll(array('Panteon.tumba_id' => $id), false, false);
                    }
                    elseif ($this->Session->read('Tumba.tipo') == "Exterior") {
                        $this->Tumba->Exterior->deleteAll(array('Exterior.tumba_id' => $id), false, false);
                    }
                }
                //Borrar datos de sesión
                $this->Session->delete('Tumba');
                $this->Session->delete('Columbario');
                $this->Session->delete('Nicho');
                $this->Session->delete('Panteon');
                $this->Session->delete('Exterior');
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser actualizada.'));
            }
        }
        else {
            //Devolver los datos actuales de la tumba
            $this->request->data = $this->Tumba->find('first', array(
             'conditions' => array(
              'Tumba.id' => $id
             ),
             'contain' => array(
              'Columbario','Nicho','Panteon','Exterior',
             ),
            ));
            
            //Guardar los datos de sesión de la tumba
            $this->Session->write('Tumba.id', $this->request->data['Tumba']['id']);
            $this->Session->write('Tumba.tipo', $this->request->data['Tumba']['tipo']);
            $this->Session->write('Tumba.poblacion', $this->request->data['Tumba']['poblacion']);
            if ($this->request->data['Columbario']['identificador']) {
                $this->Session->write('Tumba.identificador', $this->request->data['Columbario']['identificador']);
                $this->Session->write('Columbario.id', $this->request->data['Columbario']['id']);
            }
            elseif ($this->request->data['Nicho']['identificador']) {
                $this->Session->write('Tumba.identificador', $this->request->data['Nicho']['identificador']);
                $this->Session->write('Nicho.id', $this->request->data['Nicho']['id']);
            }
            elseif ($this->request->data['Panteon']['identificador']) {
                $this->Session->write('Tumba.identificador', $this->request->data['Panteon']['identificador']);
                $this->Session->write('Panteon.id', $this->request->data['Panteon']['id']);
            }
            elseif ($this->request->data['Exterior']['identificador']) {
                $this->Session->write('Tumba.identificador', $this->request->data['Exterior']['identificador']);
                $this->Session->write('Exterior.id', $this->request->data['Exterior']['id']);
            }
        }
        
    }

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function borrar($id = null) {
        
        //Comprobar que la forma de envío sea POST
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(__('¿¡Dónde vas... Tomás!?'));
        }
        
        //Asignar id
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
            throw new NotFoundException(__('La tumba especificada no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Tumba->Columbario->deleteAll(array('Columbario.tumba_id' => $id), false, false) && $this->Tumba->Exterior->deleteAll(array('Exterior.tumba_id' => $id), false, false) && $this->Tumba->Nicho->deleteAll(array('Nicho.tumba_id' => $id), false, false) && $this->Tumba->Panteon->deleteAll(array('Panteon.tumba_id' => $id), false, false) && $this->Tumba->ArrendatarioTumba->deleteAll(array('ArrendatarioTumba.tumba_id' => $id), false, false) && $this->Tumba->delete()) {
            $this->Session->setFlash(__('La tumba ha sido eliminada correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser eliminada.'));
        //Redireccionar a index
        $this->redirect(array('action' => 'index'));
        
    }

/**
 * autocomplete method
 *
 * @return JSON array
 */
    public function autocomplete() {
        
        //Término de búsqueda con comodines
        $palabro = '%'.$this->request->query['term'].'%';
        
        //Búsqueda de coincidencias
        $resultados = $this->Tumba->find('all', array(
         'contain' => array(
          'Columbario' => array(
           /*'conditions' => array(
            'Columbario.tumba_id = Tumba.id',
           ),*/
           'fields' => array(
            'Columbario.id', 'Columbario.tumba_id', 'Columbario.identificador'
           ),
          ),
          'Nicho' => array(
           /*'conditions' => array(
            'Nicho.tumba_id = Tumba.id',
           ),*/
           'fields' => array(
            'Nicho.id', 'Nicho.tumba_id', 'Nicho.identificador'
           ),
          ),
          'Panteon' => array(
           /*'conditions' => array(
            'Panteon.tumba_id = Tumba.id',
           ),*/
           'fields' => array(
            'Panteon.id', 'Panteon.tumba_id', 'Panteon.identificador'
           ),
          ),
          'Exterior' => array(
           /*'conditions' => array(
            'Exterior.tumba_id = Tumba.id',
           ),*/
           'fields' => array(
            'Exterior.id', 'Exterior.tumba_id', 'Exterior.identificador'
           ),
          ),
         ),
         'conditions' => array(
          'OR' => array(
           'Tumba.tipo LIKE' => $palabro,
           'CONCAT(Columbario.numero_columbario," ",Columbario.fila," ",Columbario.patio) LIKE' => $palabro,
           'CONCAT(Nicho.numero_nicho," ",Nicho.fila," ",Nicho.patio) LIKE' => $palabro,
           'CONCAT(Panteon.familia," ",Panteon.numero_panteon," ",Panteon.patio) LIKE' => $palabro,
          ),
         ),
         'limit' => 20,
        ));
        
        //Procesamiento y codificación en JSON
        $items = array();
        
        if (empty($resultados)) {
         array_push($items, array("label"=>"No hay coincidencias", "value"=>""));
        }
        else {
         foreach($resultados as $resultado) {
          $identificador = "";
          if ($resultado['Tumba']['tipo'] == "Columbario") {
           $identificador = $resultado['Columbario']['identificador'];
          }
          elseif ($resultado['Tumba']['tipo'] == "Nicho") {
           $identificador = $resultado['Nicho']['identificador'];
          }
          elseif ($resultado['Tumba']['tipo'] == "Panteón") {
           $identificador = $resultado['Panteon']['identificador'];
          }
          elseif ($resultado['Tumba']['tipo'] == "Exterior") {
           $identificador = $resultado['Exterior']['identificador'];
          }
          array_push($items, array("label" => $resultado['Tumba']['tipo'] . " - " . $identificador, "value" => $resultado['Tumba']['id']));
         }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }
public function prueba(){}
}
