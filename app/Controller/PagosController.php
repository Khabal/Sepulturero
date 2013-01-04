<?php
App::uses('AppController', 'Controller');
/**
 * Pagos Controller
 *
 * @property Pago $Pago
 */
class PagosController extends AppController {

public $theme= '960-fluid';

/**
 * Components
 *
 * @var array
 */
	public $components = array('Session','Search.Prg','RequestHandler');

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
            'conditions' => $this->Pago->parseCriteria($this->params->query),
            'contain' => array(
             'Tasa' => array(
              'fields' => array(
               'Tasa.id', 'Tasa.tipo'
              ),
             ),
            ),
        );
        
        //Devolver paginación
        $this->set('pagos', $this->paginate());
        
    }

/**
 * add method
 *
 * @return void
 */
    public function nuevo() {
        
        //Devolver las opciones de selección de monedas
        $this->set('monedas', $this->Pago->moneda);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            //Crear nuevo pago con id único
            $this->Pago->create();
            //Guardar y comprobar éxito
            if ($this->Pago->save($this->request->data)) {
                $this->Session->setFlash(__('El pago ha sido guardado correctamente.'));
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
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El pago no ha podido ser guardado.'));
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
        $this->Pago->id = $id;
        
        //Comprobar si existe el pago
        if (!$this->Pago->exists()) {
         throw new NotFoundException(__('El pago especificado no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con el pago
        $pago = $this->Pago->find('first', array(
         'conditions' => array(
          'Pago.id' => $id
         ),
         'contain' => array(
          'Tasa' => array(
           'fields' => array(
            'Tasa.id', 'Tasa.tipo', 'Tasa.cantidad', 'Tasa.moneda'
           ),
          ),
          'Documento' => array(
           'fields' => array(
            'Documento.id', 'Documento.traslado_id', 'Documento.nombre', 'Documento.tipo'
           ),
          ),
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('pago'));
        
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
        $this->set('monedas', $this->Pago->moneda);
        
        //Asignar id
        $this->Pago->id = $id;
        
        //Comprobar si existe el pago
        if (!$this->Pago->exists()) {
            throw new NotFoundException(__('El pago especificado no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            //Guardar y comprobar éxito
            if ($this->Pago->save($this->request->data)) {
                $this->Session->setFlash(__('El pago ha sido actualizado correctamente.'));
                //Borrar datos de sesión
                $this->Session->delete('Pago');
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El pago no ha podido ser actualizado.'));
            }
        }
        else {
            //Devolver los datos actuales del pago
            $this->request->data = $this->Pago->find('first', array(
             'conditions' => array(
              'Pago.id' => $id
             ),
             'contain' => array(
              'Tasa' => array(
               'fields' => array(
                'Tasa.id', 'Tasa.tipo', 'Tasa.cantidad', 'Tasa.moneda'
               ),
              ),
              'Documento' => array(
               'fields' => array(
                'Documento.id', 'Documento.traslado_id', 'Documento.nombre', 'Documento.tipo'
               ),
              ),
             ),
            ));
            
            //Guardar los datos de sesión del pago
            $this->Session->write('Pago.id', $this->request->data['Pago']['id']);
            $this->Session->write('Pago.fecha', date('d/m/Y', strtotime($this->request->data['Pago']['fecha'])));
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
        $this->Pago->id = $id;
        
        //Comprobar si existe el pago
        if (!$this->Pago->exists()) {
            throw new NotFoundException(__('El pago especificado no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Pago->Documento->deleteAll(array('Documento.pago_id' => $id), false, false) && $this->Pago->delete()) {
            $this->Session->setFlash(__('El pago ha sido eliminado correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. El pago no ha podido ser eliminado.'));
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
        $resultados = $this->Pago->find('all', array(
         'conditions' => array(
          'OR' =>  array(
           'Pago.fecha LIKE' => $palabro,
           'Pago.cantidad LIKE' => $palabro,
           'Pago.motivo LIKE' => $palabro,
           'CONCAT(Pago.fecha," ",Pago.motivo) LIKE' => $palabro,
           'CONCAT(Pago.fecha," ",Pago.cantidad," ",Pago.motivo) LIKE' => $palabro,
          ),
         ),
         'fields' => array(
          'Pago.id', 'Pago.fecha', 'Pago.motivo'
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
          array_push($items, array("label" => $resultado['Pago']['fecha'] . $resultado['Pago']['motivo'], "value" => $resultado['Pago']['id']));
         }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }

}
