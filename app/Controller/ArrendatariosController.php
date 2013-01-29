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
    public $uses = array('Arrendatario', 'ArrendatarioFuneraria', 'ArrendatarioTumba', 'Funeraria', 'Persona', 'Tumba', 'Sanitize');
    
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
        
        //Devolver las opciones de selección de estado del arrendamiento de la tumba
        $this->set('estado', $this->Arrendatario->estado);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Crear nuevo arrendatario con id único
            $this->Arrendatario->create();
            
            //Comprobar si ha introducido algo como DNI
/*            if (empty($this->request->data['Persona']['dni'])) {
                $this->Session->setFlash(__('El DNI es obligatorio.'));
                $this->render();
            }*/
            
            //Comprobar si existe ya una persona con el mismo DNI
            $persona = NULL;
            if ($this->request->data['Persona']['dni'] != "Desconocido") {
                $persona = $this->Arrendatario->Persona->find('first', array(
                 'conditions' => array(
                  'Persona.dni' => $this->request->data['Persona']['dni'],
                 ),
                 'fields' => array(
                  'Persona.id'
                 ),
                 'contain' => array(
                  'Arrendatario' => array(
                   'fields' => array(
                    'Arrendatario.id', 'Arrendatario.persona_id'
                   ),
                  ),
                 ),
                ));
            }
            
            //Comprobar si existe ya una persona con el mismo DNI
            if ($persona) {
                //Comprobar si esta persona es además un arrendatario
                if($persona['Arrendatario']['id']){
                    $this->Session->setFlash(__('Ya existe un arrendatario con este DNI.'));
                    $this->render();
                }
                else{
                    //Establecer claves externas de la persona ya existente para evitar duplicidad
                    $this->request->data['Arrendatario']['persona_id'] = $persona['Persona']['id'];
                    $this->request->data['Persona']['id'] = $persona['Persona']['id'];
                }
            }
            else {
                //Truco del almendruco para evitar errores de validación
                unset($this->Arrendatario->validate['persona_id']);
                $this->request->data['Persona']['dni'] = strtoupper($this->request->data['Persona']['dni']);
            }
            
            //Comprobar si ya había otro arrendatario "Actual" para cada tumba concreta
            if (!empty($this->request->data['ArrendatarioTumba'])) {
                foreach ($this->request->data['ArrendatarioTumba'] as $arrendador) {
                    if ($arrendador['estado'] == "Actual") {
                        
                        $otro = $this->Arrendatario->ArrendatarioTumba->find('first', array(
                         'conditions' => array(
                          'ArrendatarioTumba.tumba_id' => $arrendador['tumba_id'],
                          'ArrendatarioTumba.estado' => "Actual",
                         ),
                         'fields' => array(
                          'ArrendatarioTumba.id', 'ArrendatarioTumba.arrendatario_id', 'ArrendatarioTumba.tumba_id'
                         ),
                         'contain' => array(
                         ),
                        ));
                        
                        if(!empty($otro)) {
                            $this->Session->setFlash(__('Ya hay otro arrendatario actual para la tumba.'));
                            $this->render();
                        }
                    }
                }
            }
            
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
        
        //Devolver las opciones de selección de estado del arrendamiento de la tumba
        $this->set('estado', $this->Arrendatario->estado);
        
        //Asignar id
        $this->Arrendatario->id = $id;
        $this->request->data['Arrendatario']['id'] = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
            throw new NotFoundException(__('El arrendatario especificado no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Persona']['id'] = $this->Session->read('Arrendatario.persona_id');
            $this->request->data['Arrendatario']['persona_id'] = $this->Session->read('Arrendatario.persona_id');
            
            //Comprobar si ha introducido algo como DNI
           /* if (empty($this->request->data['Persona']['dni'])) {
                $this->Session->setFlash(__('El DNI es obligatorio.'));
                $this->render();
            }*/
            
            //Comprobar si existe ya una persona con el mismo DNI
            $persona = NULL;
            if ($this->request->data['Persona']['dni'] != "Desconocido") {
                $persona = $this->Arrendatario->Persona->find('first', array(
                 'conditions' => array(
                  'Persona.dni' => $this->request->data['Persona']['dni'],
                  'Persona.dni' => 'DISTINCT ' . $this->Session->read('Arrendatario.persona_dni'),
                 ),
                 'fields' => array(
                  'Persona.id'
                 ),
                 'contain' => array(
                  'Arrendatario' => array(
                   'fields' => array(
                    'Arrendatario.id', 'Arrendatario.persona_id'
                   ),
                  ),
                 ),
                ));
            }
            
            //Comprobar si existe ya una persona, que además es arrendatario, con el mismo DNI
            if ($persona['Arrendatario']) {
                $this->Session->setFlash(__('Ya existe un arrendatario con este DNI.'));
                $this->render();
            }
else {
unset($this->Persona->validate['dni']['unico']);
}
            
            //Comprobar si ya había otro arrendatario "Actual" para cada tumba concreta
            if (!empty($this->request->data['ArrendatarioTumba'])) {
                foreach ($this->request->data['ArrendatarioTumba'] as $arrendador) {
                    if ($arrendador['estado'] == "Actual") {
                        
                        $otro = $this->Arrendatario->ArrendatarioTumba->find('first', array(
                         'conditions' => array(
                          'ArrendatarioTumba.arrendatario_id' => 'DISTINCT ' . $id,
                          'ArrendatarioTumba.tumba_id' => $arrendador['tumba_id'],
                          'ArrendatarioTumba.estado' => "Actual",
                         ),
                         'fields' => array(
                          'ArrendatarioTumba.id', 'ArrendatarioTumba.arrendatario_id', 'ArrendatarioTumba.tumba_id'
                         ),
                         'contain' => array(
                         ),
                        ));
                        
                        if(!empty($otro)) {
                            $this->Session->setFlash(__('Ya hay otro arrendatario actual para la tumba.'));
                            $this->render();
                        }
                    }
                }
            }
            
            //Guardar y comprobar éxito
            if ($this->Arrendatario->ArrendatarioFuneraria->deleteAll(array('ArrendatarioFuneraria.arrendatario_id' => $id), false, false) && $this->Arrendatario->ArrendatarioTumba->deleteAll(array('ArrendatarioTumba.arrendatario_id' => $id), false, false) && $this->Arrendatario->saveAssociated($this->request->data, $this->opciones_guardado)) {
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
            //Devolver los datos actuales del arrendatario
            $this->request->data = $this->Arrendatario->find('first', array(
             'conditions' => array(
              'Arrendatario.id' => $id
             ),
             'contain' => array(
              'Persona' => array(
               'fields' => array(
                'Persona.id', 'Persona.dni', 'Persona.nombre', 'Persona.apellido1', 'Persona.apellido2', 'Persona.observaciones', 'Persona.nombre_completo'
               ),
              ),
              'ArrendatarioFuneraria' => array(
               'Funeraria' => array(
                'fields' => array(
                 'Funeraria.id', 'Funeraria.nombre'
                ),
               ),
              ),
              'ArrendatarioTumba' => array(
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
              ),
             ),
            ));
            
            //Devolver nombres bonitos para entidades relacionadas
if ($this->request->data['ArrendatarioFuneraria']) {
$i = 0;
foreach ($this->request->data['ArrendatarioFuneraria'] as $funeraria) {
            
                $this->request->data['ArrendatarioFuneraria'][$i]['funeraria_bonita'] = $funeraria['Funeraria']['nombre'];
$this->request->data['ArrendatarioFuneraria'][$i]['funeraria_id'] = $funeraria['funeraria_id'];
unset($this->request->data['ArrendatarioFuneraria'][$i]['Funeraria']);
$i++;
            }
            }

if ($this->request->data['ArrendatarioTumba']) {
$i = 0;
foreach ($this->request->data['ArrendatarioTumba'] as $tumba) {
                $this->request->data['ArrendatarioTumba'][$i]['tumba_bonita'] = $tumba['Tumba']['tipo'] . " - ";
                if ($tumba['Tumba']['Columbario']) {
                    $this->request->data['ArrendatarioTumba'][$i]['tumba_bonita'] .= $tumba['Tumba']['Columbario']['identificador'];
                }
                elseif ($tumba['Tumba']['Nicho']) {
                    $this->request->data['ArrendatarioTumba'][$i]['tumba_bonita'] .= $tumba['Tumba']['Nicho']['identificador'];
                }
                elseif ($tumba['Tumba']['Panteon']) {
                    $this->request->data['ArrendatarioTumba'][$i]['tumba_bonita'] .= $tumba['Tumba']['Panteon']['identificador'];
                }
                elseif ($tumba['Tumba']['Exterior']) {
                    $this->request->data['ArrendatarioTumba'][$i]['tumba_bonita'] .= $tumba['Tumba']['Exterior']['identificador'];
                }


                $this->request->data['ArrendatarioTumba'][$i]['fecha_bonita'] = date('d/m/Y', strtotime($tumba['fecha_arrendamiento']));

unset($this->request->data['ArrendatarioTumba'][$i]['Tumba']);
$i++;
            }
}

            
            //Guardar los datos de sesión del arrendatario
            $this->Session->write('Arrendatario.id', $this->request->data['Arrendatario']['id']);
            $this->Session->write('Arrendatario.persona_id', $this->request->data['Persona']['id']);
            $this->Session->write('Arrendatario.persona_dni', $this->request->data['Persona']['dni']);
            $this->Session->write('Arrendatario.nombre_completo', $this->request->data['Persona']['nombre_completo']);
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
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $arrendatario['Persona']['nombre_completo'] . " - " . $arrendatario['Persona']['dni'];
        $this->pdfConfig['filename'] = "Arrendatario_" . $arrendatario['Persona']['dni'] . ".pdf";
        //$this->pdfConfig['engine'] = 'CakePdf.Tcpdf';
        //Redireccionar para la generación
        
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('arrendatario'));
        
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
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $arrendatario['Persona']['nombre_completo'] . " - " . $arrendatario['Persona']['dni'];
        $this->pdfConfig['download'] = true;
        $this->pdfConfig['filename'] = "Arrendatario_" . $arrendatario['Persona']['dni'] . ".pdf";
        
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
        $this->Arrendatario->id = $id;
        
        //Comprobar si existe el arrendatario
        if (!$this->Arrendatario->exists()) {
            throw new NotFoundException(__('El arrendatario especificado no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Arrendatario->ArrendatarioFuneraria->deleteAll(array('ArrendatarioFuneraria.arrendatario_id' => $id), false, false) && $this->Arrendatario->ArrendatarioTumba->deleteAll(array('ArrendatarioTumba.arrendatario_id' => $id), false, false) && $this->Arrendatario->delete()) {
            $this->Session->setFlash(__('El arrendatario ha sido eliminado correctamente.'));
        }
        else {
            $this->Session->setFlash(__('Ha ocurrido un error mágico. El arrendatario no ha podido ser eliminado.'));
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
         'joins' => array(
          array(
           'table' => 'personas',
           'alias' => 'Persona',
           'type' => 'LEFT',
           'foreignKey' => false,
           'conditions' => array(
            'Persona.id = Arrendatario.persona_id'
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
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
           ),
          ),
         ),
         'fields' => array(
          'Arrendatario.id', 'Arrendatario.persona_id'
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
