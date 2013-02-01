<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Traslados Controller
 *
 * @property Traslado $Traslado
 * @property PaginatorComponent $Paginator
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 * @property Search.PrgComponent $Search.Prg
 */
class TrasladosController extends AppController {
    
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
    public $modelClass = 'Traslado';
    
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Traslados';
    
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
    public $uses = array('Traslado', 'DifuntoTraslado', 'TrasladoTumba', 'Difunto', 'Tumba', 'Sanitize');
    
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
            'Traslado' => array('id', 'fecha', 'cementerio_origen', 'cementerio_destino', 'motivo', 'observaciones'),
            'DifuntoTraslado' => array('id', 'difunto_id', 'traslado_id'),
            'TrasladoTumba' => array('id', 'traslado_id', 'tumba_id', 'origen_destino'),
            'Difunto' => array('tumba_id'),
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
         'conditions' => $this->Traslado->parseCriteria($this->params->query),
         'contain' => array(
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
         ),
        );
        
        //Devolver paginación
        $this->set('traslados', $this->paginate());
        
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
            
            //Crear nuevo traslado con id único
            $this->Traslado->create();
            
            //Obtener los difuntos que van a ser trasladados
            $numero_muertos = count($this->request->data['DifuntoTraslado']);
            
            //Cambiar la tumba actual a los difuntos que se trasladan
            if (!empty($this->request->data['DifuntoTraslado'])) {
                foreach ($this->request->data['DifuntoTraslado'] as $morido) {
                    if ($morido['difunto_id'])
                        $this->request->data['Difunto']['id'] = $morido['difunto_id'];
                        $this->request->data['Difunto']['tumba_id'] = $this->request->data['Tumba'][1]['id'];
//$numero_muertos++;
                    }
$d_t = $this->request->data['DifuntoTraslado'];
}
//unset($this->request->data['DifuntoTraslado']);

            //Controlar la población de la tumba de origen
            $this->request->data['TrasladoTumba'][0]['origen_destino'] = "Origen";
            $this->request->data['Tumba'][0]['id'] = $this->request->data['TrasladoTumba'][0]['tumba_id'];
            $this->request->data['Tumba'][0]['población'] = $this->Traslado->TrasladoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['TrasladoTumba'][0]['tumba_id'])) - $numero_muertos;
            
            //Controlar la población de la tumba de destino
            $this->request->data['TrasladoTumba'][1]['origen_destino'] = "Destino";
            $this->request->data['Tumba'][1]['id'] = $this->request->data['TrasladoTumba'][1]['tumba_id'];
            $this->request->data['Tumba'][1]['población'] = $this->Traslado->TrasladoTumba->Tumba->field('poblacion', array('Tumba.id' => $this->request->data['TrasladoTumba'][1]['tumba_id'])) + $numero_muertos;
            
            //Guardar y comprobar éxito
            if ($this->Traslado->saveAssociated($this->request->data, $this->opciones_guardado)) {
                //Asociar los difuntos al traslado producido
                if($d_t) {
foreach($d_t as $x) {
                    $x['traslado_id'] = $this->Traslado->id;
                    $this->Traslado->DifuntoTraslado->save($d_t);
                }
}
                $this->Session->setFlash(__('El traslado ha sido guardado correctamente.'));
                //Obtener a donde se redireccionará
                $accion = $this->request->query['accion'];
                //Redireccionar según corresponda
                if ($accion == 'guardar_y_nuevo') {
                    $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->redirect(array('action' => 'index'));
                }
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El traslado no ha podido ser guardado.'));
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
        $this->Traslado->id = $id;
        
        //Comprobar si existe el traslado
        if (!$this->Traslado->exists()) {
            throw new NotFoundException(__('El traslado especificado no existe.'));
        }
        
        //Cargar toda la información relevante relacionada con el traslado
        $traslado = $this->Traslado->find('first', array(
         'conditions' => array(
          'Traslado.id' => $id
         ),
         'contain' => array(
          'DifuntoTraslado' => array(
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
          'TrasladoTumba' => array(
           'Tumba' => array(
            'Columbario','Nicho','Panteon','Exterior',
            'fields' => array(
             'Tumba.id', 'Tumba.tipo', 'Tumba.poblacion'
            ),
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
        $this->set(compact('traslado'));
        
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
        $this->Traslado->id = $id;
        
        //Comprobar si existe el traslado
        if (!$this->Traslado->exists()) {
            throw new NotFoundException(__('El traslado especificado no existe.'));
        }
        
        //Comprobar si se está enviando el formulario
        if ($this->request->is('post') || $this->request->is('put')) {
            //Guardar y comprobar éxito
            if ($this->Traslado->saveAssociated($this->request->data)) {
                $this->Session->setFlash(__('El traslado ha sido actualizado correctamente.'));
                //Borrar datos de sesión
                $this->Session->delete('Traslado');
                //Redireccionar a index
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('Ha ocurrido un error mágico. El traslado no ha podido ser actualizado.'));
            }
        }
        else {
            //Devolver los datos actuales del traslado
            $this->request->data = $this->Traslado->find('first', array(
             'conditions' => array(
              'Traslado.id' => $id
             ),
             'contain' => array(
              'DifuntoTraslado' => array(
               'Difunto' => array(
                'Persona' => array(
                 'fields' => array(
                  'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
                 ),
                ),
                'fields' => array(
                 'Difunto.id', 'Difunto.persona_id', 'Difunto.tumba_id'
                ),
               ),
              ),
              'TrasladoTumba' => array(
               'Tumba' => array(
                'Columbario','Nicho','Panteon','Exterior',
                'fields' => array(
                 'Tumba.id', 'Tumba.tipo',
                ),
               ),
              ),
             ),
            ));
            
            //Devolver nombres bonitos para entidades relacionadas
            if ($this->request->data['Traslado']['fecha']) {
                $this->request->data['Traslado']['fecha_bonita'] = date('d/m/Y', strtotime($this->request->data['Traslado']['fecha']));
            }

            if ($this->request->data['TrasladoTumba'][0]['origen_destino'] == "Origen"){$t0='tumba_origen';$t1='tumba_destino';$t_id=$this->request->data['TrasladoTumba'][0]['tumba_id'];}
else{$t0='tumba_destino';$t1='tumba_origen';$t_id=$this->request->data['TrasladoTumba'][1]['tumba_id'];}

            if ($this->request->data['TrasladoTumba'][0]['Tumba']['Columbario']) {
                $this->request->data['Traslado'][$t0] = $this->request->data['TrasladoTumba'][0]['Tumba']['Columbario']['localizacion'];
            }
            elseif ($this->request->data['TrasladoTumba'][0]['Tumba']['Nicho']) {
                $this->request->data['Traslado'][$t0] = $this->request->data['TrasladoTumba'][0]['Tumba']['Nicho']['localizacion'];
            }
            elseif ($this->request->data['TrasladoTumba'][0]['Tumba']['Panteon']) {
                $this->request->data['Traslado'][$t0] = $this->request->data['TrasladoTumba'][0]['Tumba']['Panteon']['localizacion'];
            }
            elseif ($this->request->data['TrasladoTumba'][0]['Tumba']['Exterior']) {
                $this->request->data['Traslado'][$t0] = $this->request->data['TrasladoTumba'][0]['Tumba']['Exterior']['localizacion'];
            }

            if ($this->request->data['TrasladoTumba'][1]['Tumba']['Columbario']) {
                $this->request->data['Traslado'][$t1] = $this->request->data['TrasladoTumba'][1]['Tumba']['Columbario']['localizacion'];
            }
            elseif ($this->request->data['TrasladoTumba'][1]['Tumba']['Nicho']) {
                $this->request->data['Traslado'][$t1] = $this->request->data['TrasladoTumba'][1]['Tumba']['Nicho']['localizacion'];
            }
            elseif ($this->request->data['TrasladoTumba'][1]['Tumba']['Panteon']) {
                $this->request->data['Traslado'][$t1] = $this->request->data['TrasladoTumba'][1]['Tumba']['Panteon']['localizacion'];
            }
            elseif ($this->request->data['TrasladoTumba'][1]['Tumba']['Exterior']) {
                $this->request->data['Traslado'][$t1] = $this->request->data['TrasladoTumba'][1]['Tumba']['Exterior']['localizacion'];
            }

//cargar todos los difuntos de la tumba de origen
            $this->request->data['DifuntoTumba'] = $this->Traslado->DifuntoTraslado->Difunto->find('all', array(
             'conditions' => array(
              'Difunto.tumba_id' => $t_id
             ),
             'contain' => array(
              'Persona' => array(
               'fields' => array(
                'Persona.id', 'Persona.dni', 'Persona.nombre_completo'
               ),
              ),
             ),
             'fields' => array(
              'Difunto.id', 'Difunto.persona_id', 'Difunto.tumba_id'
             ),
            ));

            //Guardar los datos de sesión del traslado
            $this->Session->write('Traslado.id', $this->request->data['Traslado']['id']);
            $this->Session->write('Traslado.fecha_motivo', date('d/m/Y', strtotime($this->request->data['Traslado']['fecha'])) . " - " . $this->request->data['Traslado']['motivo']);

            /*$this->Session->write('Difunto.persona_id', $this->request->data['Difunto']['persona_id']);
            $this->Session->write('Difunto.nombre_completo', $this->request->data['Persona']['nombre_completo']);
            $this->Session->write('Traslado.tumba_origen', $this->request->data['Tumba']['id']);
            $this->Session->write('Traslado.tumba_destino', $this->request->data['Tumba']['id']);*/
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
        $this->Traslado->id = $id;
        
        //Comprobar si existe el traslado
        if (!$this->Traslado->exists()) {
            throw new NotFoundException(__('El traslado especificado no existe.'));
        }
        
        //Borrar y comprobar éxito
        if ($this->Traslado->DifuntoTraslado->deleteAll(array('DifuntoTraslado.traslado_id' => $id), false, false) && $this->Traslado->TrasladoTumba->deleteAll(array('TrasladoTumba.traslado_id' => $id), false, false) && $this->Traslado->delete()) {
            $this->Session->setFlash(__('El traslado ha sido eliminado correctamente.'));
            //Redireccionar a index
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('Ha ocurrido un error mágico. El traslado no ha podido ser eliminado.'));
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
        $resultados = $this->Traslado->find('all', array(
         'conditions' => array(
          'OR' => array(
           'Traslado.motivo LIKE' => $palabro,
           'DATE_FORMAT(Traslado.fecha, "%d/%m/%Y") LIKE' => $palabro,
          ),
         ),
         'contain' => array(
         ),
         'fields' => array(
          'Traslado.id', 'Traslado.fecha', 'Traslado.motivo'
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
                $fecha = date('d/m/Y', strtotime($resultado['Traslado']['fecha']));
                array_push($items, array("label" => $fecha . " " . $resultado['Traslado']['motivo'], "value" => $resultado['Traslado']['id']));
            }
        }
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        echo json_encode($items);
    }

}
