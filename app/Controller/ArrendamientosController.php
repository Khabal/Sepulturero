<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Arrendamientos Controller
 *
 * @property Arrendamiento $Arrendamiento
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class ArrendamientosController extends AppController {
    
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
    public $modelClass = 'Arrendamiento';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Arrendamientos';
    
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
    public $uses = array('Arrendamiento', 'Arrendatario', 'Concesion', 'Tumba', 'Sanitize');
    
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
            'model' => 'Arrendamiento',
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
            'Arrendamiento' => array('id', 'arrendatario_id', 'concesion_id', 'tumba_id', 'fecha_arrendamiento', 'estado', 'observaciones'),
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
         'conditions' => $this->Arrendamiento->parseCriteria($this->params->query),
         'contain' => array(
          'Arrendatario' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Arrendatario.id', 'Arrendatario.persona_id'
           ),
          ),
          'Concesion' => array(
           'fields' => array(
            'Concesion.id', 'Concesion.tipo', 'Concesion.anos_concesion'
           ),
          ),
          'Tumba' => array(
           'Columbario' => array(
            'fields' => array(
             'Columbario.id', 'Columbario.tumba_id', 'Columbario.localizacion'
            ),
           ),
           'Nicho' => array(
            'fields' => array(
             'Nicho.id', 'Nicho.tumba_id', 'Nicho.localizacion'
            ),
           ),
           'Panteon' => array(
            'fields' => array(
             'Panteon.id', 'Panteon.tumba_id', 'Panteon.localizacion'
            ),
           ),
           'Exterior' => array(
            'fields' => array(
             'Exterior.id', 'Exterior.tumba_id', 'Exterior.localizacion'
            ),
           ),
           'fields' => array(
            'Tumba.id', 'Tumba.tipo'
           ),
          ),
         ),
        );
        
        //Devolver paginación
        $this->set('arrendamientos', $this->paginate());
        
    }
    
    /**
     * add method
     *
     * @return void
     */
    public function nuevo() {
        
        //Devolver las opciones de selección de estado del arrendamiento de una tumba
        $this->set('estado', $this->Arrendamiento->estado);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Crear nuevo arrendamiento con id único
            $this->Arrendamiento->create();
            
            //Validar los datos introducidos
            if ($this->Arrendamiento->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Guardar y comprobar éxito
                if ($this->Arrendamiento->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El arrendamiento ha sido guardado correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
                        $this->redirect(array('action' => 'nuevo'));
                    }
                    else {
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El arrendamiento no ha podido ser guardado.'));
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
        $this->Arrendamiento->id = $id;
        
        //Comprobar si existe el arrendamiento
        if (!$this->Arrendamiento->exists()) {
            $this->Session->setFlash(__('El arrendamiento especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el arrendamiento
        $arrendamiento = $this->Arrendamiento->find('first', array(
         'conditions' => array(
          'Arrendamiento.id' => $id
         ),
         'contain' => array(
          'Arrendatario' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.observaciones', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Arrendatario.id', 'Arrendatario.persona_id', 'Arrendatario.direccion', 'Arrendatario.localidad', 'Arrendatario.provincia', 'Arrendatario.pais', 'Arrendatario.codigo_postal', 'Arrendatario.telefono', 'Arrendatario.correo_electronico'
            ),
          ),
          'Concesion' => array(
           'fields' => array(
            'Concesion.id', 'Concesion.tipo', 'Concesion.anos_concesion', 'Concesion.observaciones'
           ),
          ),
          'Tumba' => array(
           'Columbario' => array(
            'fields' => array(
             'Columbario.id', 'Columbario.tumba_id', 'Columbario.localizacion'
            ),
           ),
           'Exterior' => array(
            'fields' => array(
             'Exterior.id', 'Exterior.tumba_id', 'Exterior.localizacion'
            ),
           ),
           'Nicho' => array(
            'fields' => array(
             'Nicho.id', 'Nicho.tumba_id', 'Nicho.localizacion'
            ),
           ),
           'Panteon' => array(
            'fields' => array(
             'Panteon.id', 'Panteon.tumba_id', 'Panteon.localizacion'
            ),
           ),
           'fields' => array(
            'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion', 'Tumba.observaciones'
           ),
          ),
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendamiento'));
        
    }
    
    /**
     * find method
     *
     * @return void
     */
    public function buscar() {
        
        //Devolver las opciones de selección de estado del arrendamiento de una tumba
        $this->set('estado', $this->Arrendamiento->estado);
        
        //Eliminar reglas de validación
        unset($this->Arrendamiento->validate);
        
    }
    
    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function editar($id = null) {
        
        //Devolver las opciones de selección de estado del arrendamiento de la tumba
        $this->set('estado', $this->Arrendamiento->estado);
        
        //Asignar id
        $this->Arrendamiento->id = $id;
        
        //Comprobar si existe el arrendamiento
        if (!$this->Arrendamiento->exists()) {
            $this->Session->setFlash(__('El arrendamiento especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Arrendamiento']['id'] = $id;
            
            //Validar los datos introducidos
            if ($this->Arrendamiento->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Guardar y comprobar éxito
                if ($this->Arrendamiento->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El arrendamiento ha sido actualizado correctamente.'));
                    //Borrar datos de sesión
                    $this->Session->delete('Arrendamiento');
                    //Redireccionar a index
                    $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El arrendamiento no ha podido ser actualizado.'));
                }
            }
            else {
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
            }
        }
        else {
            //Devolver los datos actuales del arrendatario
            $this->request->data = $this->Arrendamiento->find('first', array(
             'conditions' => array(
              'Arrendamiento.id' => $id
             ),
             'contain' => array(
              'Arrendatario' => array(
               'Persona' => array(
                'fields' => array(
                 'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
                ),
               ),
               'fields' => array(
                'Arrendatario.id', 'Arrendatario.persona_id'
                ),
              ),
              'Concesion' => array(
               'fields' => array(
                'Concesion.id', 'Concesion.tipo', 'Concesion.anos_concesion'
               ),
              ),
              'Tumba' => array(
               'Columbario' => array(
                'fields' => array(
                 'Columbario.id', 'Columbario.tumba_id', 'Columbario.localizacion'
                ),
               ),
               'Exterior' => array(
                'fields' => array(
                 'Exterior.id', 'Exterior.tumba_id', 'Exterior.localizacion'
                ),
               ),
               'Nicho' => array(
                'fields' => array(
                 'Nicho.id', 'Nicho.tumba_id', 'Nicho.localizacion'
                ),
               ),
               'Panteon' => array(
                'fields' => array(
                 'Panteon.id', 'Panteon.tumba_id', 'Panteon.localizacion'
                ),
               ),
               'fields' => array(
                'Tumba.id', 'Tumba.tipo'
               ),
              ),
             ),
            ));
            
            //Devolver nombres bonitos para entidades relacionadas
            $this->request->data['Arrendamiento']['fecha_bonita'] = date('d/m/Y', strtotime($this->request->data['Arrendamiento']['fecha_arrendamiento']));
            $this->request->data['Arrendamiento']['arrendatario_bonito'] = $this->request->data['Arrendatario']['Persona']['nombre_completo'] . " - " . $this->request->data['Arrendatario']['Persona']['dni'];
            $this->request->data['Arrendamiento']['concesion_bonita'] = $this->request->data['Concesion']['tipo'] . " - " . $this->request->data['Concesion']['anos_concesion'] . " años";
            //Devolver nombre bonito para la tumba
            $localizacion = "";
            if (!empty($this->request->data['Tumba']['Columbario']['localizacion'])) {
                $localizacion = $this->request->data['Tumba']['Columbario']['localizacion'];
            }
            elseif(!empty($this->request->data['Tumba']['Exterior']['localizacion'])) {
                $localizacion = $this->request->data['Tumba']['Exterior']['localizacion'];
            }
            elseif(!empty($this->request->data['Tumba']['Nicho']['localizacion'])) {
                $localizacion = $this->request->data['Tumba']['Nicho']['localizacion'];
            }
            elseif(!empty($this->request->data['Tumba']['Panteon']['localizacion'])) {
                $localizacion = $this->request->data['Tumba']['Panteon']['localizacion'];
            }
            $this->request->data['Arrendamiento']['tumba_bonita'] = $this->request->data['Tumba']['tipo'] . " - " . $localizacion;
            
            //Guardar los datos de sesión del arrendatario
            $this->Session->write('Arrendamiento.id', $this->request->data['Arrendamiento']['id']);
            $this->Session->write('Arrendamiento.identificador', $this->request->data['Tumba']['tipo'] . " - " . $this->request->data['Tumba'][$this->request->data['Tumba']['tipo']]['localizacion'] . " por " . $this->request->data['Concesion']['anos_concesion'] . "años.");
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
        $this->Arrendamiento->id = $id;
        
        //Comprobar si existe el arrendamiento
        if (!$this->Arrendamiento->exists()) {
            $this->Session->setFlash(__('El arrendamiento especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el arrendamiento
        $arrendamiento = $this->Arrendamiento->find('first', array(
         'conditions' => array(
          'Arrendamiento.id' => $id
         ),
         'contain' => array(
          'Arrendatario' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.observaciones', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Arrendatario.id', 'Arrendatario.persona_id', 'Arrendatario.direccion', 'Arrendatario.localidad', 'Arrendatario.provincia', 'Arrendatario.pais', 'Arrendatario.codigo_postal', 'Arrendatario.telefono', 'Arrendatario.correo_electronico'
            ),
          ),
          'Concesion' => array(
           'fields' => array(
            'Concesion.id', 'Concesion.tipo', 'Concesion.anos_concesion', 'Concesion.observaciones'
           ),
          ),
          'Tumba' => array(
           'Columbario' => array(
            'fields' => array(
             'Columbario.id', 'Columbario.tumba_id', 'Columbario.localizacion'
            ),
           ),
           'Exterior' => array(
            'fields' => array(
             'Exterior.id', 'Exterior.tumba_id', 'Exterior.localizacion'
            ),
           ),
           'Nicho' => array(
            'fields' => array(
             'Nicho.id', 'Nicho.tumba_id', 'Nicho.localizacion'
            ),
           ),
           'Panteon' => array(
            'fields' => array(
             'Panteon.id', 'Panteon.tumba_id', 'Panteon.localizacion'
            ),
           ),
           'fields' => array(
            'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion', 'Tumba.observaciones'
           ),
          ),
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $arrendamiento['Tumba']['tipo'] . " - " . $arrendamiento['Tumba'][$arrendamiento['Tumba']['tipo']]['localizacion'] . " por " . $arrendamiento['Concesion']['anos_concesion'] . "años.";
        $this->pdfConfig['filename'] = "Arrendamiento_" . $arrendamiento['Tumba']['tipo'] . " - " . $arrendamiento['Tumba'][$arrendamiento['Tumba']['tipo']]['localizacion'] . ".pdf";
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendamiento'));
        
        //Redireccionar para la generación
        
        
    }
    
    /**
     * export pdf method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function exportar_pdf($id = null) {
        
        //Asignar id
        $this->Arrendamiento->id = $id;
        
        //Comprobar si existe el arrendamiento
        if (!$this->Arrendamiento->exists()) {
            $this->Session->setFlash(__('El arrendamiento especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el arrendamiento
        $arrendamiento = $this->Arrendamiento->find('first', array(
         'conditions' => array(
          'Arrendamiento.id' => $id
         ),
         'contain' => array(
          'Arrendatario' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.observaciones', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Arrendatario.id', 'Arrendatario.persona_id', 'Arrendatario.direccion', 'Arrendatario.localidad', 'Arrendatario.provincia', 'Arrendatario.pais', 'Arrendatario.codigo_postal', 'Arrendatario.telefono', 'Arrendatario.correo_electronico'
            ),
          ),
          'Concesion' => array(
           'fields' => array(
            'Concesion.id', 'Concesion.tipo', 'Concesion.anos_concesion', 'Concesion.observaciones'
           ),
          ),
          'Tumba' => array(
           'Columbario' => array(
            'fields' => array(
             'Columbario.id', 'Columbario.tumba_id', 'Columbario.localizacion'
            ),
           ),
           'Exterior' => array(
            'fields' => array(
             'Exterior.id', 'Exterior.tumba_id', 'Exterior.localizacion'
            ),
           ),
           'Nicho' => array(
            'fields' => array(
             'Nicho.id', 'Nicho.tumba_id', 'Nicho.localizacion'
            ),
           ),
           'Panteon' => array(
            'fields' => array(
             'Panteon.id', 'Panteon.tumba_id', 'Panteon.localizacion'
            ),
           ),
           'fields' => array(
            'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion', 'Tumba.observaciones'
           ),
          ),
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $arrendamiento['Tumba']['tipo'] . " - " . $arrendamiento['Tumba'][$arrendamiento['Tumba']['tipo']]['localizacion'] . " por " . $arrendamiento['Concesion']['anos_concesion'] . "años.";
        $this->pdfConfig['filename'] = "Arrendamiento_" . $arrendamiento['Tumba']['tipo'] . " - " . $arrendamiento['Tumba'][$arrendamiento['Tumba']['tipo']]['localizacion'] . ".pdf";
        $this->pdfConfig['download'] = true;
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendamiento'));
        
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
        $this->Arrendamiento->id = $id;
        
        //Comprobar si existe el arrendamiento
        if (!$this->Arrendamiento->exists()) {
            throw new NotFoundException(__('El arrendamiento especificado no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Arrendamiento->delete()) {
            $this->Session->setFlash(__('El arrendamiento ha sido eliminado correctamente.'));
        }
        else {
            $this->Session->setFlash(__('Ha ocurrido un error mágico. El arrendamiento no ha podido ser eliminado.'));
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
        $resultados = null;
        
        //Procesamiento y codificación en JSON
        $items = array();
        
        if (empty($resultados)) {
            array_push($items, array("label"=>"No hay coincidencias", "value"=>""));
        }
        else {
            foreach($resultados as $resultado) {
                array_push($items, array("label" => $resultado, "value" => $resultado));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }
    
}
