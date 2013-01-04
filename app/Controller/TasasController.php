<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
/**
 * Tasas Controller
 *
 * @property Tasa $Tasa
 */
class TasasController extends AppController {
public $theme= '960-fluid';

/**
 * Components
 *
 * @var array
 */
	public $components = array('Session','Search.Prg','RequestHandler');

public $uses = array('Tasa', 'Sanitize');

	public $presetVars = true; //Using the model configuration
/**
 * index method
 *
 * @return void
 */
    public function index() {
        
        //Establecer parámetros de paginación
        $this->Prg->commonProcess();
        $this->paginate = array( 
            'conditions' => $this->Tasa->parseCriteria($this->params->query),
            'contain' => array(
            ),
        );
        
        //Devolver paginación
        $this->set('tasas', $this->paginate());
        
    }

/**
 * add method
 *
 * @return void
 */
    public function nuevo() {
        
        //Devolver las opciones de selección de monedas
        $this->set('monedas', $this->Tasa->moneda);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            //Crear nueva tasa con id único
            $this->Tasa->create();
            //Guardar y comprobar éxito
            if ($this->Tasa->save($this->request->data)) {
                $this->Session->setFlash(__('La tasa ha sido guardada correctamente.'));
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
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La tasa no ha podido ser guardada.'));
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
        $this->Tasa->id = $id;
        
        //Comprobar si existe la tasa
        if (!$this->Tasa->exists()) {
         throw new NotFoundException(__('La tasa especificada no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con la tasa
        $tasa = $this->Tasa->find('first', array(
         'conditions' => array(
          'Tasa.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('tasa'));
        
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function editar($id = null) {
        
        //Devolver las opciones de selección de monedas
        $this->set('monedas', $this->Tasa->moneda);
        
        //Asignar id
        $this->Tasa->id = $id;
        
        //Comprobar si existe la tasa
        if (!$this->Tasa->exists()) {
            throw new NotFoundException(__('La tasa especificada no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            //Guardar y comprobar éxito
            if ($this->Tasa->save($this->request->data)) {
                $this->Session->setFlash(__('La tasa ha sido actualizada correctamente.'));
                //Borrar datos de sesión
                $this->Session->delete('Tasa');
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La tasa no ha podido ser actualizada.'));
            }
        }
        else {
            //Devolver los datos actuales de la tasa
            $this->request->data = $this->Tasa->find('first', array(
             'conditions' => array(
              'Tasa.id' => $id
             ),
             'contain' => array(
             ),
            ));
            
            //Guardar los datos de sesión de la tasa
            $this->Session->write('Tasa.id', $this->request->data['Tasa']['id']);
            $this->Session->write('Tasa.nombre', $this->request->data['Tasa']['tipo']);
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
        $this->Tasa->id = $id;
        
        //Comprobar si existe la tasa
        if (!$this->Tasa->exists()) {
            throw new NotFoundException(__('La tasa especificada no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Tasa->delete()) {
            $this->Session->setFlash(__('La tasa ha sido eliminada correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. La tasa no ha podido ser eliminada.'));
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
        $resultados = $this->Tasa->find('all', array(
         'conditions' => array(
          'Tasa.tipo LIKE' => $palabro,
         ),
         'fields' => array(
          'Tasa.id', 'Tasa.tipo'
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
          array_push($items, array("label" => $resultado['Tasa']['tipo'], "value" => $resultado['Tasa']['id']));
         }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }

}
