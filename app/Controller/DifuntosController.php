<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Difuntos Controller
 *
 * @property Difunto $Difunto
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class DifuntosController extends AppController {
    
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
    public $modelClass = 'Difunto';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Difuntos';
    
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
    public $methods = array('index', 'nuevo', 'ver', 'buscar', 'editar', 'imprimir', 'pdf');
    
    /**
     * Uses
     *
     * @var array
     */
    public $uses = array('Difunto', 'DifuntoTraslado', 'Enterramiento', 'Persona', 'Traslado', 'Tumba', 'Sanitize');
    
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
            'Difunto' => array('id', 'persona_id', 'tumba_id', 'estado', 'fecha_defuncion', 'edad_defuncion', 'causa_defuncion'),
            'Tumba' => array('poblacion'),
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
         'conditions' => $this->Difunto->parseCriteria($this->params->query),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
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
        );
        
        //Devolver paginación
        $this->set('difuntos', $this->paginate());  
        
    }
    
    /**
     * add method
     *
     * @return void
     */
    public function nuevo() {
        
        //Devolver las opciones de selección de estados del cuerpo
        $this->set('estado', $this->Difunto->estado);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Crear nuevo difunto con id único
            $this->Difunto->create();
            
            //Convertir a mayúsculas el carácter del DNI
            $this->request->data['Persona']['dni'] = strtoupper($this->request->data['Persona']['dni']);
            
            //Comprobar si ha introducido un DNI
            if (!empty($this->request->data['Persona']['dni'])) {
                
                //Buscar si existe ya una persona con el mismo DNI
                $persona = $this->Difunto->Persona->find('first', array(
                 'conditions' => array(
                  'Persona.dni' => $this->request->data['Persona']['dni'],
                 ),
                 'fields' => array(
                  'Persona.id'
                 ),
                 'contain' => array(
                 ),
                ));
                
                //Establecer claves externas de la persona si ya existe para evitar duplicidad
                if(!empty($persona['Persona']['id'])) {
                    $this->request->data['Difunto']['persona_id'] = $persona['Persona']['id'];
                    $this->request->data['Persona']['id'] = $persona['Persona']['id'];
                }
            }print_r($this->request->data);
            $this->Difunto->Persona->set( $this->request->data );
            //Comprobar si se ha introducido una tumba
            if (!empty($this->request->data['Difunto']['tumba_id'])) {
                //Aumentar la población de la tumba
                $this->request->data['Tumba']['id'] = $this->request->data['Difunto']['tumba_id'];
                $this->request->data['Tumba']['población'] = $this->Difunto->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['Difunto']['tumba_id'])) + 1;
            }
            else {
                //Truco del almendruco para evitar errores de validación
                $this->request->data['Difunto']['tumba_id'] = NULL;
            }
            
            //Guardar y comprobar éxito
            if ($this->Difunto->saveAssociated($this->request->data, $this->opciones_guardado)) {
                $this->Session->setFlash(__('El difunto ha sido guardado correctamente.'));
                //Redireccionar según corresponda
                if (isset($this->request->data['guardar_y_nuevo'])) {
                    $this->redirect(array('action' => 'nuevo'));
                }
                else {
                    $this->redirect(array('action' => 'index'));
                }
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El difunto no ha podido ser guardado.'));
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
        $this->Difunto->id = $id;
        
        //Comprobar si existe el difunto
        if (!$this->Difunto->exists()) {
            throw new NotFoundException(__('El difunto especificado no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con el difunto
        $difunto = $this->Difunto->find('first', array(
         'conditions' => array(
          'Difunto.id' => $id
         ),
         'contain' => array(
          'Persona' => array(
           'fields' => array(
            'Persona.id', 'Persona.dni', 'Persona.observaciones', 'Persona.nombre_completo'
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
            'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
           ),
          ),
          'Enterramiento' => array(
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
           'Licencia' => array(
            'fields' => array(
             'Licencia.id', 'Licencia.identificador'
            ),
           ),
           'fields' => array(
            'Enterramiento.id', 'Enterramiento.difunto_id', 'Enterramiento.licencia_id', 'Enterramiento.tumba_id', 'Enterramiento.fecha'
           ),
          ),
          'DifuntoTraslado' => array(
           'Traslado' => array(
            'TrasladoTumba' => array(
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
            'fields' => array(
             'Traslado.id', 'Traslado.fecha', 'Traslado.cementerio_origen', 'Traslado.cementerio_destino', 'Traslado.motivo'
            ),
           ),
          ),
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('difunto'));
        
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
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function editar($id = null) {
        
        //Devolver las opciones de selección de estados del cuerpo
        $this->set('estado', $this->Difunto->estado);
        
        //Asignar id
        $this->Difunto->id = $id;
        
        //Comprobar si existe el difunto
        if (!$this->Difunto->exists()) {
            throw new NotFoundException(__('El difunto especificado no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Convertir a mayúsculas el carácter del DNI
            $this->request->data['Persona']['dni'] = strtoupper($this->request->data['Persona']['dni']);
            
            //Comprobar si ha introducido un DNI
            if (!empty($this->request->data['Persona']['dni'])) {
                
                //Buscar si existe ya una persona con el mismo DNI
                $persona = $this->Difunto->Persona->find('first', array(
                 'conditions' => array(
                  'Persona.dni' => $this->request->data['Persona']['dni'],
                 ),
                 'fields' => array(
                  'Persona.id'
                 ),
                 'contain' => array(
                 ),
                ));
                
                //Establecer claves externas de la persona si ya existe para evitar duplicidad
                if(!empty($persona['Persona']['id'])) {
                    $this->request->data['Difunto']['persona_id'] = $persona['Persona']['id'];
                    $this->request->data['Persona']['id'] = $persona['Persona']['id'];
                }
            
            //Cargar datos de la sesión
            $this->request->data['Difunto']['id'] = $this->Session->read('Difunto.id');
            $this->request->data['Persona']['id'] = $this->Session->read('Difunto.persona_id');
            $this->request->data['Difunto']['persona_id'] = $this->Session->read('Difunto.persona_id');
            
            //Comprobar si se ha introducido una tumba
            if (!empty($this->request->data['Difunto']['tumba_id'])) {echo "kk1 ";
                //Controlar la población de la tumba
                $chapuza = $this->Session->read('Difunto.tumba_id');
                if ($this->request->data['Difunto']['tumba_id'] != $chapuza) {echo "kk2 ";
                    if (!empty($chapuza)) {echo "kk3 ";
                        $this->request->data['Tumba'][0]['id'] = $this->request->data['Difunto']['tumba_id'];
                        $this->request->data['Tumba'][0]['población'] = $this->Difunto->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['Difunto']['tumba_id'])) - 1;
                        $this->request->data['Tumba'][1]['id'] = $chapuza;
                        $this->request->data['Tumba'][1]['población'] = $this->Difunto->Tumba->field('poblacion', array('Tumba.id' => $chapuza)) + 1;
                    }
                    else {echo "kk4 ";
                        $this->request->data['Tumba'][0]['id'] = $this->request->data['Difunto']['tumba_id'];
                        $this->request->data['Tumba'][0]['población'] = $this->Difunto->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['Difunto']['tumba_id'])) + 1;
                    }
                }
            }
            else {
                //Truco del almendruco para evitar errores de validación
                $this->request->data['Difunto']['tumba_id'] = NULL;
                unset($this->Difunto->validate['tumba_id']);
            }
            print_r($this->request->data);//['Difunto']['tumba_id']);//['fecha_defuncion']);
            //Guardar y comprobar éxito
            if ($this->Difunto->saveAssociated($this->request->data, $this->opciones_guardado)) {
                $this->Session->setFlash(__('El difunto ha sido actualizado correctamente.'));
                //Borrar datos de sesión
                $this->Session->delete('Difunto');
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El difunto no ha podido ser actualizado.'));
            }
        }
        else {
            //Devolver los datos actuales del difunto
            $this->request->data = $this->Difunto->find('first', array(
             'conditions' => array(
              'Difunto.id' => $id
             ),
             'contain' => array(
              'Persona' => array(
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
                'Tumba.id', 'Tumba.tipo',
               ),
              ),
             ),
            ));
            
            //Devolver nombres bonitos para entidades relacionadas
            if ($this->request->data['Difunto']['fecha_defuncion']) {
                $this->request->data['Difunto']['fecha_bonita'] = date('d/m/Y', strtotime($this->request->data['Difunto']['fecha_defuncion']));
            }
            
            if ($this->request->data['Tumba']) {
                $this->request->data['Difunto']['tumba_bonita'] = $this->request->data['Tumba']['tipo'] . " - ";
                if ($this->request->data['Tumba']['Columbario']) {
                    $this->request->data['Difunto']['tumba_bonita'] .= $this->request->data['Tumba']['Columbario']['localizacion'];
                }
                elseif ($this->request->data['Tumba']['Exterior']) {
                    $this->request->data['Difunto']['tumba_bonita'] .= $this->request->data['Tumba']['Exterior']['localizacion'];
                }
                elseif ($this->request->data['Tumba']['Nicho']) {
                    $this->request->data['Difunto']['tumba_bonita'] .= $this->request->data['Tumba']['Nicho']['localizacion'];
                }
                elseif ($this->request->data['Tumba']['Panteon']) {
                    $this->request->data['Difunto']['tumba_bonita'] .= $this->request->data['Tumba']['Panteon']['localizacion'];
                }
            }
            
            //Guardar los datos de sesión del difunto
            $this->Session->write('Difunto.id', $this->request->data['Difunto']['id']);
            $this->Session->write('Difunto.persona_id', $this->request->data['Difunto']['persona_id']);
            $this->Session->write('Difunto.nombre_completo', $this->request->data['Persona']['nombre_completo']);
            //if ($this->request->data['Difunto']['tumba_id']) {
                $this->Session->write('Difunto.tumba_id', $this->request->data['Difunto']['tumba_id']);
            //}
        
        }
        
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
        $this->Difunto->id = $id;
        
        //Comprobar si existe el difunto
        if (!$this->Difunto->exists()) {
            throw new NotFoundException(__('El difunto especificado no existe.'));
        }
        
//Comprobar si la persona está asociada a algún arrendatario para en caso contraria eliminarla tmabién
        //Borrar y comprobar éxito
        if ($this->Difunto->delete()) {
            $this->Session->setFlash(__('El difunto ha sido eliminado correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. El difunto no ha podido ser eliminado.'));
        //Redireccionar a index
        $this->redirect(array('action' => 'index'));
        
    }
    
    /**
     * autocomplete method
     *
     * @return JSON array
     */
    public function autocomplete() {
        
        //Término de búsqueda con comodines
        $palabro = '%'.$this->request->query['term'].'%';
        
        //Búsqueda de coincidencias
        $resultados = $this->Difunto->find('all', array(
         'joins' => array(
          array(
           'table' => 'personas',
           'alias' => 'Persona',
           'type' => 'LEFT',
           'foreignKey' => FALSE,
           'conditions' => array(
            'Persona.id = Difunto.persona_id'
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
          'Difunto.id', 'Difunto.persona_id'
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
                array_push($items, array("label" => $resultado['Persona']['nombre_completo'] . " - " . $resultado['Persona']['dni'], "value" => $resultado['Difunto']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }
    
    /**
     * muertos_tumba method
     *
     * @throws ForbiddenException
     * @return JSON array
     */
    public function muertos_tumba() {
        
        //Término de búsqueda con comodines
        $palabro = $this->request->query['term'];
        
        //Búsqueda de coincidencias
        $resultados = $this->Difunto->Tumba->find('first', array(
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
        $i = 0;
        $items = array();
        
        if (!empty($resultados)) {
            foreach($resultados['Difunto'] as $resultado) {
                array_push($items, array("label" => $resultado['Persona']['nombre_completo'] . " - " . $resultado['Persona']['dni'], "value" => $resultado['id']));
            }
        }
        
        $this->set('moridos', $items);
        
        $this->layout = 'ajax';
        $this->render('kk');
    }

}
