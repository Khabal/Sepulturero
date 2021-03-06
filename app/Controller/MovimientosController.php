<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Movimientos Controller
 *
 * @property Movimiento $Movimiento
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class MovimientosController extends AppController {
    
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
    public $modelClass = 'Movimiento';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Movimientos';
    
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
    public $uses = array('Movimiento', 'Difunto', 'DifuntoMovimiento', 'MovimientoTumba', 'Tumba', 'Sanitize');
    
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
    public $presetVars = array( //Overriding and extending the model defaults
        'clave'=> array(
            'encode' => true,
            'model' => 'Movimiento',
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
        'deep' => true,
        'fieldList' => array(
            'Movimiento' => array('id', 'tipo', 'fecha', 'motivo', 'viajeros', 'cementerio_origen', 'cementerio_destino', 'documental', 'observaciones'),
            'DifuntoMovimiento' => array('id', 'difunto_id', 'movimiento_id'),
            'MovimientoTumba' => array('id', 'movimiento_id', 'tumba_id', 'origen_destino'),
            'Difunto' => array('id', 'tumba_id'),
            'Tumba' => array('id', 'poblacion'),
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
         'conditions' => $this->Movimiento->parseCriteria($this->params->query),
         'contain' => array(
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
             'Tumba.id', 'Tumba.tipo'
            ),
           ),
          ),
         ),
         'paramType' => 'querystring'
        );
        
        //Devolver paginación
        $this->set('movimientos', $this->paginate());
        
    }
    
    /**
     * add method
     *
     * @return void
     */
    public function nuevo() {
        
        //Devolver las opciones de selección de tipos de movimientos
        $this->set('tipo', $this->Movimiento->tipo);
        
        //Comprobar si está enviando el formulario
        if ($this->request->is('post')) {
            
            //Variable auxiliar multpropósito
            $i = 0;
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Crear nuevo traslado con id único
            $this->Movimiento->create();
            
            //Operaciones para el tipo de movimiento exhumación
            if ($this->request->data['Movimiento']['tipo'] == "Exhumación") {
                
                //Cambiar la tumba actual a los difuntos que se mueven
                if (!empty($this->request->data['DifuntoMovimiento'])) {
                    $i = 0;
                    foreach ($this->request->data['DifuntoMovimiento'] as $morido) {
                        if (!empty($morido['difunto_id'])) {
                            $this->request->data['DifuntoMovimiento'][$i]['tipo'] = $this->request->data['Movimiento']['tipo'];
                            $this->request->data['DifuntoMovimiento'][$i]['documental'] = $this->request->data['Movimiento']['documental'];
                            //Si un movimiento de mentira(documental) no se cambian los datos de los difuntos
                            if ($this->request->data['Movimiento']['documental'] == 0) {
                                $this->request->data['DifuntoMovimiento'][$i]['Difunto']['id'] = $morido['difunto_id'];
                                $this->request->data['DifuntoMovimiento'][$i]['Difunto']['tumba_id'] = null;
                            }
                        }
                        else {
                            unset($this->request->data['DifuntoMovimiento'][$i]);
                        }
                        $i++;
                    }
                }
                
                //Obtener los difuntos que van a ser movidos
                $numero_muertos = count($this->request->data['DifuntoMovimiento']);
                $this->request->data['Movimiento']['viajeros'] = $numero_muertos;
                
                //Controlar la población de la tumba de origen
                $this->request->data['MovimientoTumba'][0]['origen_destino'] = "Origen";
                //Si un movimiento de mentira(documental) no se cambian la población de las tumbas
                if ($this->request->data['Movimiento']['documental'] == 0) {
                    $this->request->data['MovimientoTumba'][0]['Tumba']['id'] = $this->request->data['MovimientoTumba'][0]['tumba_id'];
                    $this->request->data['MovimientoTumba'][0]['Tumba']['poblacion'] = $this->Movimiento->MovimientoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['MovimientoTumba'][0]['tumba_id'])) - $numero_muertos;
                }
                unset($this->request->data['Tumba'][0]);
                
                //Controlar la población de la tumba de destino
                $this->request->data['Movimiento']['cementerio_destino'] = null;
                unset($this->request->data['MovimientoTumba'][1]);
                unset($this->request->data['Tumba'][1]);
                
            }
            
            //Operaciones para el tipo de movimiento inhumación
            elseif ($this->request->data['Movimiento']['tipo'] == "Inhumación") {
                
                //Comprobar si hay difuntos vacíos y eliminarlos
                if (isset($this->request->data['DifuntoMovimiento'])) {
                    $i = 0;
                    foreach ($this->request->data['DifuntoMovimiento'] as $difunto) {
                        if (empty($difunto['difunto_bonito'])) {
                            unset($this->request->data['DifuntoMovimiento'][$i]);
                        }
                        $i++;
                    }
                }
                
                //Comprobar si hay difuntos repetidos y eliminarlos
                if (!empty($this->request->data['DifuntoMovimiento'])) {
                    $this->request->data['DifuntoMovimiento'] = array_unique($this->request->data['DifuntoMovimiento']);
                    $this->request->data['DifuntoMovimiento'] = array_values($this->request->data['DifuntoMovimiento']);
                }
                
                //Cambiar la tumba actual a los difuntos que se mueven
                if (!empty($this->request->data['DifuntoMovimiento'])) {
                    $i = 0;
                    foreach ($this->request->data['DifuntoMovimiento'] as $morido) {
                        if (!empty($morido['difunto_id'])) {
                            $this->request->data['DifuntoMovimiento'][$i]['tipo'] = $this->request->data['Movimiento']['tipo'];
                            $this->request->data['DifuntoMovimiento'][$i]['documental'] = $this->request->data['Movimiento']['documental'];
                            //Si un movimiento de mentira(documental) no se cambian los datos de los difuntos
                            if ($this->request->data['Movimiento']['documental'] == 0) {
                                $this->request->data['DifuntoMovimiento'][$i]['Difunto']['id'] = $morido['difunto_id'];
                                $this->request->data['DifuntoMovimiento'][$i]['Difunto']['tumba_id'] = $this->request->data['MovimientoTumba'][1]['tumba_id'];
                            }
                        }
                        else {
                            unset($this->request->data['DifuntoMovimiento'][$i]);
                        }
                        $i++;
                    }
                }
                
                //Obtener los difuntos que van a ser movidos
                $numero_muertos = count($this->request->data['DifuntoMovimiento']);
                $this->request->data['Movimiento']['viajeros'] = $numero_muertos;
                
                //Controlar la población de la tumba de origen
                $this->request->data['Movimiento']['cementerio_origen'] = null;
                unset($this->request->data['MovimientoTumba'][0]);
                unset($this->request->data['Tumba'][0]);
                
                //Controlar la población de la tumba de destino
                $this->request->data['MovimientoTumba'][1]['origen_destino'] = "Destino";
                //Si un movimiento de mentira(documental) no se cambian la población de las tumbas
                if ($this->request->data['Movimiento']['documental'] == 0) {
                    $this->request->data['MovimientoTumba'][1]['Tumba']['id'] = $this->request->data['MovimientoTumba'][1]['tumba_id'];
                    $this->request->data['MovimientoTumba'][1]['Tumba']['poblacion'] = $this->Movimiento->MovimientoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['MovimientoTumba'][1]['tumba_id'])) + $numero_muertos;
                }
                unset($this->request->data['Tumba'][1]);
                
            }
            
            //Operaciones para el tipo de movimiento traslado
            elseif ($this->request->data['Movimiento']['tipo'] == "Traslado") {
                
                //Cambiar la tumba actual a los difuntos que se mueven
                if (!empty($this->request->data['DifuntoMovimiento'])) {
                    $i = 0;
                    foreach ($this->request->data['DifuntoMovimiento'] as $morido) {
                        if (!empty($morido['difunto_id'])) {
                            $this->request->data['DifuntoMovimiento'][$i]['tipo'] = $this->request->data['Movimiento']['tipo'];
                            $this->request->data['DifuntoMovimiento'][$i]['documental'] = $this->request->data['Movimiento']['documental'];
                            //Si un movimiento de mentira(documental) no se cambian los datos de los difuntos
                            if ($this->request->data['Movimiento']['documental'] == 0) {
                                $this->request->data['DifuntoMovimiento'][$i]['Difunto']['id'] = $morido['difunto_id'];
                                $this->request->data['DifuntoMovimiento'][$i]['Difunto']['tumba_id'] = $this->request->data['MovimientoTumba'][1]['tumba_id'];
                            }
                        }
                        else {
                            unset($this->request->data['DifuntoMovimiento'][$i]);
                        }
                        $i++;
                    }
                }
                
                //Obtener los difuntos que van a ser movidos
                $numero_muertos = count($this->request->data['DifuntoMovimiento']);
                $this->request->data['Movimiento']['viajeros'] = $numero_muertos;
                
                //Controlar la población de la tumba de origen
                $this->request->data['MovimientoTumba'][0]['origen_destino'] = "Origen";
                //Si un movimiento de mentira(documental) no se cambian la población de las tumbas
                if ($this->request->data['Movimiento']['documental'] == 0) {
                    $this->request->data['MovimientoTumba'][0]['Tumba']['id'] = $this->request->data['MovimientoTumba'][0]['tumba_id'];
                    $this->request->data['MovimientoTumba'][0]['Tumba']['poblacion'] = $this->Movimiento->MovimientoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['MovimientoTumba'][0]['tumba_id'])) - $numero_muertos;
                }
                
                //Controlar la población de la tumba de destino
                $this->request->data['MovimientoTumba'][1]['origen_destino'] = "Destino";
                //Si un movimiento de mentira(documental) no se cambian la población de las tumbas
                if ($this->request->data['Movimiento']['documental'] == 0) {
                    $this->request->data['MovimientoTumba'][1]['Tumba']['id'] = $this->request->data['MovimientoTumba'][1]['tumba_id'];
                    $this->request->data['MovimientoTumba'][1]['Tumba']['poblacion'] = $this->Movimiento->MovimientoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['MovimientoTumba'][1]['tumba_id'])) + $numero_muertos;
                }
                
            }
            
            //Trucos surtido para la validadción
            unset($this->Movimiento->MovimientoTumba->Tumba->validate);
            unset($this->Movimiento->DifuntoMovimiento->Difunto->validate);

            //Validar los datos introducidos
            if ($this->Movimiento->saveAll($this->request->data, array('validate' => 'only', 'deep' => true))) {
                
                //Guardar y comprobar éxito
                if ($this->Movimiento->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El movimiento ha sido guardado correctamente.'));
                    //Redireccionar según corresponda
                    if (isset($this->request->data['guardar_y_nuevo'])) {
                        $this->redirect(array('action' => 'nuevo'));
                    }
                    else {
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El movimiento no ha podido ser guardado.'));
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
        $this->Movimiento->id = $id;
        
        //Comprobar si existe el movimiento
        if (!$this->Movimiento->exists()) {
            $this->Session->setFlash(__('El movimiento especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el movimiento
        $movimiento = $this->Movimiento->find('first', array(
         'conditions' => array(
          'Movimiento.id' => $id
         ),
         'contain' => array(
          'DifuntoMovimiento' => array(
           'Difunto' => array(
            'Persona' => array(
             'fields' => array(
              'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
             ),
            ),
            'fields' => array(
             'Difunto.id', 'Difunto.persona_id', 'Difunto.estado'
            ),
           ),
          ),
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
         ),
        ));
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('movimiento'));
        
    }
    
    /**
     * find method
     *
     * @return void
     */
    public function buscar() {
        
        //Devolver las opciones de selección de tipos de movimientos
        $this->set('tipo', $this->Movimiento->tipo);
        
        //Eliminar reglas de validación
        unset($this->Movimiento->validate);
        
    }
    
    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function editar($id = null) {
        
        //Devolver las opciones de selección de tipos de movimientos
        $this->set('tipo', $this->Movimiento->tipo);
        
        //Asignar id
        $this->Movimiento->id = $id;
        
        //Comprobar si existe el movimiento
        if (!$this->Movimiento->exists()) {
            $this->Session->setFlash(__('El movimiento especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            
            //Variable auxiliar multpropósito
            $i = 0;
            
            //Desinfectar los datos recibidos del formulario
            Sanitize::clean($this->request->data);
            
            //Cargar datos de la sesión
            $this->request->data['Movimiento']['id'] = $id;
            
            //Operaciones para el tipo de movimiento exhumación
            if ($this->request->data['Movimiento']['tipo'] == "Exhumación") {
                
                //Cambiar la tumba actual a los difuntos que se mueven
                if (!empty($this->request->data['DifuntoMovimiento'])) {
                    $i = 0;
                    foreach ($this->request->data['DifuntoMovimiento'] as $morido) {
                        if (!empty($morido['difunto_id'])) {
                            $this->request->data['DifuntoMovimiento'][$i]['tipo'] = $this->request->data['Movimiento']['tipo'];
                            $this->request->data['DifuntoMovimiento'][$i]['Difunto']['id'] = $morido['difunto_id'];
                            $this->request->data['DifuntoMovimiento'][$i]['Difunto']['tumba_id'] = null;
                            $i++;
                        }
                    }
                }
                
                //Obtener los difuntos que van a ser movidos
                $numero_muertos = $i;
                $this->request->data['Movimiento']['viajeros'] = $numero_muertos;
                
                //Controlar la población de la tumba de origen
                $this->request->data['MovimientoTumba'][0]['origen_destino'] = "Origen";
                $this->request->data['MovimientoTumba'][0]['Tumba']['id'] = $this->request->data['MovimientoTumba'][0]['tumba_id'];
                $this->request->data['MovimientoTumba'][0]['Tumba']['poblacion'] = $this->Movimiento->MovimientoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['MovimientoTumba'][0]['tumba_id'])) - $numero_muertos;
                unset($this->request->data['Tumba'][0]);
                
                //Controlar la población de la tumba de destino
                $this->request->data['Movimiento']['cementerio_destino'] = null;
                unset($this->request->data['MovimientoTumba'][1]);
                unset($this->request->data['Tumba'][1]);
                
            }
            
            //Operaciones para el tipo de movimiento inhumación
            elseif ($this->request->data['Movimiento']['tipo'] == "Inhumación") {
                
                //Comprobar si hay difuntos vacíos y eliminarlos
                if (isset($this->request->data['DifuntoMovimiento'])) {
                    $i = 0;
                    foreach ($this->request->data['DifuntoMovimiento'] as $difunto) {
                        if (empty($difunto['difunto_bonito'])) {
                            unset($this->request->data['DifuntoMovimiento'][$i]);
                        }
                        $i++;
                    }
                }
                
                //Comprobar si hay difuntos repetidos y eliminarlos
                if (!empty($this->request->data['DifuntoMovimiento'])) {
                    $this->request->data['DifuntoMovimiento'] = array_unique($this->request->data['DifuntoMovimiento']);
                    $this->request->data['DifuntoMovimiento'] = array_values($this->request->data['DifuntoMovimiento']);
                }
                
                //Cambiar la tumba actual a los difuntos que se mueven
                if (!empty($this->request->data['DifuntoMovimiento'])) {
                    $i = 0;
                    foreach ($this->request->data['DifuntoMovimiento'] as $morido) {
                        if (!empty($morido['difunto_id'])) {
                            $this->request->data['DifuntoMovimiento'][$i]['tipo'] = $this->request->data['Movimiento']['tipo'];
                            $this->request->data['DifuntoMovimiento'][$i]['Difunto']['id'] = $morido['difunto_id'];
                            $this->request->data['DifuntoMovimiento'][$i]['Difunto']['tumba_id'] = $this->request->data['MovimientoTumba'][1]['tumba_id'];
//Indicar que se trata de un movimiento previo para evitar errores de validacion
$this->request->data['DifuntoMovimiento'][$i]['previo']='';
                            $i++;
                        }
                    }
                }
                
                //Obtener los difuntos que van a ser movidos
                $numero_muertos = $i;
                $this->request->data['Movimiento']['viajeros'] = $numero_muertos;
                
                //Controlar la población de la tumba de origen
                $this->request->data['Movimiento']['cementerio_origen'] = null;
                unset($this->request->data['MovimientoTumba'][0]);
                unset($this->request->data['Tumba'][0]);
                
                //Controlar la población de la tumba de destino
                $this->request->data['MovimientoTumba'][1]['origen_destino'] = "Destino";
                $this->request->data['MovimientoTumba'][1]['Tumba']['id'] = $this->request->data['MovimientoTumba'][1]['tumba_id'];
                $this->request->data['MovimientoTumba'][1]['Tumba']['poblacion'] = $this->Movimiento->MovimientoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['MovimientoTumba'][1]['tumba_id'])) + $numero_muertos;
                unset($this->request->data['Tumba'][1]);
                
                //Indicar que se trata de un movimiento previo para evitar errores de validacion

            }
            
            //Operaciones para el tipo de movimiento traslado
            elseif ($this->request->data['Movimiento']['tipo'] == "Traslado") {
                
                //Cambiar la tumba actual a los difuntos que se mueven
                if (!empty($this->request->data['DifuntoMovimiento'])) {
                    $i = 0;
                    foreach ($this->request->data['DifuntoMovimiento'] as $morido) {
                        if (!empty($morido['difunto_id'])) {
                            $this->request->data['DifuntoMovimiento'][$i]['tipo'] = $this->request->data['Movimiento']['tipo'];
                            $this->request->data['DifuntoMovimiento'][$i]['Difunto']['id'] = $morido['difunto_id'];
                            $this->request->data['DifuntoMovimiento'][$i]['Difunto']['tumba_id'] = $this->request->data['MovimientoTumba'][1]['tumba_id'];
                            $i++;
                        }
                    }
                }
                
                //Obtener los difuntos que van a ser movidos
                $numero_muertos = $i;
                $this->request->data['Movimiento']['viajeros'] = $numero_muertos;
                
                //Controlar la población de la tumba de origen
                $this->request->data['MovimientoTumba'][0]['origen_destino'] = "Origen";
                $this->request->data['MovimientoTumba'][0]['Tumba']['id'] = $this->request->data['MovimientoTumba'][0]['tumba_id'];
                $this->request->data['MovimientoTumba'][0]['Tumba']['poblacion'] = $this->Movimiento->MovimientoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['MovimientoTumba'][0]['tumba_id'])) - $numero_muertos;
                
                //Controlar la población de la tumba de destino
                $this->request->data['MovimientoTumba'][1]['origen_destino'] = "Destino";
                $this->request->data['MovimientoTumba'][1]['Tumba']['id'] = $this->request->data['MovimientoTumba'][1]['tumba_id'];
                $this->request->data['MovimientoTumba'][1]['Tumba']['poblacion'] = $this->Movimiento->MovimientoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['MovimientoTumba'][1]['tumba_id'])) + $numero_muertos;
                
            }
            
            //Trucos surtido para la validadción
            unset($this->Movimiento->MovimientoTumba->Tumba->validate);
            unset($this->Movimiento->DifuntoMovimiento->Difunto->validate);

            //Validar los datos introducidos
            if ($this->Movimiento->saveAll($this->request->data, array('validate' => 'only', 'deep' => true))) {
                
                //Guardar y comprobar éxito
                if ($this->Movimiento->DifuntoMovimiento->deleteAll(array('DifuntoMovimiento.movimiento_id' => $id), false, false) && $this->Movimiento->MovimientoTumba->deleteAll(array('MovimientoTumba.movimiento_id' => $id), false, false) && $this->Movimiento->saveAssociated($this->request->data, $this->opciones_guardado)) {
                    $this->Session->setFlash(__('El movimiento ha sido actualizado correctamente.'));
                    //Borrar datos de sesión
                    $this->Session->delete('Movimiento');
                    //Redireccionar a index
                    $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('Ha ocurrido un error mágico. El movimiento no ha podido ser actualizado.'));
                }
            }
            else {
               $this->Session->setFlash(__('Error al validar los datos introducidos. Revise el formulario.'));
            }
        }
        else {
            //Devolver los datos actuales del movimiento
            $this->request->data = $this->Movimiento->find('first', array(
             'conditions' => array(
              'Movimiento.id' => $id
             ),
             'contain' => array(
              'DifuntoMovimiento' => array(
               'Difunto' => array(
                'Persona' => array(
                 'fields' => array(
                  'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
                 ),
                ),
                'fields' => array(
                 'Difunto.id', 'Difunto.persona_id', 'Difunto.estado'
                ),
               ),
              ),
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
             ),
            ));
            
            //Devolver nombres bonitos para entidades relacionadas
            $this->request->data['Movimiento']['fecha_bonita'] = date('d/m/Y', strtotime($this->request->data['Movimiento']['fecha']));

            $i = 0;
            foreach($this->request->data['DifuntoMovimiento'] as $difunto) {
                $this->request->data['DifuntoMovimiento'][$i]['difunto_bonito'] = $this->request->data['DifuntoMovimiento'][$i]['Difunto']['Persona']['nombre_completo'] . " - " . $this->request->data['DifuntoMovimiento'][$i]['Difunto']['Persona']['dni'];
                $i++;
            }

if($this->request->data['Movimiento']['tipo'] == "Inhumación"){
$t0='tumba_destino';
$t_id=$this->request->data['MovimientoTumba'][0]['tumba_id'];
}
elseif($this->request->data['Movimiento']['tipo'] == "Exhumación"){
$t0='tumba_origen';
$t_id=$this->request->data['MovimientoTumba'][0]['tumba_id'];
}
elseif($this->request->data['Movimiento']['tipo'] == "Traslado"){
            if ($this->request->data['MovimientoTumba'][0]['origen_destino'] == "Origen"){$t0='tumba_origen';$t1='tumba_destino';$t_id=$this->request->data['MovimientoTumba'][0]['tumba_id'];}
else{$t0='tumba_destino';$t1='tumba_origen';$t_id=$this->request->data['MovimientoTumba'][1]['tumba_id'];}
}
            if ($this->request->data['MovimientoTumba'][0]['Tumba']['Columbario']) {
                $this->request->data['Movimiento'][$t0] = $this->request->data['MovimientoTumba'][0]['Tumba']['Columbario']['localizacion'];
            }
            elseif ($this->request->data['MovimientoTumba'][0]['Tumba']['Nicho']) {
                $this->request->data['Movimiento'][$t0] = $this->request->data['MovimientoTumba'][0]['Tumba']['Nicho']['localizacion'];
            }
            elseif ($this->request->data['MovimientoTumba'][0]['Tumba']['Panteon']) {
                $this->request->data['Movimiento'][$t0] = $this->request->data['MovimientoTumba'][0]['Tumba']['Panteon']['localizacion'];
            }
            elseif ($this->request->data['MovimientoTumba'][0]['Tumba']['Exterior']) {
                $this->request->data['Movimiento'][$t0] = $this->request->data['MovimientoTumba'][0]['Tumba']['Exterior']['localizacion'];
            }
if(isset($t1)){
            if ($this->request->data['MovimientoTumba'][1]['Tumba']['Columbario']) {
                $this->request->data['Movimiento'][$t1] = $this->request->data['MovimientoTumba'][1]['Tumba']['Columbario']['localizacion'];
            }
            elseif ($this->request->data['MovimientoTumba'][1]['Tumba']['Nicho']) {
                $this->request->data['Movimiento'][$t1] = $this->request->data['MovimientoTumba'][1]['Tumba']['Nicho']['localizacion'];
            }
            elseif ($this->request->data['MovimientoTumba'][1]['Tumba']['Panteon']) {
                $this->request->data['Movimiento'][$t1] = $this->request->data['MovimientoTumba'][1]['Tumba']['Panteon']['localizacion'];
            }
            elseif ($this->request->data['MovimientoTumba'][1]['Tumba']['Exterior']) {
                $this->request->data['Movimiento'][$t1] = $this->request->data['MovimientoTumba'][1]['Tumba']['Exterior']['localizacion'];
            }
}

            //Guardar los datos de sesión del traslado
            $this->Session->write('Movimiento.id', $this->request->data['Movimiento']['id']);
            $this->Session->write('Movimiento.tipo_fecha', $this->request->data['Movimiento']['tipo'] . " - " . date('d/m/Y', strtotime($this->request->data['Movimiento']['fecha'])));

            /*$this->Session->write('Difunto.persona_id', $this->request->data['Difunto']['persona_id']);
            $this->Session->write('Difunto.nombre_completo', $this->request->data['Persona']['nombre_completo']);
            $this->Session->write('Traslado.tumba_origen', $this->request->data['Tumba']['id']);
            $this->Session->write('Traslado.tumba_destino', $this->request->data['Tumba']['id']);*/
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
        $this->Movimiento->id = $id;
        
        //Comprobar si existe el movimiento
        if (!$this->Movimiento->exists()) {
            $this->Session->setFlash(__('El movimiento especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el movimiento
        $movimiento = $this->Movimiento->find('first', array(
         'conditions' => array(
          'Movimiento.id' => $id
         ),
         'contain' => array(
          'DifuntoMovimiento' => array(
           'Difunto' => array(
            'Persona' => array(
             'fields' => array(
              'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
             ),
            ),
            'fields' => array(
             'Difunto.id', 'Difunto.persona_id', 'Difunto.estado'
            ),
           ),
          ),
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
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $movimiento['Movimiento']['tipo'] . " - " . date('d/m/Y', strtotime($movimiento['Movimiento']['fecha']));
        $this->pdfConfig['filename'] = "Movimiento_" . $movimiento['Movimiento']['tipo'] . ".pdf";
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('movimiento'));
        
        //Redireccionar para la generación
        
        
    }
    
    /**
     * export_pdf method
     *
     * @param string $id
     * @return void
     */
    public function exportar_pdf($id = null) {
        
        //Asignar id
        $this->Movimiento->id = $id;
        
        //Comprobar si existe el movimiento
        if (!$this->Movimiento->exists()) {
            $this->Session->setFlash(__('El movimiento especificado no existe.'));
            $this->redirect(array('action' => 'index'));
        }
        
        //Cargar toda la información relevante relacionada con el movimiento
        $movimiento = $this->Movimiento->find('first', array(
         'conditions' => array(
          'Movimiento.id' => $id
         ),
         'contain' => array(
          'DifuntoMovimiento' => array(
           'Difunto' => array(
            'Persona' => array(
             'fields' => array(
              'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
             ),
            ),
            'fields' => array(
             'Difunto.id', 'Difunto.persona_id', 'Difunto.estado'
            ),
           ),
          ),
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
         ),
        ));
        
        //Establecer parámetros específicos para la generación del documento .pdf
        $this->pdfConfig['title'] = $movimiento['Movimiento']['tipo'] . " - " . date('d/m/Y', strtotime($movimiento['Movimiento']['fecha']));
        $this->pdfConfig['filename'] = "Movimiento_" . $movimiento['Movimiento']['tipo'] . ".pdf";
        $this->pdfConfig['download'] = true;
        
        //Comprobar el sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //Path to binary (WkHtmlToPdfEngine only), Windows path
            $this->pdfConfig['binary'] = 'C:\\wkhtmltopdf\\wkhtmltopdf.exe';
        }
        
        //Asignar el resultado de la búsqueda a una variable
        //(Comentario vital para entender el código de la función)
        $this->set(compact('movimiento'));
        
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
        $this->Movimiento->id = $id;
        
        //Comprobar si existe el movimiento
        if (!$this->Movimiento->exists()) {
            throw new NotFoundException(__('El movimiento especificado no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Movimiento->delete()) {
            $this->Session->setFlash(__('El movimiento ha sido eliminado correctamente.'));
        }
        else {
            $this->Session->setFlash(__('Ha ocurrido un error mágico. El movimiento no ha podido ser eliminado.'));
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
        $resultados = $this->Movimiento->find('all', array(
         'conditions' => array(
          'OR' => array(
           'Movimiento.tipo LIKE' => $palabro,
           'Movimiento.motivo LIKE' => $palabro,
           'DATE_FORMAT(Movimiento.fecha, "%d/%m/%Y") LIKE' => $palabro,
          ),
         ),
         'contain' => array(
         ),
         'fields' => array(
          'Movimiento.id', 'Movimiento.tipo', 'Movimiento.fecha', 'Movimiento.motivo'
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
                $fecha = date('d/m/Y', strtotime($resultado['Movimiento']['fecha']));
                array_push($items, array("label" => $resultado['Movimiento']['tipo'] . " " . $fecha . " - " . $resultado['Movimiento']['motivo'], "value" => $resultado['Movimiento']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }

}
