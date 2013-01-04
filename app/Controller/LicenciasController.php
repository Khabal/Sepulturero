<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Licencias Controller
 *
 * @property Licencia $Licencia
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class LicenciasController extends AppController {
    
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
    public $modelClass = 'Licencia';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Licencias';
    
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
    public $uses = array('Licencia', 'Documento', 'Enterramiento', 'Sanitize');
    
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
            'Persona' => array('id', 'dni', 'nombre', 'apellido1', 'apellido2', 'observaciones'),
            'Arrendatario' => array('id', 'persona_id', 'direccion', 'localidad', 'provincia', 'pais', 'codigo_postal', 'telefono', 'correo_electronico'),
            'ArrendatarioFuneraria' => array('id', 'arrendatario_id', 'funeraria_id'),
            'ArrendatarioTumba' => array('id', 'arrendatario_id', 'tumba_id', 'fecha_arrendamiento', 'estado'),
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
            'conditions' => $this->Licencia->parseCriteria($this->params->query),
            'contain' => array(
            ),
            'fields' => array(
             'Licencia.id', 'Licencia.numero_licencia', 'Licencia.fecha_aprobacion', 'Licencia.anos_concesion', 'Licencia.identificador'
            ),
        );
        
        //Devolver paginación
        $this->set('licencias', $this->paginate());
        
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
            
            //Crear nueva licencia con id único
            $this->Licencia->create();
            
            //Guardar y comprobar éxito
            if ($this->Licencia->saveAssociated($this->request->data, $this->opciones_guardado)) {
                $this->Session->setFlash(__('La licencia ha sido guardada correctamente.'));
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
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La licencia no ha podido ser guardada.'));
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
        $this->Licencia->id = $id;
        
        //Comprobar si existe la funeraria
        if (!$this->Licencia->exists()) {
            throw new NotFoundException(__('La licencia especificada no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con la funeraria
        $licencia = $this->Licencia->find('first', array(
         'conditions' => array(
          'Licencia.id' => $id
         ),
         'contain' => array(
          'Enterramiento' => array(
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
             'Difunto.id', 'Difunto.persona_id'
            ),
           ),
           'fields' => array(
            'Enterramiento.id', 'Enterramiento.difunto_id', 'Enterramiento.licencia_id', 'Enterramiento.tumba_id', 'Enterramiento.fecha'
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
        $this->set(compact('licencia'));
        
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
        $this->Licencia->id = $id;
        $this->request->data['Licencia']['id'] = $id;
        
        //Comprobar si existe la licencia
        if (!$this->Licencia->exists()) {
            throw new NotFoundException(__('La licencia especificada no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Guardar y comprobar éxito
            if ($this->Licencia->saveAssociated($this->request->data, $this->opciones_guardado)) {
                $this->Session->setFlash(__('La licencia ha sido actualizada correctamente.'));
                //Borrar datos de sesión
                $this->Session->delete('Licencia');
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La licencia no ha podido ser actualizada.'));
            }
        }
        else {
            //Devolver los datos actuales de la licencia
            $this->request->data = $this->Licencia->find('first', array(
            'conditions' => array(
             'Licencia.id' => $id
            ),
            'contain' => array(
             'Enterramiento' => array(
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
                'Difunto.id', 'Difunto.persona_id'
               ),
              ),
              'fields' => array(
               'Enterramiento.id', 'Enterramiento.difunto_id', 'Enterramiento.licencia_id', 'Enterramiento.tumba_id', 'Enterramiento.fecha'
              ),
             ),
             'Documento' => array(
              'fields' => array(
               'Documento.id', 'Documento.traslado_id', 'Documento.nombre', 'Documento.tipo'
              ),
             ),
            ),
           ));
            
            //Guardar los datos de sesión de la licencia
            $this->Session->write('Licencia.identificador', $this->request->data['Licencia']['identificador']);
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
        $this->Licencia->id = $id;
        
        //Comprobar si existe la licencia
        if (!$this->Licencia->exists()) {
            throw new NotFoundException(__('La licencia especificada no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Licencia->Documento->deleteAll(array('Documento.licencia_id' => $id), false, false) && $this->Licencia->delete()) {
            $this->Session->setFlash(__('La licencia ha sido eliminada correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. La licencia no ha podido ser eliminada.'));
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
        $resultados = $this->Licencia->find('all', array(
         'conditions' => array(
          'OR' =>  array(
           'Licencia.numero_licencia LIKE' => $palabro,
           'EXTRACT(YEAR FROM Licencia.fecha_aprobacion) LIKE' => $palabro,
           'CONCAT(Licencia.numero_licencia,"/",EXTRACT(YEAR FROM Licencia.fecha_aprobacion)) LIKE' => $palabro,
          ),
         ),
         'fields' => array(
          'Licencia.id', 'Licencia.numero_licencia', 'Licencia.fecha_aprobacion'
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
                $licencia = $resultado['Licencia']['numero_licencia'] . "/" . date('Y', strtotime($resultado['Licencia']['fecha_aprobacion']));
                array_push($items, array("label" => $licencia, "value" => $resultado['Licencia']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }

}
