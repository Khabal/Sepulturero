<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Pagos Controller
 *
 * @property Pago $Pago
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prgg
 */
class PagosController extends AppController {
    
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
    public $modelClass = 'Pago';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Pagos';
    
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
    public $uses = array('Pago', 'ArrendatarioPago', 'PagoTasa', 'Sanitize');
    
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
            'Pago' => array('id', 'fecha', 'total', 'moneda', 'observaciones'),
            'ArrendatarioPago' => array('id', 'arrendatario_id', 'pago_id', ),
            'PagoTasa' => array('id', 'pago_id', 'tasa_id', ),
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
         'conditions' => $this->Pago->parseCriteria($this->params->query),
         'contain' => array(
          'PagoTasa' => array(
           'Tasa' => array(
            'fields' => array(
             'Tasa.id', 'Tasa.tipo'
            ),
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
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Crear nuevo pago con id único
            $this->Pago->create();
            
            //Validar los datos introducidos
            if ($this->Pago->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Guardar y comprobar éxito
                if ($this->Pago->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El pago ha sido guardado correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
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
        $this->Pago->id = $id;
        
        //Comprobar si existe el pago
        if (!$this->Pago->exists()) {
             $this->Session->setFlash(__('El pago especificado no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el pago
        $pago = $this->Pago->find('first', array(
         'conditions' => array(
          'Pago.id' => $id
         ),
         'contain' => array(
          'PagoTasa' => array(
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
        $this->set(compact('pago'));
        
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
        
        //Devolver las opciones de selección de monedas
        $this->set('monedas', $this->Pago->moneda);
        
        //Asignar id
        $this->Pago->id = $id;
        
        //Comprobar si existe el pago
        if (!$this->Pago->exists()) {
             $this->Session->setFlash(__('El pago especificado no existe.'));
             $this->redirect(array('action' => 'index'));
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
     * print method
     *
     * @param string $id
     * @return void
     */
    public function imprimir($id = null) {
        
        //Asignar id
        $this->Pago->id = $id;
        
        //Comprobar si existe el pago
        if (!$this->Pago->exists()) {
             $this->Session->setFlash(__('El pago especificado no existe.'));
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
        $this->set(compact('pago'));
        
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
        $this->Pago->id = $id;
        
        //Comprobar si existe el pago
        if (!$this->Pago->exists()) {
             $this->Session->setFlash(__('El pago especificado no existe.'));
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
        $this->set(compact('pago'));
        
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
        $this->Pago->id = $id;
        
        //Comprobar si existe el pago
        if (!$this->Pago->exists()) {
            throw new NotFoundException(__('El pago especificado no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Pago->delete()) {
            $this->Session->setFlash(__('El pago ha sido eliminado correctamente.'));
        }
        else {
            $this->Session->setFlash(__('Ha ocurrido un error mágico. El pago no ha podido ser eliminado.'));
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
        $resultados = $this->Pago->find('all', array(
         'conditions' => array(
          'OR' =>  array(
           'DATE_FORMAT(Pago.fecha, "%d/%m/%Y") LIKE' => $palabro,
           'Pago.motivo LIKE' => $palabro,
           'CONCAT(DATE_FORMAT(Pago.fecha, "%d/%m/%Y")," ",Pago.motivo) LIKE' => $palabro,
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
