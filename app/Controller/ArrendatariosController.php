<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Arrendatarios Controller
 *
 * @property Arrendatario $Arrendatario
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class ArrendatariosController extends AppController {
    
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
    public $modelClass = 'Arrendatario';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Arrendatarios';
    
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
    public $uses = array('Arrendatario', 'Arrendamiento', 'ArrendatarioFuneraria', 'ArrendatarioPago', 'Funeraria', 'Persona', 'Sanitize');
    
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
            'Arrendatario' => array('id', 'persona_id', 'direccion', 'localidad', 'provincia', 'pais', 'codigo_postal', 'telefono', 'correo_electronico'),
            'ArrendatarioFuneraria' => array('id', 'arrendatario_id', 'funeraria_id'),
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
         'conditions' => $this->Arrendatario->parseCriteria($this->params->query),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
           ),
          ),
         ),
        );
        
        //Devolver paginación
        $this->set('arrendatarios', $this->paginate());
        
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
            
            //Crear nuevo arrendatario con id único
            $this->Arrendatario->create();
            
            //Comprobar si ha introducido un DNI
            if (!empty($this->request->data['Persona']['dni'])) {
                
                //Buscar si existe ya una persona con el mismo DNI
                $persona = $this->Arrendatario->Persona->find('first', array(
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
                    $this->request->data['Arrendatario']['persona_id'] = $persona['Persona']['id'];
                    $this->request->data['Persona']['id'] = $persona['Persona']['id'];
                }
                
            }
            
            //Comprobar si hay funerarias vacías y eliminarlas
            if (isset($this->request->data['ArrendatarioFuneraria'])) {
                $i = 0;
                foreach ($this->request->data['ArrendatarioFuneraria'] as $funeraria) {
                    if (empty($funeraria['funeraria_bonita'])) {
                        unset($this->request->data['ArrendatarioFuneraria'][$i]);
                    }
                    $i++;
                }
            }
            
            //Comprobar si hay funerarias repetidas y eliminarlas
            $this->request->data['ArrendatarioFuneraria'] = array_unique($this->request->data['ArrendatarioFuneraria']);
            $this->request->data['ArrendatarioFuneraria'] = array_values($this->request->data['ArrendatarioFuneraria']);
            
            //Indicar que se trata de un arrendatario
            $this->request->data['Persona']['arrendatario_id'] = '';
            
            //Establecer el sexo como desconocido
            $this->request->data['Persona']['sexo'] = 'Desconocido';
            
            //Validar los datos introducidos
            if ($this->Arrendatario->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Convertir a mayúsculas el carácter del DNI
                $this->request->data['Persona']['dni'] = strtoupper($this->request->data['Persona']['dni']);
                
                //Guardar y comprobar éxito
                if ($this->Arrendatario->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El arrendatario ha sido guardado correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
                        $this->redirect(array('action' => 'nuevo'));
                    }
                    else {
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El arrendatario no ha podido ser guardado.'));
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
        $this->Arrendatario->id = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
             $this->Session->setFlash(__('El arrendatario especificado no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el arrendatario
        $arrendatario = $this->Arrendatario->find('first', array(
         'conditions' => array(
          'Arrendatario.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nacionalidad', 'Persona.observaciones', 'Persona.nombre_completo'
           ),
          ),
          'ArrendatarioFuneraria' => array(
           'Funeraria' => array(
            'fields' => array(
             'Funeraria.id', 'Funeraria.nombre', 'Funeraria.direccion', 'Funeraria.telefono', 'Funeraria.fax', 'Funeraria.correo_electronico', 'Funeraria.pagina_web'
            ),
           ),
          ),
          'Arrendamiento' => array(
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
             'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
            ),
           ),
           'Concesion' => array(
            'fields' => array(
             'Concesion.id', 'Concesion.tipo', 'Concesion.anos_concesion'
            ),
           ),
          ),
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendatario'));
        
    }
    
    /**
     * find method
     *
     * @return void
     */
    public function buscar() {
        
        //Eliminar reglas de validación
        unset($this->Arrendatario->validate);
        
    }
    
    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function editar($id = null) {
        
        //Asignar id
        $this->Arrendatario->id = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
             $this->Session->setFlash(__('El arrendatario especificado no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Persona']['id'] = $this->Session->read('Arrendatario.persona_id');
            $this->request->data['Persona']['arrendatario_id'] = $id;
            $this->request->data['Persona']['sexo'] = $this->Session->read('Arrendatario.sexo');
            $this->request->data['Arrendatario']['id'] = $id;
            $this->request->data['Arrendatario']['persona_id'] = $this->Session->read('Arrendatario.persona_id');
            
            //Comprobar si hay funerarias vacías y eliminarlas
            if (isset($this->request->data['ArrendatarioFuneraria'])) {
                $i = 0;
                foreach ($this->request->data['ArrendatarioFuneraria'] as $funeraria) {
                    if (empty($funeraria['funeraria_bonita'])) {
                        unset($this->request->data['ArrendatarioFuneraria'][$i]);
                    }
                    $i++;
                }
            }
            
            //Validar los datos introducidos
            if ($this->Arrendatario->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Convertir a mayúsculas el carácter del DNI
                $this->request->data['Persona']['dni'] = strtoupper($this->request->data['Persona']['dni']);
                
                //Guardar y comprobar éxito
                if ($this->Arrendatario->ArrendatarioFuneraria->deleteAll(array('ArrendatarioFuneraria.arrendatario_id' => $id), false, false) && $this->Arrendatario->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El arrendatario ha sido actualizado correctamente.'));
                    //Borrar datos de sesión
                    $this->Session->delete('Arrendatario');
                    //Redireccionar a index
                    $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El arrendatario no ha podido ser actualizado.'));
                }
            }
            else {
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
            }
            
        }
        else {
            //Devolver los datos actuales del arrendatario
            $this->request->data = $this->Arrendatario->find('first', array(
             'conditions' => array(
              'Arrendatario.id' => $id
             ),
             'contain' => array(
              'Persona' => array(
               'fields' => array(
                'Persona.id', 'Persona.dni', 'Persona.nombre', 'Persona.apellido1', 'Persona.apellido2', 'Persona.sexo', 'Persona.nacionalidad', 'Persona.observaciones', 'Persona.nombre_completo'
               ),
              ),
              'ArrendatarioFuneraria' => array(
               'Funeraria' => array(
                'fields' => array(
                 'Funeraria.id', 'Funeraria.nombre'
                ),
               ),
              ),
             ),
            ));
            
            //Devolver nombres bonitos para entidades relacionadas
            if (!empty($this->request->data['ArrendatarioFuneraria'])) {
                $i = 0;
                foreach ($this->request->data['ArrendatarioFuneraria'] as $funeraria) {
                    $this->request->data['ArrendatarioFuneraria'][$i]['funeraria_bonita'] = $funeraria['Funeraria']['nombre'];
                    $this->request->data['ArrendatarioFuneraria'][$i]['funeraria_id'] = $funeraria['funeraria_id'];
                    unset($this->request->data['ArrendatarioFuneraria'][$i]['Funeraria']);
                    $i++;
                }
            }
            
            //Guardar los datos de sesión del arrendatario
            $this->Session->write('Arrendatario.id', $this->request->data['Arrendatario']['id']);
            $this->Session->write('Arrendatario.persona_id', $this->request->data['Persona']['id']);
            $this->Session->write('Arrendatario.persona_dni', $this->request->data['Persona']['dni']);
            $this->Session->write('Arrendatario.nombre_completo', $this->request->data['Persona']['nombre_completo']);
            $this->Session->write('Arrendatario.sexo', $this->request->data['Persona']['sexo']);
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
        $this->Arrendatario->id = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
            $this->Session->setFlash(__('El arrendatario especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el arrendatario
        $arrendatario = $this->Arrendatario->find('first', array(
         'conditions' => array(
          'Arrendatario.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nacionalidad', 'Persona.observaciones', 'Persona.nombre_completo'
           ),
          ),
          'ArrendatarioFuneraria' => array(
           'Funeraria' => array(
            'fields' => array(
             'Funeraria.id', 'Funeraria.nombre', 'Funeraria.direccion', 'Funeraria.telefono', 'Funeraria.fax', 'Funeraria.correo_electronico', 'Funeraria.pagina_web'
            ),
           ),
          ),
          'Arrendamiento' => array(
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
             'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
            ),
           ),
           'Concesion' => array(
            'fields' => array(
             'Concesion.id', 'Concesion.tipo', 'Concesion.anos_concesion'
            ),
           ),
          ),
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $arrendatario['Persona']['nombre_completo'] . " - " . $arrendatario['Persona']['dni'];
        $this->pdfConfig['filename'] = "Arrendatario_" . $arrendatario['Persona']['dni'] . ".pdf";
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendatario'));
        
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
        $this->Arrendatario->id = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
             $this->Session->setFlash(__('El arrendatario especificado no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el arrendatario
        $arrendatario = $this->Arrendatario->find('first', array(
         'conditions' => array(
          'Arrendatario.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nacionalidad', 'Persona.observaciones', 'Persona.nombre_completo'
           ),
          ),
          'ArrendatarioFuneraria' => array(
           'Funeraria' => array(
            'fields' => array(
             'Funeraria.id', 'Funeraria.nombre', 'Funeraria.direccion', 'Funeraria.telefono', 'Funeraria.fax', 'Funeraria.correo_electronico', 'Funeraria.pagina_web'
            ),
           ),
          ),
          'Arrendamiento' => array(
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
             'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
            ),
           ),
           'Concesion' => array(
            'fields' => array(
             'Concesion.id', 'Concesion.tipo', 'Concesion.anos_concesion'
            ),
           ),
          ),
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $arrendatario['Persona']['nombre_completo'] . " - " . $arrendatario['Persona']['dni'];
        $this->pdfConfig['filename'] = "Arrendatario_" . $arrendatario['Persona']['dni'] . ".pdf";
        $this->pdfConfig['download'] = true;
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendatario'));
        
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
        $this->Arrendatario->id = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
            throw new NotFoundException(__('El arrendatario especificado no existe.'));
        }
        
        //Comprobar si la persona está asociada con algún difunto o médico forense para en caso contrario eliminarlo también
        $persona = $this->Arrendatario->field('persona_id', array('Arrendatario.id' => $id));
        $difunto = $this->Arrendatario->Persona->Difunto->field('id', array('Difunto.persona_id' => $persona));
        $forense = $this->Arrendatario->Persona->Forense->field('id', array('Forense.persona_id' => $persona));
        
        if (empty($difunto) && empty($forense)) {
            //Borrar y comprobar éxito (Persona y Arrendatario)
            if ($this->Arrendatario->Persona->delete($persona)) {
                $this->Session->setFlash(__('El arrendatario ha sido eliminado correctamente.'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El arrendatario no ha podido ser eliminado.'));
            }
        }
        else {
            //Borrar y comprobar éxito (Arrendatario)
            if ($this->Arrendatario->delete()) {
                $this->Session->setFlash(__('El arrendatario ha sido eliminado correctamente.'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El arrendatario no ha podido ser eliminado.'));
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
        $resultados = $this->Arrendatario->find('all', array(
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
                array_push($items, array("label" => $resultado['Persona']['nombre_completo'] . " - " . $resultado['Persona']['dni'], "value" => $resultado['Arrendatario']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }
    
}
