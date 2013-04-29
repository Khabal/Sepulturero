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
    public $methods = array('index', 'nuevo', 'ver', 'buscar', 'editar', 'imprimir', 'exportar_pdf');
    
    /**
     * Uses
     *
     * @var array
     */
    public $uses = array('Funeraria', 'ArrendatarioFuneraria', 'Pago', 'Sanitize');
    
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
    public $presetVars = array( //Overriding and extending the model defaults
        'clave'=> array(
            'encode' => true,
            'model' => 'Funeraria',
            'type' => 'method',
        ),
    );
    
    /**
     * Opciones de guardado específicas de este controlador
     *
     * @var array
     */
    public $opciones_guardado = array(
        'atomic' => true,
        'deep' => false,
        'fieldList' => array(
            'Funeraria' => array('id', 'cif', 'nombre', 'direccion', 'telefono_fijo', 'telefono_movil', 'fax', 'correo_electronico', 'pagina_web', 'observaciones'),
        ),
        'validate' => false,
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
         'paramType' => 'querystring',
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
            
            //Validar los datos introducidos
            if ($this->Funeraria->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Guardar y comprobar éxito
                if ($this->Funeraria->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('La funeraria ha sido guardada correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
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
            else {
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
            }
        }
        
    }
    
    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function ver($id = null) {
        
        //Asignar id
        $this->Funeraria->id = $id;
        
        //Comprobar si existe la funeraria
        if (!$this->Funeraria->exists()) {
             $this->Session->setFlash(__('La funeraria especificada no existe.'));
             $this->redirect(array('action' => 'index'));
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
        
        //Eliminar reglas de validación
        unset($this->Funeraria->validate);
        
    }
    
    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function editar($id = null) {
        
        //Asignar id
        $this->Funeraria->id = $id;
        
        //Comprobar si existe la funeraria
        if (!$this->Funeraria->exists()) {
             $this->Session->setFlash(__('La funeraria especificada no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Funeraria']['id'] = $id;
            
            //Validar los datos introducidos
            if ($this->Funeraria->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Guardar y comprobar éxito
                if ($this->Funeraria->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('La funeraria ha sido actualizada correctamente.'));
                    //Borrar datos de sesión
                    $this->Session->delete('Funeraria');
                    //Redireccionar a index
                    $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. La funeraria no ha podido ser actualizada.'));
                }
            }
            else {
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
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
            
           //Guardar los datos de sesión de la funeraria
            $this->Session->write('Funeraria.id', $this->request->data['Funeraria']['id']);
            $this->Session->write('Funeraria.nombre', $this->request->data['Funeraria']['nombre']);
        }
        
    }
    
    /**
     * print method
     *
     * @param string $id
     * @return void
     */
    public function imprimir($id = null) {
        
        //Asignar id
        $this->Funeraria->id = $id;
        
        //Comprobar si existe la funeraria
        if (!$this->Funeraria->exists()) {
            $this->Session->setFlash(__('La funeraria especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la funeraria
        $funeraria = $this->Funeraria->find('first', array(
         'conditions' => array(
          'Funeraria.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $funeraria['Funeraria']['nombre'] . " - " . $funeraria['Funeraria']['cif'];
        $this->pdfConfig['filename'] = "Funeraria_" . $funeraria['Funeraria']['cif'] . ".pdf";
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('funeraria'));
        
        //Redireccionar para la generación
        
        
    }
    
    /**
     * exportar_pdf method
     *
     * @param string $id
     * @return void
     */
    public function exportar_pdf($id = null) {
        
        //Asignar id
        $this->Funeraria->id = $id;
        
        //Comprobar si existe la funeraria
        if (!$this->Funeraria->exists()) {
            $this->Session->setFlash(__('La funeraria especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la funeraria
        $funeraria = $this->Funeraria->find('first', array(
         'conditions' => array(
          'Funeraria.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $funeraria['Funeraria']['nombre'] . " - " . $funeraria['Funeraria']['cif'];
        $this->pdfConfig['filename'] = "Funeraria_" . $funeraria['Funeraria']['cif'] . ".pdf";
        $this->pdfConfig['download'] = true;
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('funeraria'));
        
        //Redireccionar para la generación
        
        
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
        
        //Comprobar si la funeraria está asociada con algún pago y actualizar clave externa
        $pago = $this->Funeraria->Pago->field('funeraria_id', array('Pago.funeraria_id' => $id));
        if (!empty($pago)) {
            $this->Funeraria->Pago->query("UPDATE pagos SET funeraria_id = null WHERE funeraria_id = '" . $id . "'");
        }
        
        //Borrar y comprobar éxito
        if ($this->Funeraria->delete()) {
            $this->Session->setFlash(__('La funeraria ha sido eliminada correctamente.'));
        }
        else {
            $this->Session->setFlash(__('Ha ocurrido un error mágico. La funeraria no ha podido ser eliminada.'));
        }
        
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
          'Funeraria.id', 'Funeraria.cif', 'Funeraria.nombre'
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
                array_push($items, array("label" => $resultado['Funeraria']['nombre'] . " - " . $resultado['Funeraria']['cif'], "value" => $resultado['Funeraria']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }

}
