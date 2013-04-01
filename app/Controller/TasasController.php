<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Tasas Controller
 *
 * @property Tasa $Tasa
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class TasasController extends AppController {
    
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
    public $modelClass = 'Tasa';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Tasas';
    
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
    public $uses = array('Tasa', 'PagoTasa', 'Sanitize');
    
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
            'Tasa' => array('id', 'concepto', 'cantidad', 'moneda', 'inicio_validez', 'fin_validez', 'observaciones'),
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
         'conditions' => $this->Tasa->parseCriteria($this->params->query),
         'paramType' => 'querystring',
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
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Crear nueva tasa con id único
            $this->Tasa->create();
            
            //Validar los datos introducidos
            if ($this->Tasa->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Convertir la cantidad al formato numérico pirata
                $this->request->data['Tasa']['cantidad'] = str_replace('.', '', $this->request->data['Tasa']['cantidad']);
                $this->request->data['Tasa']['cantidad'] = str_replace(',', '.', $this->request->data['Tasa']['cantidad']);
                $this->request->data['Tasa']['cantidad'] = number_format($this->request->data['Tasa']['cantidad'], 2, '.', '');
                
                //Guardar y comprobar éxito
                if ($this->Tasa->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('La tasa ha sido guardada correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
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
        $this->Tasa->id = $id;
        
        //Comprobar si existe la tasa
        if (!$this->Tasa->exists()) {
             $this->Session->setFlash(__('La tasa especificada no existe.'));
             $this->redirect(array('action' => 'index'));
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
     * find method
     *
     * @return void
     */
    public function buscar() {
        
        //Devolver las opciones de selección de monedas
        $this->set('monedas', $this->Tasa->moneda);
        
        //Eliminar reglas de validación
        unset($this->Tasa->validate);
        
    }
    
    /**
     * edit method
     *
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
             $this->Session->setFlash(__('La tasa especificada no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Tasa']['id'] = $id;
            
            //Validar los datos introducidos
            if ($this->Tasa->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Convertir la cantidad al formato numérico pirata
                $this->request->data['Tasa']['cantidad'] = str_replace('.', '', $this->request->data['Tasa']['cantidad']);
                $this->request->data['Tasa']['cantidad'] = str_replace(',', '.', $this->request->data['Tasa']['cantidad']);
                $this->request->data['Tasa']['cantidad'] = number_format($this->request->data['Tasa']['cantidad'], 2, '.', '');
                
                //Guardar y comprobar éxito
                if ($this->Tasa->saveAssociated($this->request->data, $this->opciones_guardado)) {
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
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
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
            
            //Devolver nombres bonitos para entidades relacionadas
            $this->request->data['Tasa']['inicio_bonito'] = date('d/m/Y', strtotime($this->request->data['Tasa']['inicio_validez']));
            $this->request->data['Tasa']['fin_bonito'] = date('d/m/Y', strtotime($this->request->data['Tasa']['fin_validez']));
            $this->request->data['Tasa']['cantidad'] = number_format($this->request->data['Tasa']['cantidad'], 2, ',', '.');
            
            //Guardar los datos de sesión de la tasa
            $this->Session->write('Tasa.id', $this->request->data['Tasa']['id']);
            $this->Session->write('Tasa.concepto', $this->request->data['Tasa']['concepto']);
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
        $this->Tasa->id = $id;
        
        //Comprobar si existe la tasa
        if (!$this->Tasa->exists()) {
            $this->Session->setFlash(__('La tasa especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la tasa
        $tasa = $this->Tasa->find('first', array(
         'conditions' => array(
          'Tasa.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $tasa['Tasa']['concepto'];
        $this->pdfConfig['filename'] = "Tasa_" . $tasa['Tasa']['concepto'] . ".pdf";
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('tasa'));
        
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
        $this->Tasa->id = $id;
        
        //Comprobar si existe la tasa
        if (!$this->Tasa->exists()) {
            $this->Session->setFlash(__('La tasa especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la tasa
        $tasa = $this->Tasa->find('first', array(
         'conditions' => array(
          'Tasa.id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $tasa['Tasa']['concepto'];
        $this->pdfConfig['filename'] = "Tasa_" . $tasa['Tasa']['concepto'] . ".pdf";
        $this->pdfConfig['download'] = true;
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('tasa'));
        
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
        $this->Tasa->id = $id;
        
        //Comprobar si existe la tasa
        if (!$this->Tasa->exists()) {
            throw new NotFoundException(__('La tasa especificada no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Tasa->delete()) {
            $this->Session->setFlash(__('La tasa ha sido eliminado correctamente.'));
        }
        else {
            $this->Session->setFlash(__('Ha ocurrido un error mágico. La tasa no ha podido ser eliminado.'));
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
        $resultados = $this->Tasa->find('all', array(
         'conditions' => array(
          'Tasa.concepto LIKE' => $palabro,
         ),
         'fields' => array(
          'Tasa.id', 'Tasa.concepto'
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
          array_push($items, array("label" => $resultado['Tasa']['concepto'], "value" => $resultado['Tasa']['id']));
         }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }

}
