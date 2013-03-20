<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Tumbas Controller
 *
 * @property Tumba $Tumba
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class TumbasController extends AppController {
    
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
    public $modelClass = 'Tumba';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Tumbas';
    
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
    public $uses = array('Tumba', 'Arrendamiento', 'Columbario', 'Difunto', 'Exterior', 'MovimientoTumba', 'Nicho', 'Panteon', 'Sanitize');
    
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
        'deep' => true,
        'fieldList' => array(
            'Tumba' => array('id', 'tipo', 'poblacion', 'observaciones'),
            'Columbario' => array('id', 'tumba_id', 'numero_columbario', 'letra', 'fila', 'patio'),
            'Exterior' => array('id', 'tumba_id'),
            'Nicho' => array('id', 'tumba_id', 'numero_nicho', 'letra', 'fila', 'patio'),
            'Panteon' => array('id', 'tumba_id', 'numero_panteon', 'familia', 'patio'),
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
         'conditions' => $this->Tumba->parseCriteria($this->params->query),
         'contain' => array(
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
         ),
        );
        
        //Devolver paginación
        $this->set('tumbas', $this->paginate());
        
    }
    
    /**
     * add method
     *
     * @return void
     */
    public function nuevo() {
        
        //Devolver las opciones de selección de tipo de tumba
        $this->set('tipo', $this->Tumba->tipo);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Crear nueva tumba con id único
            $this->Tumba->create();
            
            //Asignar población inicial de la tumba
            $this->request->data['Tumba']['poblacion'] = 0;
            
            //Comprobar el tipo de tumba
            if ($this->request->data['Tumba']['tipo'] == "Columbario") {
                //Truco del almendruco para evitar errores de validación
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
                //Convertir a mayúsculas el carácter de la letra
                $this->request->data['Columbario']['letra'] = strtoupper($this->request->data['Columbario']['letra']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Exterior") {
                //Truco del almendruco para guardar una entidad vacía salvo id y clave externa
                $this->request->data['Exterior']['algo'] = "";
                //Truco del almendruco para evitar errores de validación
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Nicho") {
                //Truco del almendruco para evitar errores de validación
                unset($this->request->data['Columbario']);
                unset($this->request->data['Panteon']);
                //Convertir a mayúsculas el carácter de la letra
                $this->request->data['Nicho']['letra'] = strtoupper($this->request->data['Nicho']['letra']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Panteón") {
                //Truco del almendruco para evitar errores de validación
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
            }
            
            //Validar los datos introducidos
            if ($this->Tumba->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Guardar y comprobar éxito
                if ($this->Tumba->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('La tumba ha sido guardada correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
                        $this->redirect(array('action' => 'nuevo'));
                    }
                    else {
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser guardada.'));
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
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
             $this->Session->setFlash(__('La tumba especificada no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la tumba
        $tumba = $this->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $id
         ),
         'contain' => array(
          'Columbario', 'Exterior', 'Nicho', 'Panteon',
          'Arrendamiento' => array(
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
          ),
          'Difunto' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Difunto.id', 'Difunto.persona_id', 'Difunto.estado', 'Difunto.fecha_defuncion', 'Difunto.edad', 'Difunto.causa_fallecimiento', 'Difunto.certificado_defuncion'
           ),
          ),
          'MovimientoTumba' => array(
           'Movimiento' => array(
            'MovimientoTumba' => array(
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
               'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
              ),
             ),
            ),
            'fields' => array(
             'Movimiento.id', 'Movimiento.tipo', 'Movimiento.fecha', 'Movimiento.viajeros', 'Movimiento.cementerio_origen', 'Movimiento.cementerio_destino', 'Movimiento.motivo'
            ),
           ),
           'fields' => array(
            'MovimientoTumba.id', 'MovimientoTumba.movimiento_id', 'MovimientoTumba.tumba_id',
           ),
          ),
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('tumba'));
        
    }
    
    /**
     * find method
     *
     * @return void
     */
    public function buscar() {
        
        //Devolver las opciones de selección de tipo de tumba
        $this->set('tipo', $this->Tumba->tipo);
        
        //Eliminar reglas de validación
        unset($this->Tumba->validate);
        
    }
    
    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function editar($id = null) {
        
        //Devolver las opciones de selección de tipo de tumba
        $this->set('tipo', $this->Tumba->tipo);
        
        //Asignar id
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
             $this->Session->setFlash(__('La tumba especificada no existe.'));
             $this->redirect(array('action' => 'index'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Tumba']['id'] = $id;
            $this->request->data['Tumba']['poblacion'] = $this->Session->read('Tumba.poblacion');

            //Comprobar el tipo de tumba
            if ($this->request->data['Tumba']['tipo'] == "Columbario") {
                //Truco del almendruco para evitar errores de validación
                $this->request->data['Tumba']['columbario_id'] = $this->Session->read('Tumba.columbario_id');
                unset($this->request->data['Exterior']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
                //Convertir a mayúsculas el carácter de la letra
                $this->request->data['Columbario']['letra'] = strtoupper($this->request->data['Columbario']['letra']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Exterior") {
                //Truco del almendruco para guardar una entidad vacía salvo id y clave externa
                $this->request->data['Exterior']['algo'] = "";
                //Truco del almendruco para evitar errores de validación
                $this->request->data['Tumba']['exterior_id'] = $this->Session->read('Tumba.exterior_id');
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Nicho") {
                //Truco del almendruco para evitar errores de validación
                $this->request->data['Tumba']['nicho_id'] = $this->Session->read('Tumba.nicho_id');
                unset($this->request->data['Columbario']);
                unset($this->request->data['Exterior']);
                unset($this->request->data['Panteon']);
                //Convertir a mayúsculas el carácter de la letra
                $this->request->data['Nicho']['letra'] = strtoupper($this->request->data['Nicho']['letra']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Panteón") {
                //Truco del almendruco para evitar errores de validación
                $this->request->data['Tumba']['panteon_id'] = $this->Session->read('Tumba.panteon_id');
                unset($this->request->data['Columbario']);
                unset($this->request->data['Exterior']);
                unset($this->request->data['Nicho']);
            }
            
            //Validar los datos introducidos
            if ($this->Tumba->saveAll($this->request->data, array('validate' => 'only'))) {
                
                //Borrar tumba antigua del tipo correspondiente
                if ($this->Session->read('Tumba.tipo') == "Columbario") {
                    $this->Tumba->Columbario->delete($this->Session->read('Tumba.columbario_id'));
                }
                elseif ($this->Session->read('Tumba.tipo') == "Exterior") {
                    $this->Tumba->Exterior->delete($this->Session->read('Tumba.exterior_id'));
                }
                elseif ($this->Session->read('Tumba.tipo') == "Nicho") {
                    $this->Tumba->Nicho->delete($this->Session->read('Tumba.nicho_id'));
                }
                elseif ($this->Session->read('Tumba.tipo') == "Panteón") {
                    $this->Tumba->Panteon->delete($this->Session->read('Tumba.panteon_id'));
                }
                
                //Guardar y comprobar éxito
                if ($this->Tumba->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('La tumba ha sido actualizada correctamente.'));
                    //Borrar datos de sesión
                    $this->Session->delete('Tumba');
                    //Redireccionar a index
                    $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser actualizada.'));
                }
            }
            else {
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
            }
        }
        else {
            //Devolver los datos actuales de la tumba
            $this->request->data = $this->Tumba->find('first', array(
             'conditions' => array(
              'Tumba.id' => $id
             ),
             'contain' => array(
              'Columbario','Nicho','Panteon','Exterior',
             ),
            ));
            
            //Guardar los datos de sesión de la tumba
            $this->Session->write('Tumba.id', $this->request->data['Tumba']['id']);
            $this->Session->write('Tumba.tipo', $this->request->data['Tumba']['tipo']);
            $this->Session->write('Tumba.poblacion', $this->request->data['Tumba']['poblacion']);
            if (!empty($this->request->data['Columbario']['id'])) {
                $this->Session->write('Tumba.localizacion', $this->request->data['Columbario']['localizacion']);
                $this->Session->write('Tumba.columbario_id', $this->request->data['Columbario']['id']);
            }
            elseif (!empty($this->request->data['Exterior']['id'])) {
                $this->Session->write('Tumba.localizacion', $this->request->data['Exterior']['localizacion']);
                $this->Session->write('Tumba.exterior_id', $this->request->data['Exterior']['id']);
            }
            elseif (!empty($this->request->data['Nicho']['id'])) {
                $this->Session->write('Tumba.localizacion', $this->request->data['Nicho']['localizacion']);
                $this->Session->write('Tumba.nicho_id', $this->request->data['Nicho']['id']);
            }
            elseif (!empty($this->request->data['Panteon']['id'])) {
                $this->Session->write('Tumba.localizacion', $this->request->data['Panteon']['localizacion']);
                $this->Session->write('Tumba.panteon_id', $this->request->data['Panteon']['id']);
            }

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
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
            $this->Session->setFlash(__('La tumba especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la tumba
        $tumba = $this->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $id
         ),
         'contain' => array(
          'Columbario', 'Exterior', 'Nicho', 'Panteon',
          'Arrendamiento' => array(
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
          ),
          'Difunto' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Difunto.id', 'Difunto.persona_id', 'Difunto.estado', 'Difunto.fecha_defuncion', 'Difunto.edad', 'Difunto.causa_fallecimiento', 'Difunto.certificado_defuncion'
           ),
          ),
          'MovimientoTumba' => array(
           'Movimiento' => array(
            'MovimientoTumba' => array(
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
               'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
              ),
             ),
            ),
            'fields' => array(
             'Movimiento.id', 'Movimiento.tipo', 'Movimiento.fecha', 'Movimiento.viajeros', 'Movimiento.cementerio_origen', 'Movimiento.cementerio_destino', 'Movimiento.motivo'
            ),
           ),
           'fields' => array(
            'MovimientoTumba.id', 'MovimientoTumba.movimiento_id', 'MovimientoTumba.tumba_id',
           ),
          ),
         ),
        ));
        
        //Obtener localización de la tumba
        $localizacion = "";
        if (!empty($tumba['Columbario']['localizacion'])) {
            $localizacion = $tumba['Columbario']['localizacion'];
        }
        elseif(!empty($tumba['Exterior']['localizacion'])) {
            $localizacion = $tumba['Exterior']['localizacion'];
        }
        elseif(!empty($tumba['Nicho']['localizacion'])) {
            $localizacion = $tumba['Nicho']['localizacion'];
        }
        elseif(!empty($tumba['Panteon']['localizacion'])) {
            $localizacion = $tumba['Panteon']['localizacion'];
        }
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $tumba['Tumba']['tipo'] . " - " . $localizacion;
        $this->pdfConfig['filename'] = "Tumba_" . $tumba['Tumba']['tipo'] . $localizacion . ".pdf";
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('tumba'));
        
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
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
            $this->Session->setFlash(__('La tumba especificada no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con la tumba
        $tumba = $this->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $id
         ),
         'contain' => array(
          'Columbario', 'Exterior', 'Nicho', 'Panteon',
          'Arrendamiento' => array(
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
          ),
          'Difunto' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Difunto.id', 'Difunto.persona_id', 'Difunto.estado', 'Difunto.fecha_defuncion', 'Difunto.edad', 'Difunto.causa_fallecimiento', 'Difunto.certificado_defuncion'
           ),
          ),
          'MovimientoTumba' => array(
           'Movimiento' => array(
            'MovimientoTumba' => array(
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
               'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
              ),
             ),
            ),
            'fields' => array(
             'Movimiento.id', 'Movimiento.tipo', 'Movimiento.fecha', 'Movimiento.viajeros', 'Movimiento.cementerio_origen', 'Movimiento.cementerio_destino', 'Movimiento.motivo'
            ),
           ),
           'fields' => array(
            'MovimientoTumba.id', 'MovimientoTumba.movimiento_id', 'MovimientoTumba.tumba_id',
           ),
          ),
         ),
        ));
        
        //Obtener localización de la tumba
        $localizacion = "";
        if (!empty($tumba['Columbario']['localizacion'])) {
            $localizacion = $tumba['Columbario']['localizacion'];
        }
        elseif(!empty($tumba['Exterior']['localizacion'])) {
            $localizacion = $tumba['Exterior']['localizacion'];
        }
        elseif(!empty($tumba['Nicho']['localizacion'])) {
            $localizacion = $tumba['Nicho']['localizacion'];
        }
        elseif(!empty($tumba['Panteon']['localizacion'])) {
            $localizacion = $tumba['Panteon']['localizacion'];
        }
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $tumba['Tumba']['tipo'] . " - " . $localizacion;
        $this->pdfConfig['filename'] = "Tumba_" . $tumba['Tumba']['tipo'] . $localizacion . ".pdf";
        $this->pdfConfig['download'] = true;
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('tumba'));
        
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
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
            throw new NotFoundException(__('La tumba especificada no existe.'));
        }
        
        //Buscar si la tumba está en uso en algún arrendamiento
        $arrendamiento = $this->Tumba->Arrendamiento->find('first', array(
         'conditions' => array(
          'Arrendamiento.tumba_id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Buscar si la tumba está en uso por algún usuario difunto
        $difunto = $this->Tumba->Difunto->find('first', array(
         'conditions' => array(
          'Difunto.tumba_id' => $id
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si la tumba está en uso en arrendamientos
        if (!empty($arrendamiento)) {
            $this->Session->setFlash(__('La tumba especificada está asociada a un arrendamiento.'));
        }
        //Comprobar si la tumba está en uso en difuntos
        if (!empty($difunto)) {
            $this->Session->setFlash(__('La tumba especificada no está vacía, contiene usuarios satisfechos.'));
        }
        else {
            //Borrar y comprobar éxito
            if ($this->Tumba->delete()) {
                $this->Session->setFlash(__('La tumba ha sido eliminada correctamente.'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser eliminado.'));
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
        $resultados = $this->Tumba->find('all', array(
         'contain' => array(
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
         ),
         'conditions' => array(
          'OR' => array(
           'Tumba.tipo LIKE' => $palabro,
           'CONCAT(Columbario.numero_columbario, Columbario.letra," ",Columbario.fila," ",Columbario.patio) LIKE' => $palabro,
           'CONCAT(Nicho.numero_nicho, Nicho.letra," ",Nicho.fila," ",Nicho.patio) LIKE' => $palabro,
           'CONCAT(Panteon.familia," ",Panteon.numero_panteon," ",Panteon.patio) LIKE' => $palabro,
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
          $identificador = "";
          if ($resultado['Tumba']['tipo'] == "Columbario") {
           $identificador = $resultado['Columbario']['localizacion'];
          }
          elseif ($resultado['Tumba']['tipo'] == "Nicho") {
           $identificador = $resultado['Nicho']['localizacion'];
          }
          elseif ($resultado['Tumba']['tipo'] == "Panteón") {
           $identificador = $resultado['Panteon']['localizacion'];
          }
          elseif ($resultado['Tumba']['tipo'] == "Exterior") {
           $identificador = $resultado['Exterior']['localizacion'];
          }
          array_push($items, array("label" => $resultado['Tumba']['tipo'] . " - " . $identificador, "value" => $resultado['Tumba']['id']));
         }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }
    
    /**
     * generar method
     *
     * @return void
     */
    public function generar(){
        
        //Devolver las opciones de selección de tipo de tumba
        $this->set('tipo', $this->Tumba->tipo);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Procesar y validar datos del formulario
            if(!ctype_digit($this->request->data['Tumba']['n_tumbas'])){
                $this->Session->setFlash(__('El número de tumbas por fila debe ser un entero.'));
                $this->render();
            }
            elseif(!ctype_digit($this->request->data['Tumba']['n_filas'])){
                $this->Session->setFlash(__('El número de filas debe ser un entero.'));
                $this->render();
            }
            elseif(!ctype_digit($this->request->data['Tumba']['n_patio'])){
                $this->Session->setFlash(__('El número de patio debe ser un entero.'));
                $this->render();
            }
            
            //Preparar datos a guardar
            $valores = array();
            
            if ($this->request->data['Tumba']['t_tumba'] == "Columbario") {
                $valores['Columbario']['patio'] = $this->request->data['Tumba']['n_patio'];
            }
            elseif ($this->request->data['Tumba']['t_tumba'] == "Nicho") {
                $valores['Nicho']['patio'] = $this->request->data['Tumba']['n_patio'];
            }
            else {
                $this->Session->setFlash(__('Tipo de tumba no valdío para esta acción'));
                $this->render();
            }
            
            $valores['Tumba']['tipo'] = $this->request->data['Tumba']['t_tumba'];
            $valores['Tumba']['poblacion'] = 0;
            
            unset($this->request->data['Tumba']['t_tumba']);
            unset($this->request->data['Tumba']['n_patio']);
            
            //Contadores del bucle
            $contador_tumbas = (int) $this->request->data['Tumba']['n_tumbas'];
            $contador_filas = (int) $this->request->data['Tumba']['n_filas'];
            
            unset($this->request->data['Tumba']['n_tumbas']);
            unset($this->request->data['Tumba']['n_filas']);
            
            //Bucles de guardado estilo clásico
            for ($i = 1; $i <= $contador_filas; $i++) {
                for ($j = 1; $j <= $contador_tumbas; $j++) {
                    
                    //Crear nueva tumba con id único
                    $this->Tumba->create();
                    
                    //Comprobar tipo de tumba de nuevo
                    if ($valores['Tumba']['tipo'] == "Columbario") {
                        $valores['Columbario']['numero_columbario'] = ($i - 1) * $contador_tumbas + $j;
                        $valores['Columbario']['fila'] = $i;
                    }
                    elseif ($valores['Tumba']['tipo'] == "Nicho") {
                        $valores['Nicho']['numero_nicho'] = ($i - 1) * $contador_tumbas + $j;
                        $valores['Nicho']['fila'] = $i;
                    }
                    else {
                        $this->Session->setFlash(__('Tipo de tumba no váldio'));
                        $this->render();
                    }
                    
                    //Guardar y comprobar éxito
                    if ($this->Tumba->saveAssociated($valores, $this->opciones_guardado)) {
                        
                    }
                    else {
                        $this->Session->setFlash(__('Ha ocurrido un error mágico al introducir las tumbas.'));
                        $this->render();
                    }
                    
                }
            }
            
            $this->Session->setFlash(__('Proceso de introducción de tumbas completado con éxito.'));
            
        }
        
    }
    
    /**
     * muertos_tumba method
     *
     * @return JSON array
     */
    public function muertos_tumba() {
        
        //Término de búsqueda con comodines
        $palabro = $this->request->query['term'];
        
        //Búsqueda de coincidencias
        $resultados = $this->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $palabro,
         ),
         'contain' => array(
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
         ),
         'fields' => array(
          'Tumba.id'
         ),
        ));
        
        //Procesamiento del resultado de la búsqueda
        $items = array();
        
        if (empty($resultados)) {
            //array_push($items, array("label"=>"No hay difuntos en la tumba", "value"=>""));
        }
        else {
            foreach($resultados['Difunto'] as $resultado) {
                array_push($items, array("label" => $resultado['Persona']['nombre_completo'] . " - " . $resultado['Persona']['dni'], "value" => $resultado['id']));
            }
        }

        //$this->autoRender = false;
        
        /*echo*/ json_encode($items);$this->set('moridos', $items);
        
        $this->layout = 'ajax';$this->render('ocupantes');
    }
    
}
