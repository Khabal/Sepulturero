<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Funerarias Controller
 *
 * @property Funeraria $Funeraria
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prgg
 */
class FunerariasController extends AppController {
    
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
    public $modelClass = 'Funeraria';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Funerarias';
    
    /**
     * Theme name
     *
     * @var string
     */
    public $theme = '960-fluid';
    
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
    public $uses = array('Funeraria', 'Sanitize');
    
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
            'Funeraria' => array('id', 'nombre', 'direccion', 'telefono', 'fax', 'correo_electronico', 'pagina_web', 'observaciones'),
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
            'conditions' => $this->Funeraria->parseCriteria($this->params->query),
            'contain' => array(
            ),
            'fields' => array(
             'Funeraria.id', 'Funeraria.nombre', 'Funeraria.direccion', 'Funeraria.telefono', 'Funeraria.fax', 'Funeraria.correo_electronico', 'Funeraria.pagina_web'
            ),
        );
        
        //Devolver paginación
        $this->set('funerarias', $this->paginate());
        
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
            
            //Crear nueva funeraria con id único
            $this->Funeraria->create();
            
            //Guardar y comprobar éxito
            if ($this->Funeraria->save($this->request->data)) {
                $this->Session->setFlash(__('La funeraria ha sido guardada correctamente.'));
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
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La funeraria no ha podido ser guardada.'));
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
        $this->Funeraria->id = $id;
        
        //Comprobar si existe la funeraria
        if (!$this->Funeraria->exists()) {
            throw new NotFoundException(__('La funeraria especificada no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con la funeraria
        $funeraria = $this->Funeraria->find('first', array(
         'conditions' => array(
          'Funeraria.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('funeraria'));
        
    }
    
    /**
     * find method
     *
     * @return void
     */
    public function buscar() {
        
        //Redireccionar
        $this->redirect(array('action' => 'index'));
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
        $this->Funeraria->id = $id;
        $this->request->data['Funeraria']['id'] = $id;
        
        //Comprobar si existe la funeraria
        if (!$this->Funeraria->exists()) {
            throw new NotFoundException(__('La funeraria especificada no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Guardar y comprobar éxito
            if ($this->Funeraria->save($this->request->data)) {
                $this->Session->setFlash(__('La funeraria ha sido actualizada correctamente.'));
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La funeraria no ha podido ser actualizada.'));
            }
        }
        else {
            //Devolver los datos actuales de la funeraria
            $this->request->data = $this->Funeraria->find('first', array(
             'conditions' => array(
              'Funeraria.id' => $id
             ),
             'contain' => array(
             ),
            ));
        }
        
    }
    
    /**
     * print method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function imprimir($id = null) {
        
        //Asignar id
        $this->Arrendatario->id = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
            throw new NotFoundException(__('El arrendatario especificado no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con el arrendatario
        $arrendatario = $this->Arrendatario->find('first', array(
         'conditions' => array(
          'Arrendatario.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.observaciones', 'Persona.nombre_completo'
           ),
          ),
          'ArrendatarioFuneraria' => array(
           'Funeraria' => array(
            'fields' => array(
             'Funeraria.id', 'Funeraria.nombre', 'Funeraria.direccion', 'Funeraria.telefono', 'Funeraria.fax', 'Funeraria.correo_electronico', 'Funeraria.pagina_web'
            ),
           ),
          ),
          'ArrendatarioTumba' => array(
           'Tumba' => array(
            'Columbario','Nicho','Panteon','Exterior',
            'fields' => array(
             'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
            ),
           ),
          ),
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $arrendatario['Persona']['nombre_completo'] . " - " . $arrendatario['Persona']['dni'];
        $this->pdfConfig['filename'] = "Arrendatario_" . $arrendatario['Persona']['dni'] . ".pdf";
        
        //Redireccionar para la generación
        
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendatario'));
        
    }
    
    /**
     * pdf method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function pdf($id = null) {
        
        //Asignar id
        $this->Arrendatario->id = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
            throw new NotFoundException(__('El arrendatario especificado no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con el arrendatario
        $arrendatario = $this->Arrendatario->find('first', array(
         'conditions' => array(
          'Arrendatario.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.observaciones', 'Persona.nombre_completo'
           ),
          ),
          'ArrendatarioFuneraria' => array(
           'Funeraria' => array(
            'fields' => array(
             'Funeraria.id', 'Funeraria.nombre', 'Funeraria.direccion', 'Funeraria.telefono', 'Funeraria.fax', 'Funeraria.correo_electronico', 'Funeraria.pagina_web'
            ),
           ),
          ),
          'ArrendatarioTumba' => array(
           'Tumba' => array(
            'Columbario','Nicho','Panteon','Exterior',
            'fields' => array(
             'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
            ),
           ),
          ),
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $arrendatario['Persona']['nombre_completo'] . " - " . $arrendatario['Persona']['dni'];
        $this->pdfConfig['filename'] = "Arrendatario_" . $arrendatario['Persona']['dni'] . ".pdf";
        
        //Redireccionar para la generación
        
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendatario'));
        
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
        $this->Funeraria->id = $id;
        
        //Comprobar si existe la funeraria
        if (!$this->Funeraria->exists()) {
            throw new NotFoundException(__('La funeraria especificada no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Funeraria->ArrendatarioFuneraria->deleteAll(array('ArrendatarioFuneraria.funeraria_id' => $id), false, false) && $this->Funeraria->delete()) {
            $this->Session->setFlash(__('La funeraria ha sido eliminada correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. La funeraria no ha podido ser eliminada.'));
        //Redireccionar a index
        $this->redirect(array('action' => 'index'));
        
    }
    
    /**
     * ---------------------------
     * Extra Controller Actions
     * ---------------------------
     */
    
    /**
     * autocomplete method
     *
     * @return JSON array
     */
    public function autocomplete() {
        
        //Término de búsqueda con comodines
        $palabro = '%'.$this->request->query['term'].'%';
        
        //Búsqueda de coincidencias
        $resultados = $this->Funeraria->find('all', array(
         'conditions' => array(
          'Funeraria.nombre LIKE' => $palabro,
         ),
         'fields' => array(
          'Funeraria.id', 'Funeraria.nombre'
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
                array_push($items, array("label" => $resultado['Funeraria']['nombre'], "value" => $resultado['Funeraria']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
        
    }

}
