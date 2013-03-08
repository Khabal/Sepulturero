<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Forenses Controller
 *
 * @property Forense $Forense
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class ForensesController extends AppController {
    
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
    public $modelClass = 'Forense';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Forenses';
    
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
    public $uses = array('Forense', 'Difunto', 'Persona', 'Sanitize');
    
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
            'Persona' => array('id', 'dni', 'nombre', 'apellido1', 'apellido2', 'sexo', 'nacionalidad', 'observaciones'),
            'Forense' => array('id', 'persona_id', 'numero_colegiado', 'colegio', 'telefono', 'correo_electronico'),
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
         'conditions' => $this->Forense->parseCriteria($this->params->query),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
           ),
          ),
         ),
        );
        
        //Devolver paginación
        $this->set('forenses', $this->paginate());  
        
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
            
            //Crear nuevo médico forense con id único
            $this->Forense->create();
            
            //Comprobar si ha introducido un DNI
            if (!empty($this->request->data['Persona']['dni'])) {
                
                //Buscar si existe ya una persona con el mismo DNI
                $persona = $this->Forense->Persona->find('first', array(
                 'conditions' => array(
                  'Persona.dni' => strtoupper($this->request->data['Persona']['dni']),
                 ),
                 'fields' => array(
                  'Persona.id'
                 ),
                 'contain' => array(
                 ),
                ));
                
                //Establecer claves externas de la persona si ya existe para evitar duplicidad
                if(!empty($persona['Persona']['id'])) {
                    $this->request->data['Forense']['persona_id'] = $persona['Persona']['id'];
                    $this->request->data['Persona']['id'] = $persona['Persona']['id'];
                }
                
            }
            
            //Indicar que se trata de un médico forense
            $this->request->data['Persona']['forense_id'] = '';
            
            //Establecer el sexo como desconocido
            $this->request->data['Persona']['sexo'] = 'Desconocido';
            
            //Validar los datos introducidos
            if ($this->Forense->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Convertir a mayúsculas el carácter del DNI
                $this->request->data['Persona']['dni'] = strtoupper($this->request->data['Persona']['dni']);
                
                //Guardar y comprobar éxito
                if ($this->Forense->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El médico forense ha sido guardado correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
                        $this->redirect(array('action' => 'nuevo'));
                    }
                    else {
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El médico forense no ha podido ser guardado.'));
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
        $this->Forense->id = $id;
        
        //Comprobar si existe el médico forense
        if (!$this->Forense->exists()) {
            $this->Session->setFlash(__('El médico forense especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el médico forense
        $forense = $this->Forense->find('first', array(
         'conditions' => array(
          'Forense.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nacionalidad', 'Persona.observaciones', 'Persona.nombre_completo'
           ),
          ),
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('forense'));
        
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
        $this->Forense->id = $id;
        
        //Comprobar si existe el médico forense
        if (!$this->Forense->exists()) {
            $this->Session->setFlash(__('El médico forense especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Persona']['id'] = $this->Session->read('Forense.persona_id');
            $this->request->data['Persona']['forense_id'] = $id;
            $this->request->data['Persona']['sexo'] = $this->Session->read('Forense.sexo');
            $this->request->data['Forense']['id'] = $id;
            $this->request->data['Forense']['persona_id'] = $this->Session->read('Forense.persona_id');
            
            //Validar los datos introducidos
            if ($this->Forense->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Convertir a mayúsculas el carácter del DNI
                $this->request->data['Persona']['dni'] = strtoupper($this->request->data['Persona']['dni']);
                
                //Guardar y comprobar éxito
                if ($this->Forense->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El médico forense ha sido actualizado correctamente.'));
                    //Borrar datos de sesión
                    $this->Session->delete('Forense');
                    //Redireccionar a index
                    $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El médico forense no ha podido ser actualizado.'));
                }
            }
            else {
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
            }
        }
        else {
            //Devolver los datos actuales del médico forense
            $this->request->data = $this->Forense->find('first', array(
             'conditions' => array(
              'Forense.id' => $id
             ),
             'contain' => array(
              'Persona' => array(
              ),
             ),
            ));
            
            //Guardar los datos de sesión del médico forense
            $this->Session->write('Forense.id', $this->request->data['Forense']['id']);
            $this->Session->write('Forense.persona_id', $this->request->data['Forense']['persona_id']);
            $this->Session->write('Forense.nombre_completo', $this->request->data['Persona']['nombre_completo']);
            $this->Session->write('Forense.sexo', $this->request->data['Persona']['sexo']);
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
        $this->Forense->id = $id;
        
        //Comprobar si existe el médico forense
        if (!$this->Forense->exists()) {
            $this->Session->setFlash(__('El médico forense especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el médico forense
        $forense = $this->Forense->find('first', array(
         'conditions' => array(
          'Forense.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.observaciones', 'Persona.nombre_completo'
           ),
          ),
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $forense['Persona']['nombre_completo'] . " - " . $forense['Forense']['numero_colegiado'] . "(" . $forense['Forense']['colegio'] . ")";
        $this->pdfConfig['filename'] = "Forense_" . $forense['Forense']['numero_colegiado'] . ".pdf";
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('forense'));
        
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
        $this->Forense->id = $id;
        
        //Comprobar si existe el médico forense
        if (!$this->Forense->exists()) {
            $this->Session->setFlash(__('El médico forense especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el médico forense
        $forense = $this->Forense->find('first', array(
         'conditions' => array(
          'Forense.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.observaciones', 'Persona.nombre_completo'
           ),
          ),
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $forense['Persona']['nombre_completo'] . " - " . $forense['Forense']['numero_colegiado'] . "(" . $forense['Forense']['colegio'] . ")";
        $this->pdfConfig['filename'] = "Forense_" . $forense['Forense']['numero_colegiado'] . ".pdf";
        $this->pdfConfig['download'] = true;
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('forense'));
        
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
        $this->Forense->id = $id;
        
        //Comprobar si existe el médico forense
        if (!$this->Forense->exists()) {
            throw new NotFoundException(__('El médico forense especificado no existe.'));
        }
        
        //Buscar si el médico forense está en uso en algún difunto
        $difunto = $this->Forense->Difunto->find('first', array(
         'conditions' => array(
          'Difunto.forense_id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si el médico forense está en uso en difuntos
        if (!empty($difunto)) {
            $this->Session->setFlash(__('El médico forense está asociado a un difunto.'));
        }
        else {
            //Comprobar si la persona está asociada con algún arrendatario o difunto para en caso contrario eliminarlo también
            $persona = $this->Forense->field('persona_id', array('Forense.id' => $id));
            $arrendatario = $this->Forense->Persona->Arrendatario->field('id', array('Arrendatario.persona_id' => $persona));
            $difunto = $this->Forense->Persona->Difunto->field('id', array('Difunto.persona_id' => $persona));
            
            if (empty($arrendatario) && empty($difunto)) {
                //Borrar y comprobar éxito (Persona y Forense)
                if ($this->Forense->Persona->delete($persona)) {
                    $this->Session->setFlash(__('El médico forense ha sido eliminado correctamente.'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El médico forense no ha podido ser eliminado.'));
                }
            }
            else {
                //Borrar y comprobar éxito (Forense)
                if ($this->Forense->delete()) {
                    $this->Session->setFlash(__('El médico forense ha sido eliminado correctamente.'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El médico forense no ha podido ser eliminado.'));
                }
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
        $resultados = $this->Forense->find('all', array(
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
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
           'Forense.numero_colegiado LIKE' => $palabro, 
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
                array_push($items, array("label" => $resultado['Persona']['nombre_completo'] . " - " . $resultado['Forense']['numero_colegiado'] . " (" . $resultado['Forense']['colegio'] . ")", "value" => $resultado['Forense']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }
    
}
