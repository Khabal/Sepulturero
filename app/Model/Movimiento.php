<?php

App::uses('AppModel', 'Model');

/**
 * Movimiento Model
 *
 * @property DifuntoMovimiento $DifuntoMovimiento
 * @property MovimientoTumba $MovimientoTumba
 */
class Movimiento extends AppModel {
    
    /**
     * ----------------------
     * Model Attributes
     * ----------------------
     */
    
    /**
     * Enable or disable cache queries
     *
     * @var boolean
     */
    public $cacheQueries = false;
    
    /**
     * Number of associations to recurse
     *
     * @var integer
     */
    public $recursive = 1;
    
    /**
     * Name of the database connection
     *
     * @var string
     */
    public $useDbConfig = 'cementerio';
    
    /**
     * Database table name
     *
     * @var string
     */
    public $useTable = 'movimientos';
    
    /**
     * Name of the table prefix
     *
     * @var string
     */
    public $tablePrefix = '';
    
    /**
     * Table primary key
     *
     * @var string
     */
    public $primaryKey = 'id';
    
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'fecha_motivo';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Movimiento';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Movimiento';
    
    /**
     * List of defaults ordering of data for any find operation
     *
     * @var array
     */
    public $order = array();
    
    /**
     * Virtual fields
     *
     * @var array
     */
    public $virtualFields = array(
        'fecha_motivo' => 'CONCAT(DATE_FORMAT(Movimiento.fecha,"%d/%m/%Y"), " - ", Movimiento.motivo)'
    );
    
    /**
     * List of behaviors
     *
     * @var array
     */
    public $actsAs = array('Containable', 'Search.Searchable');
    
    /**
     * ----------------------
     * Model schema
     * ----------------------
     */
    
    /**
     * Metadata describing the model's database table fields
     *
     * @var array
     */
    public $_schema = array();
    
