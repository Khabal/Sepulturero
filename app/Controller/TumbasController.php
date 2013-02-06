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
    public $uses = array('Tumba', 'Arrendatario', 'ArrendatarioTumba', 'Columbario', 'Difunto', 'DifuntoTraslado', 'Enterramiento', 'Exterior', 'Nicho', 'Panteon', 'Persona', 'Traslado', 'TrasladoTumba', 'Sanitize');
    
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
            'Tumba' => array('id', 'tipo', 'poblacion', 'observaciones'),
            'Columbario' => array('id', 'tumba_id', 'numero_columbario', 'fila', 'patio'),
            'Exterior' => array('id', 'tumba_id'),
            'Nicho' => array('id', 'tumba_id', 'numero_nicho', 'fila', 'patio'),
            'Panteon' => array('id', 'tumba_id', 'numero_panteon', 'familia', 'patio'),
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
         'conditions' => $this->Tumba->parseCriteria($this->params->query),
         'contain' => array(
          'Columbario' => array(
           'fields' => array(
            //'Columbario.id', 'Columbario.tumba_id', 'Columbario.identificador'
           ),
          ),
          'Exterior' => array(
           'fields' => array(
            //'Exterior.id', 'Exterior.tumba_id', 'Exterior.identificador'
           ),
          ),
          'Nicho' => array(
           'fields' => array(
            //'Nicho.id', 'Nicho.tumba_id', 'Nicho.identificador'
           ),
          ),
          'Panteon' => array(
           'fields' => array(
            //'Panteon.id', 'Panteon.tumba_id', 'Panteon.identificador'
           ),
          ),
         ),
         'fields' => array(
          'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion', 'Tumba.id_columbario', 'Tumba.id_exterior', 'Tumba.id_nicho', 'Tumba.id_panteon'
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
                unset($this->Tumba->Columbario->validate['tumba_id']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Nicho") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Nicho->validate['tumba_id']);
                unset($this->request->data['Columbario']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Panteón") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Panteon->validate['tumba_id']);
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Exterior") {
                //Truco del almendruco para guardar una entidad vacía salvo id y clave externa
                $this->request->data['Exterior']['algo'] = "";
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            
            //Guardar y comprobar éxito
            if ($this->Tumba->saveAssociated($this->request->data, $this->opciones_guardado)) {
                $this->Session->setFlash(__('La tumba ha sido guardada correctamente.'));
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
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser guardada.'));
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
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
            throw new NotFoundException(__('La tumba especificada no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con la tumba
        $tumba = $this->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $id
         ),
         'contain' => array(
          'Columbario','Nicho','Panteon','Exterior',
          'ArrendatarioTumba' => array(
           'conditions' => array(
            'ArrendatarioTumba.estado' => "Actual"
           ),
           'Arrendatario' => array(
            'Persona' => array(
             'fields' => array(
              'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
             ),
            ),
            'fields' => array(
             'Arrendatario.id', 'Arrendatario.persona_id', 'Arrendatario.direccion', 'Arrendatario.localidad', 'Arrendatario.provincia', 'Arrendatario.pais', 'Arrendatario.codigo_postal', 'Arrendatario.telefono', 'Arrendatario.correo_electronico'
            ),
           ),
          ),
          'Enterramiento' => array(
           'Licencia' => array(
            'fields' => array(
             'Licencia.id', 'Licencia.identificador'
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
          'Difunto' => array(
           'Persona' => array(
            'fields' => array(
             'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
            ),
           ),
           'fields' => array(
            'Difunto.id', 'Difunto.persona_id', 'Difunto.estado', 'Difunto.fecha_defuncion', 'Difunto.edad_defuncion', 'Difunto.causa_defuncion'
           ),
          ),
          'TrasladoTumba' => array(
           'Traslado' => array(
            'fields' => array(
             'Traslado.id', 'Traslado.fecha', 'Traslado.cementerio_origen', 'Traslado.cementerio_destino', 'Traslado.motivo'
            ),
           ),
           'Tumba' => array(
            'Columbario','Nicho','Panteon','Exterior',
            'fields' => array(
             'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
            ),
           ),
          ),
         ),
        ));
        
        //Ñapa para evitar la recursividad de la entidad sobre la que se busca (Tumba)
        //Cargar toda la información relevante relacionada con los traslados de la tumba
        /*$tumba['TrasladoTumba'] = $this->TrasladoTumba->find('all', array(
         'conditions' => array(
          'TrasladoTumba.tumba_id' => $id
         ),
         'contain' => array(
          'Traslado' => array(
           'fields' => array(
            'Traslado.id', 'Traslado.fecha', 'Traslado.cementerio_origen', 'Traslado.cementerio_destino', 'Traslado.motivo'
           ),
          ),
          'Tumba' => array(
           'Columbario','Nicho','Panteon','Exterior',
           'fields' => array(
            'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
           ),
          ),
         ),
        ));*/
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('tumba'));
        
    }

/**
 * edit method
 *
 * @throws NotFoundException
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
            throw new NotFoundException(__('La tumba especificada no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            //Comprobar el tipo de tumba
            if ($this->request->data['Tumba']['tipo'] == "Columbario") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Columbario->validate['tumba_id']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Nicho") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Nicho->validate['tumba_id']);
                unset($this->request->data['Columbario']);
                unset($this->request->data['Panteon']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Panteón") {
                //Truco del almendruco para evitar errores de validación
                unset($this->Tumba->Panteon->validate['tumba_id']);
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
            }
            elseif ($this->request->data['Tumba']['tipo'] == "Exterior") {
                //Truco del almendruco para guardar una entidad vacía salvo id y clave externa
                $this->request->data['Exterior']['algo'] = "";
                unset($this->request->data['Columbario']);
                unset($this->request->data['Nicho']);
                unset($this->request->data['Panteon']);
            }
            
            //Cargar datos de sesión
            $this->request->data['Tumba']['poblacion'] = $this->Session->read('Tumba.poblacion');
            $this->request->data['Tumba']['id'] = $this->Session->read('Tumba.id');
            if ($this->request->data['Tumba']['tipo'] == $this->Session->read('Tumba.tipo')) {
                if (($this->request->data['Tumba']['tipo'] == "Columbario") && ($this->Session->read('Columbario.id'))) {
                    $this->request->data['Columbario']['id'] = $this->Session->read('Columbario.id');
                }
                elseif (($this->request->data['Tumba']['tipo'] == "Nicho") && ($this->Session->read('Nicho.id'))) {
                    $this->request->data['Nicho']['id'] = $this->Session->read('Nicho.id');
                }
                elseif (($this->request->data['Tumba']['tipo'] == "Panteón") && ($this->Session->read('Panteon.id'))) {
                    $this->request->data['Panteon']['id'] = $this->Session->read('Panteon.id');
                }
                elseif (($this->request->data['Tumba']['tipo'] == "Exterior") && ($this->Session->read('Exterior.id'))) {
                    $this->request->data['Exterior']['id'] = $this->Session->read('Exterior.id');
                }
            }
            
            //Guardar y comprobar éxito
            if ($this->Tumba->saveAssociated($this->request->data)) {
                $this->Session->setFlash(__('La tumba ha sido actualizada correctamente.'));
                //Borrar la tumba anterior en caso de ser de distinto tipo
                if ($this->request->data['Tumba']['tipo'] != $this->Session->read('Tumba.tipo')) {
                    if ($this->Session->read('Tumba.tipo') == "Columbario") {
                        $this->Tumba->Columbario->deleteAll(array('Columbario.tumba_id' => $id), false, false);
                    }
                    elseif ($this->Session->read('Tumba.tipo') == "Nicho") {
                        $this->Tumba->Nicho->deleteAll(array('Nicho.tumba_id' => $id), false, false);
                    }
                    elseif ($this->Session->read('Tumba.tipo') == "Panteón") {
                        $this->Tumba->Panteon->deleteAll(array('Panteon.tumba_id' => $id), false, false);
                    }
                    elseif ($this->Session->read('Tumba.tipo') == "Exterior") {
                        $this->Tumba->Exterior->deleteAll(array('Exterior.tumba_id' => $id), false, false);
                    }
                }
                //Borrar datos de sesión
                $this->Session->delete('Tumba');
                $this->Session->delete('Columbario');
                $this->Session->delete('Nicho');
                $this->Session->delete('Panteon');
                $this->Session->delete('Exterior');
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser actualizada.'));
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
            if ($this->request->data['Columbario']['identificador']) {
                $this->Session->write('Tumba.identificador', $this->request->data['Columbario']['identificador']);
                $this->Session->write('Columbario.id', $this->request->data['Columbario']['id']);
            }
            elseif ($this->request->data['Nicho']['identificador']) {
                $this->Session->write('Tumba.identificador', $this->request->data['Nicho']['identificador']);
                $this->Session->write('Nicho.id', $this->request->data['Nicho']['id']);
            }
            elseif ($this->request->data['Panteon']['identificador']) {
                $this->Session->write('Tumba.identificador', $this->request->data['Panteon']['identificador']);
                $this->Session->write('Panteon.id', $this->request->data['Panteon']['id']);
            }
            elseif ($this->request->data['Exterior']['identificador']) {
                $this->Session->write('Tumba.identificador', $this->request->data['Exterior']['identificador']);
                $this->Session->write('Exterior.id', $this->request->data['Exterior']['id']);
            }
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
        $this->Tumba->id = $id;
        
        //Comprobar si existe la tumba
        if (!$this->Tumba->exists()) {
            throw new NotFoundException(__('La tumba especificada no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Tumba->Columbario->deleteAll(array('Columbario.tumba_id' => $id), false, false) && $this->Tumba->Exterior->deleteAll(array('Exterior.tumba_id' => $id), false, false) && $this->Tumba->Nicho->deleteAll(array('Nicho.tumba_id' => $id), false, false) && $this->Tumba->Panteon->deleteAll(array('Panteon.tumba_id' => $id), false, false) && $this->Tumba->ArrendatarioTumba->deleteAll(array('ArrendatarioTumba.tumba_id' => $id), false, false) && $this->Tumba->delete()) {
            $this->Session->setFlash(__('La tumba ha sido eliminada correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. La tumba no ha podido ser eliminada.'));
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
        $resultados = $this->Tumba->find('all', array(
         'contain' => array(
          'Columbario' => array(
           /*'conditions' => array(
            'Columbario.tumba_id = Tumba.id',
           ),*/
           'fields' => array(
            'Columbario.id', 'Columbario.tumba_id', 'Columbario.localizacion'
           ),
          ),
          'Nicho' => array(
           /*'conditions' => array(
            'Nicho.tumba_id = Tumba.id',
           ),*/
           'fields' => array(
            'Nicho.id', 'Nicho.tumba_id', 'Nicho.localizacion'
           ),
          ),
          'Panteon' => array(
           /*'conditions' => array(
            'Panteon.tumba_id = Tumba.id',
           ),*/
           'fields' => array(
            'Panteon.id', 'Panteon.tumba_id', 'Panteon.localizacion'
           ),
          ),
          'Exterior' => array(
           /*'conditions' => array(
            'Exterior.tumba_id = Tumba.id',
           ),*/
           'fields' => array(
            'Exterior.id', 'Exterior.tumba_id', 'Exterior.localizacion'
           ),
          ),
         ),
         'conditions' => array(
          'OR' => array(
           'Tumba.tipo LIKE' => $palabro,
           'CONCAT(Columbario.numero_columbario," ",Columbario.fila," ",Columbario.patio) LIKE' => $palabro,
           'CONCAT(Nicho.numero_nicho," ",Nicho.fila," ",Nicho.patio) LIKE' => $palabro,
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
