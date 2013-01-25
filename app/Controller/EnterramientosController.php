<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Enterramientos Controller
 *
 * @property Enterramiento $Enterramiento
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class EnterramientosController extends AppController {
    
    /**
     * ----------------------
     * Controller Attributes
     * ----------------------
     */
    
    /**
     * Controller automatically render the layout
     *
     * @var boolean
     */
    public $autoLayout = true;
    
    /**
     * Controller automatically render the view
     *
     * @var boolean
     */
    public $autoRender = true;
    
    /**
     * File extension for view templates
     *
     * @var string
     */
    public $ext = '.ctp';
    
    /**
     * Name of the layout file
     *
     * @var string
     */
    public $layout = 'default';
    
    /**
     * Model class name
     *
     * @var string
     */
    public $modelClass = 'Enterramiento';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Enterramientos';
    
    /**
     * Theme name
     *
     * @var string
     */
    public $theme= '960-fluid';
    
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler', 'Session', 'Search.Prg');
    
    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array('Form', 'Html', 'Js' => array('Jquery'), 'Paginator', 'GuarritasEnergeticas');
    
    /**
     * Methods
     *
     * @var array
     */
    public $methods = array('index', 'nuevo', 'ver', 'buscar', 'editar', 'imprimir', 'pdf');
    
    /**
     * Uses
     *
     * @var array
     */
    public $uses = array('Enterramiento', 'EnterramientoTasa', 'Difunto', 'Licencia', 'Tasa', 'Tumba', 'Sanitize');
    
    /**
     * ---------------------------
     * Extra Controller Attributes
     * ---------------------------
     */
    
    /**
     * PDF output file config
     *
     * @var array
     */
    public $pdfConfig = array(
        'engine' => 'CakePdf.WkHtmlToPdf', //Engine to be used (required)
        'pageSize' => 'A4', //Change the default size, defaults to A4
        'orientation' => 'portrait', //Change the default orientation (portrait or landscape), defaults to portrait
        'margin' => array( //Array or margins with the keys: bottom, left, right, top and their values
            'bottom' => 5,
            'left' => 5,
            'right' => 5,
            'top' => 5,
        ),
        'title' => '', //Title of the document
        'encoding' => 'UTF-8', //Change the encoding, defaults to UTF-8
        'binary' => '/usr/bin/wkhtmltopdf', //Path to binary (WkHtmlToPdfEngine only), defaults to /usr/bin/wkhtmltopdf
        'download' => false, //Set to true to force a download, only when using PdfView
        'filename' => '', //Filename for the document when using forced download
    );
    
    /**
     * Search Plugin search fields
     *
     * @var mixed (boolean/array)
     */
    public $presetVars = true; //Using the model configuration
    
    /**
     * Opciones de guardado específicas de este controlador
     *
     * @var array
     */
    public $opciones_guardado = array(
        'atomic' => true,
        'deep' => false,
        'fieldList' => array(
            'Enterramiento' => array('id', 'difunto_id', 'licencia_id', 'tumba_id', 'fecha', 'observaciones'),
            'EnterramientoTasa' => array('id', 'enterramiento_id', 'tasa_id'),
            'Difunto' => array('tumba_id'),
            'Tumba' => array('poblacion'),
        ),
        'validate' => 'first',
    );
    
    /**
     * ----------------------
     * Controller Actions
     * ----------------------
     */
    
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        
        //Iniciar proceso de paginación
        $this->Prg->commonProcess();
        
        //Establecer parámetros de paginación
        $this->paginate = array( 
         'conditions' => $this->Enterramiento->parseCriteria($this->params->query),
         'contain' => array(
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
          'Licencia' => array(
           'fields' => array(
            'Licencia.id', 'Licencia.identificador'
           ),
          ),
          'Tumba' => array(
           'Columbario' => array(
            'fields' => array(
             'Columbario.id', 'Columbario.tumba_id', 'Columbario.identificador'
            ),
           ),
           'Nicho' => array(
            'fields' => array(
             'Nicho.id', 'Nicho.tumba_id', 'Nicho.identificador'
            ),
           ),
           'Panteon' => array(
            'fields' => array(
             'Panteon.id', 'Panteon.tumba_id', 'Panteon.identificador'
            ),
           ),
           'Exterior' => array(
            'fields' => array(
             'Exterior.id', 'Exterior.tumba_id', 'Exterior.identificador'
            ),
           ),
           'fields' => array(
            'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
           ),
          ),
         ),
        );
        
        //Devolver paginación
        $this->set('enterramientos', $this->paginate());
        
    }
    
    /**
     * add method
     *
     * @return void
     */
    public function nuevo() {
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Crear nuevo enterramiento con id único
            $this->Enterramiento->create();
            
            //Comprobar si la tumba de enterramiento va a ser la actual
            if ($this->request->data['Enterramiento']['tumba_final']) {
                //Comprobar si el difunto ya tenía asociada una tumba
                if ($this->Enterramiento->Difunto->field('tumba_id', array('Difunto.id' => $this->request->data['Enterramiento']['difunto_id']))) {
                    $this->Session->setFlash(__('El difunto ya tiene asociada una tumba.'));
                    $this->render();
                }
                else {
                    $this->request->data['Difunto']['id'] = $this->request->data['Enterramiento']['difunto_id'];
                    $this->request->data['Difunto']['tumba_id'] = $this->request->data['Enterramiento']['tumba_id'];
                    $this->request->data['Tumba']['id'] = $this->request->data['Enterramiento']['tumba_id'];
                    $this->request->data['Tumba']['población'] = $this->Enterramiento->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['Enterramiento']['tumba_id'])) + 1;
                }
            }
            
            //Guardar y comprobar éxito
            if ($this->Enterramiento->saveAssociated($this->request->data, $this->opciones_guardado)) {
                $this->Session->setFlash(__('El enterramiento ha sido guardado correctamente.'));
                //Redireccionar según corresponda
                if ($accion == 'guardar_y_nuevo') {
                    $this->redirect(array('action' => 'nuevo'));
                }
                else {
                    $this->redirect(array('action' => 'index'));
                }
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El enterramiento no ha podido ser guardado.'));
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
        $this->Enterramiento->id = $id;
        
        //Comprobar si existe el enterramiento
        if (!$this->Enterramiento->exists()) {
         throw new NotFoundException(__('El enterramiento especificado no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con el enterramiento
        $enterramiento = $this->Enterramiento->find('first', array(
         'conditions' => array(
          'Enterramiento.id' => $id
         ),
         'contain' => array(
          'Licencia' => array(
           'fields' => array(
            'Licencia.id', 'Licencia.numero_licencia', 'Licencia.fecha_aprobacion', 'Licencia.anos_concesion', 'Licencia.identificador'
           ),
          ),
          'Tumba' => array(
           'Columbario','Nicho','Panteon','Exterior',
           'fields' => array(
            'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
           ),
          ),
          'Difunto' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
            ),
           ),
          ),
          'EnterramientoTasa' => array(
           'Tasa' => array(
            'fields' => array(
             'Tasa.id', 'Tasa.tipo', 'Tasa.cantidad', 'Tasa.moneda'
            ),
           ),
          ),
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('enterramiento'));
        
    }
    
    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function editar($id = null) {
        
        //Asignar id
        $this->Enterramiento->id = $id;
        
        //Comprobar si existe el enterramiento
        if (!$this->Enterramiento->exists()) {
            throw new NotFoundException(__('El enterramiento especificado no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Guardar y comprobar éxito
            if ($this->Enterramiento->saveAssociated($this->request->data, $this->opciones_guardado)) {
                $this->Session->setFlash(__('El enterramiento ha sido actualizado correctamente.'));
                //Borrar datos de sesión
                $this->Session->delete('Enterramiento');
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El enterramiento no ha podido ser actualizado.'));
            }
        }
        else {
            //Devolver los datos actuales del enterramiento
            $this->request->data = $this->Enterramiento->find('first', array(
             'conditions' => array(
              'Enterramiento.id' => $id
             ),
             'contain' => array(
              'Licencia' => array(
               'fields' => array(
                'Licencia.id', 'Licencia.identificador'
               ),
              ),
              'Tumba' => array(
               'Columbario','Nicho','Panteon','Exterior',
               'fields' => array(
                'Tumba.id', 'Tumba.tipo'
               ),
              ),
              'Difunto' => array(
               'Persona' => array(
                'fields' => array(
                 'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
                ),
               ),
               'fields' => array(
                'Difunto.id', 'Difunto.persona_id', 'Difunto.tumba_id'
               ),
              ),
              'EnterramientoTasa' => array(
               'Tasa' => array(
                'fields' => array(
                 'Tasa.id', 'Tasa.tipo'
                ),
               ),
              ),
             ),
            ));
            
            //Devolver nombres bonitos para entidades relacionadas
            if ($this->request->data['Enterramiento']['fecha']) {
                $this->request->data['Enterramiento']['fecha_bonita'] = date('d/m/Y', strtotime($this->request->data['Enterramiento']['fecha']));
            }
            
            if ($this->request->data['Enterramiento']['difunto_id']) {
                $this->request->data['Enterramiento']['difunto_bonito'] = $this->request->data['Difunto']['Persona']['nombre_completo'] . " - " . $this->request->data['Difunto']['Persona']['dni'];
            }
            
            if ($this->request->data['Enterramiento']['licencia_id']) {
                $this->request->data['Enterramiento']['licencia_bonita'] = $this->request->data['Licencia']['identificador'];
            }
            
            $this->request->data['Enterramiento']['tumba_bonita'] = $this->request->data['Tumba']['tipo'] . " - ";
            if ($this->request->data['Tumba']['Columbario']) {
                $this->request->data['Enterramiento']['tumba_bonita'] .= $this->request->data['Tumba']['Columbario']['identificador'];
            }
            elseif ($this->request->data['Tumba']['Nicho']) {
                $this->request->data['Enterramiento']['tumba_bonita'] .= $this->request->data['Tumba']['Nicho']['identificador'];
            }
            elseif ($this->request->data['Tumba']['Panteon']) {
                $this->request->data['Enterramiento']['tumba_bonita'] .= $this->request->data['Tumba']['Panteon']['identificador'];
            }
            elseif ($this->request->data['Tumba']['Exterior']) {
                $this->request->data['Enterramiento']['tumba_bonita'] .= $this->request->data['Tumba']['Exterior']['identificador'];
            }
            
            //Guardar los datos de sesión del enterramiento
            $this->Session->write('Enterramiento.id', $this->request->data['Enterramiento']['id']);
            $this->Session->write('Enterramiento.identificador', date('d/m/Y', strtotime($this->request->data['Enterramiento']['fecha'])) . " " . $this->request->data['Difunto']['Persona']['nombre_completo']);
            
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
        $this->Enterramiento->id = $id;
        
        //Comprobar si existe el enterramiento
        if (!$this->Enterramiento->exists()) {
            throw new NotFoundException(__('El enterramiento especificado no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Enterramiento->EnterramientoTasa->deleteAll(array('EnterramientoTasa.enterramiento_id' => $id), false, false) && $this->Enterramiento->delete()) {
            $this->Session->setFlash(__('El enterramiento ha sido eliminado correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. El enterramiento no ha podido ser eliminado.'));
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
        $resultados = $this->Enterramiento->find('all', array(
         'joins' => array(
          array(
           'table' => 'difuntos',
           'alias' => 'Difunto',
           'type' => 'LEFT',
           'foreignKey' => FALSE,
           'conditions' => array(
            'Difunto.id = Enterramiento.difunto_id',
           ),
          ),
          array(
           'table' => 'personas',
           'alias' => 'Persona',
           'type' => 'LEFT',
           'foreignKey' => FALSE,
           'conditions' => array(
            'Persona.id = Difunto.persona_id'
           ),
          ),
         ),
         'conditions' => array(
          'OR' => array(
           'Persona.dni LIKE' => $palabro,
           'Persona.nombre LIKE' => $palabro,
           'Persona.apellido1 LIKE' => $palabro,
           'Persona.apellido2 LIKE' => $palabro,
           'CONCAT(Persona.nombre," ",Persona.apellido1) LIKE' => $palabro,
           'CONCAT(Persona.nombre," ",Persona.apellido1," ",Persona.apellido2) LIKE' => $palabro,
           'DATE_FORMAT(Enterramiento.fecha, "%d/%m/%Y") LIKE' => $palabro,
          ),
         ),
         'contain' => array(
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
         ),
         'fields' => array(
          'Enterramiento.id', 'Enterramiento.difunto_id', 'Enterramiento.fecha'
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
                $fecha = date('d/m/Y', strtotime($resultado['Enterramiento']['fecha']));
                $difunto = $resultado['Difunto']['Persona']['nombre_completo'] . " - " . $resultado['Difunto']['Persona']['dni'];
                array_push($items, array("label" => $fecha . " " . $difunto, "value" => $resultado['Enterramiento']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
        
    }

}