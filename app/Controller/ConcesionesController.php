<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Concesiones Controller
 *
 * @property Concesion $Concesion
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class ConcesionesController extends AppController {
    
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
    public $modelClass = 'Concesion';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Concesiones';
    
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
    public $uses = array('Concesion', 'Arrendamiento', 'Sanitize');
    
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
    //public $presetVars = true; //Using the model configuration
    public $presetVars = array( //Overriding and extending the model defaults
        'clave'=> array(
            'encode' => true,
	    'model' => 'Concesion',
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
            'Concesion' => array('id', 'tipo', 'anos_concesion', 'observaciones'),
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
         'conditions' => $this->Concesion->parseCriteria($this->params->query),
         'contain' => array(
         ),
        );
        
        //Devolver paginación
        $this->set('concesiones', $this->paginate());
        
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
            
            //Crear nueva concesión con id único
            $this->Concesion->create();
            
            //Validar los datos introducidos
            if ($this->Concesion->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Guardar y comprobar éxito
                if ($this->Concesion->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('La concesión ha sido guardada correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
                        $this->redirect(array('action' => 'nuevo'));
                    }
                    else {
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. La concesión no ha podido ser guardada.'));
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
        $this->Concesion->id = $id;
        
        //Comprobar si existe la concesión
        if (!$this->Concesion->exists()) {
             $this->Session->setFlash(__('La concesión especificada no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la concesión
        $concesion = $this->Concesion->find('first', array(
         'conditions' => array(
          'Concesion.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('concesion'));
        
    }
    
    /**
     * find method
     *
     * @return void
     */
    public function buscar() {
        
        //Redireccionar
        $this->Session->setFlash(__('Escriba el término a buscar en el cuadro búsqueda en el registro.'));
        $this->redirect(array('action' => 'index'));
        
    }
    
    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function editar($id = null) {
        
        //Asignar id
        $this->Concesion->id = $id;
        
        //Comprobar si existe la concesión
        if (!$this->Concesion->exists()) {
            $this->Session->setFlash(__('La concesión especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Concesion']['id'] = $id;
            
            //Validar los datos introducidos
            if ($this->Concesion->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Guardar y comprobar éxito
                if ($this->Concesion->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('La concesión ha sido actualizada correctamente.'));
                    //Borrar datos de sesión
                    $this->Session->delete('Concesion');
                    //Redireccionar a index
                    $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. La concesión no ha podido ser actualizada.'));
                }
            }
            else {
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
            }
        }
        else {
            //Devolver los datos actuales de la concesión
            $this->request->data = $this->Concesion->find('first', array(
             'conditions' => array(
              'Concesion.id' => $id
             ),
             'contain' => array(
             ),
            ));
            
            //Guardar los datos de sesión de la concesión
            $this->Session->write('Concesion.id', $this->request->data['Concesion']['id']);
            $this->Session->write('Concesion.tipo', $this->request->data['Concesion']['tipo']);
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
        $this->Concesion->id = $id;
        
        //Comprobar si existe la concesión
        if (!$this->Concesion->exists()) {
            $this->Session->setFlash(__('La concesión especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la concesión
        $concesion = $this->Concesion->find('first', array(
         'conditions' => array(
          'Concesion.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $concesion['Concesion']['tipo'];
        $this->pdfConfig['filename'] = "TipoConcesión_" . $concesion['Concesion']['anos_concesion'] . "años" . ".pdf";
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('concesion'));
        
        //Redireccionar para la generación
        
        
    }
    
    /**
     * export pdf method
     *
     * @param string $id
     * @return void
     */
    public function exportar_pdf($id = null) {
        
        //Asignar id
        $this->Concesion->id = $id;
        
        //Comprobar si existe la concesión
        if (!$this->Concesion->exists()) {
            $this->Session->setFlash(__('La concesión especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la concesión
        $concesion = $this->Concesion->find('first', array(
         'conditions' => array(
          'Concesion.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $concesion['Concesion']['tipo'];
        $this->pdfConfig['filename'] = "TipoConcesión_" . $concesion['Concesion']['anos_concesion'] . "años" . ".pdf";
        $this->pdfConfig['download'] = true;
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('concesion'));
        
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
        $this->Concesion->id = $id;
        
        //Comprobar si existe la concesión
        if (!$this->Concesion->exists()) {
            throw new NotFoundException(__('La concesión especificada no existe.'));
        }
        
        //Buscar si la concesión está en uso en algún arrendamiento
        $arrendamiento = $this->Concesion->Arrendamiento->find('first', array(
         'conditions' => array(
          'Arrendamiento.concesion_id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si la concesión está en uso en arrendamientos
        if (!empty($arrendamiento)) {
            $this->Session->setFlash(__('La concesión especificada está asociada a un arrendamiento.'));
        }
        else {
            //Borrar y comprobar éxito
            if ($this->Concesion->delete()) {
                $this->Session->setFlash(__('La concesión ha sido eliminado correctamente.'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La concesión no ha podido ser eliminado.'));
            }
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
        $resultados = $this->Concesion->find('all', array(
         'contain' => array(
         ),
         'conditions' => array(
          'OR' =>  array(
           'Concesion.tipo LIKE' => $palabro,
           'Concesion.anos_concesion LIKE' => $palabro,
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
                array_push($items, array("label" => $resultado['Concesion']['tipo'], "value" => $resultado['Concesion']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }

}