    /**
     * ----------------------
     * Model data validation
     * ----------------------
     */
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al generar ID de movimiento.',
            ),
        ),
        'tipo' => array(
            'novacio' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El tipo de movimiento no se puede dejar en blanco.',
            ),
            'lista_movimiento' => array(
                'rule' => array('inList', array('Exhumación', 'Inhumación', 'Traslado')),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El tipo de movimiento no se encuentra dentro de las opciones posibles.',
            ),
            'viajeros_al_tren' => array(
                'rule' => array('valida_viajeros'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'No se permite este movimiento con 0 difuntos.',
            ),
        ),
        'fecha' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La fecha de movimiento no se puede dejar en blanco.',
            ),
            'formato_fecha' => array(
                'rule' => array('date', 'ymd'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Formato de fecha inválido (AAAA/MM/DD).',
            ),
        ),
        'viajeros' => array(
            'novacio' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de difuntos meneados no se puede dejar en blanco.',
            ),
            'numeronatural' => array(
                'rule' => array('naturalNumber', false),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de difuntos meneados sólo puede contener caracteres numéricos.',
            ),
        ),
        'cementerio_origen' => array(
            'longitud' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El cementerio de origen debe tener entre 2 y 50 caracteres.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑçÇáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙâÂêÊîÎôÔûÛüÜ \'\-]{2,50}$/i',
                'required' => true,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El cementerio de origen sólo puede contener caracteres alfabéticos.',
            ),
        ),
        'cementerio_destino' => array(
            'longitud' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El cementerio de destino debe tener entre 2 y 50 caracteres.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑçÇáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙâÂêÊîÎôÔûÛüÜ \'\-]{2,50}$/i',
                'required' => true,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El cementerio de destino sólo puede contener caracteres alfabéticos.',
            ),
        ),
        'motivo' => array(
            'novacio' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El motivo no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 2, 250),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El motivo debe tener entre 2 y 250 caracteres.',
            ),
        ),
        'observaciones' => array(
            'maximalongitud' => array(
                'rule' => array('maxLength', 255),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Las observaciones debe tener como máximo 255 caracteres.',
            ),
        ),
        //Campos imaginarios
        'fecha_bonita' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La fecha de movimiento no se puede dejar en blanco.',
            ),
            'formato_fecha' => array(
                'rule' => array('date', 'dmy'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Formato de fecha inválido (DD/MM/AAAA).',
            ),
        ),
        'tumba_origen' => array(
            'uuid' => array(
                'rule' => array('valida_tumba_origen'),
                'required' => true,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La tumba especificada no existe.',
            ),
            'origen' => array(
                'rule' => array('valida_origen'),
                'required' => true,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Se requiere una tumba como origen para este tipo de movimiento.',
            ),
        ),
        'tumba_destino' => array(
            'uuid' => array(
                'rule' => array('valida_tumba_destino'),
                'required' => true,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La tumba especificada no existe.',
            ),
            'destino' => array(
                'rule' => array('valida_destino'),
                'required' => true,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Se requiere una tumba como destino para este tipo de movimiento.',
            ),
        ),
    );
    
    /**
     * ----------------------
     * Model associations
     * ----------------------
     */
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'DifuntoMovimiento' => array(
            'className' => 'DifuntoMovimiento',
            'foreignKey' => 'movimiento_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => true,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'MovimientoTumba' => array(
            'className' => 'MovimientoTumba',
            'foreignKey' => 'movimiento_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => true,
            'exclusive' => false,
            'finderQuery' => '',
        ),
    );
    
    /**
     * ----------------------
     * Model methods
     * ----------------------
     */
    
    /**
     * Constructor
     *
     * @param mixed $id Model ID
     * @param string $table Table name
     * @param string $ds Datasource
     * @return class object
     */
    public function __construct ($id = false, $table = null, $ds = null) {
        
        //Vector de tipos de movimientos
        $this->tipo = array(
            'Exhumación' => __('Exhumación', true),
            'Inhumación' => __('Inhumación', true),
            'Traslado' => __('Traslado', true),
        );
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
    }
    
    /**
     * valida_viajeros method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_viajeros($check) {
        
        //Comprobar que el número de viajeros sea mayor que 0
        if ($this->data['Movimiento']['viajeros'] > 0) {
            //Devolver válido
            return true;
        }
        else {
            //Devolver error
            return false;
        }
        
    }
    
    /**
     * valida_tumba_origen method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_tumba_origen($check) {
        
        //Extraer el ID de la tumba
        if (!empty($this->data['MovimientoTumba'][0]['tumba_id'])) {
            $id = $this->data['MovimientoTumba'][0]['tumba_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe una tumba con el ID especificado
        $tumba = $this->MovimientoTumba->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $id,
         ),
         'fields' => array(
          'Tumba.id'
         ),
          'contain' => array(
         ),
        ));
        
        //Comprobar si existe la tumba especificada
        if (empty($tumba['Tumba']['id'])) {
            //Devolver error
            return false;
        }
        else {
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
    }
    
    /**
     * valida_origen method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_origen($check) {
        
        //Extraer el tipo de movimiento
        if (!empty($this->data['Movimiento']['tipo'])) {
            $tipo = $this->data['Movimiento']['tipo'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Comprobar que el tipo de movimiento sea de los que requieren origen
        if (($tipo == "Exhumación") || ($tipo == "Traslado")){
            
            //Comprobar que la tumba de origen se haya introducido
            if (empty($this->data['MovimientoTumba'][0]['tumba_id'])) {
                //Devolver error
                return false;
            }
            else {
                //Devolver válido
                return true;
            }
            
        }
        
        //Devolver válido
        return true;
        
    }
    
    /**
     * valida_tumba_destino method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_tumba_destino($check) {
        
        //Extraer el ID de la tumba
        if (!empty($this->data['MovimientoTumba'][1]['tumba_id'])) {
            $id = $this->data['MovimientoTumba'][1]['tumba_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe una tumba con el ID especificado
        $tumba = $this->MovimientoTumba->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $id,
         ),
         'fields' => array(
          'Tumba.id'
         ),
          'contain' => array(
         ),
        ));
        
        //Comprobar si existe la tumba especificada
        if (empty($tumba['Tumba']['id'])) {
            //Devolver error
            return false;
        }
        else {
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
    }
    
    /**
     * valida_destino method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_destino($check) {
        
        //Extraer el tipo de movimiento
        if (!empty($this->data['Movimiento']['tipo'])) {
            $tipo = $this->data['Movimiento']['tipo'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Comprobar que el tipo de movimiento sea de los que requieren destino
        if (($tipo == "Inhumación") || ($tipo == "Traslado")){
            
            //Comprobar que la tumba de destino se haya introducido
            if (empty($this->data['MovimientoTumba'][1]['tumba_id'])) {
                //Devolver error
                return false;
            }
            else {
                //Devolver válido
                return true;
            }
            
        }
        
        //Devolver válido
        return true;
        
    }
    
    /**
     * ---------------------------
     * Search Plugin
     * ---------------------------
     */
    
    /**
     * Field names accepted
     *
     * @var array
     * @see SearchableBehavior
     */
    public $filterArgs = array(
        'clave' => array('type' => 'query', 'method' => 'buscarMovimiento'),
    );
    
    /**
     * buscarMovimiento method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarMovimiento ($data = array()) {
        
        //Comprobar que se haya introducido un término de búsqueda
        if (empty($data['clave'])) {
            //Devolver resultados de la búsqueda
            return array();
        }
	
        //Construir comodín para búsqueda
        $comodin = '%' . $data['clave'] . '%';
        
        //Devolver resultados de la búsqueda
        return array(
         'OR'  => array(
          'DATE_FORMAT(Movimiento.fecha,"%d/%m/%Y") LIKE' => $comodin,
          'Movimiento.motivo LIKE' => $comodin,
         )
        );
        
    }

}
