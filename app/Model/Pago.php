<?php

App::uses('AppModel', 'Model');

/**
 * Pago Model
 *
 * @property ArrendatarioPago $ArrendatarioPago
 * @property FunerariaPago $FunerariaPago
 * @property PagoTasa $PagoTasa
 */
class Pago extends AppModel {
    
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
    public $recursive = 0;
    
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
    public $useTable = 'pagos';
    
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
    public $displayField = 'fecha_pago';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Pago';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Pago';
    
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
        'fecha' => 'Pago.fecha',
        'total' => 'Pago.total',
        'entregado' => 'Pago.entregado',
        'moneda' => 'Pago.moneda',
        'fecha_pago' => 'DATE_FORMAT(Pago.fecha,"%d/%m/%Y")'
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
                'message' => 'Error inesperado al generar ID de pago.',
            ),
        ),
        'arrendatario_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de arrendatario.',
            ),
        ),
        'funeraria_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de funeraria.',
            ),
        ),
        'tumba_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de tumba.',
            ),
        ),
        'fecha' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La fecha de pago no se puede dejar en blanco.',
            ),
            'formato_fecha' => array(
                'rule' => array('date', 'ymd'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Formato de fecha inválido (AAAA/MM/DD).',
            ),
        ),
        'total' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El total no se puede dejar en blanco.',
            ),
            'numero_real' => array(
                'rule' => '/^([0-9]\.[0-9]{3}|[0-9]{1,4})(\,[0-9]{0,2}){0,1}$/',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El total sólo puede contener caracteres numéricos.',
            ),
        ),
        'entregado' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La cantidad entregada no se puede dejar en blanco.',
            ),
            'numero_real' => array(
                'rule' => '/^([0-9]\.[0-9]{3}|[0-9]{1,4})(\,[0-9]{0,2}){0,1}$/',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La cantidad entregada sólo puede contener caracteres numéricos.',
            ),
        ),
        'moneda' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La moneda no se puede dejar en blanco.',
            ),
            'lista_moneda' => array(
                'rule' => array('inList', array('Pesetas', 'Euros')),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La moneda no se encuentra dentro de las opciones posibles.',
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
        'arrendatario_bonito' => array(
            'existe_arrendatario' => array(
                'rule' => array('valida_arrendatario'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El arrendatario especificado no existe.',
            ),
        ),
        'funeraria_bonita' => array(
            'existe_funeraria' => array(
                'rule' => array('valida_funeraria'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La funeraria especificado no existe.',
            ),
        ),
        'tumba_bonita' => array(
            'existe_funeraria' => array(
                'rule' => array('valida_tumba'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La tumba especificado no existe.',
            ),
        ),
        'fecha_bonita' => array(
            'formato_fecha' => array(
                'rule' => array('date', 'dmy'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Formato de fecha inválido (DD/MM/AAAA).',
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
        'PagoTasa' => array(
            'className' => 'PagoTasa',
            'foreignKey' => 'pago_id',
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
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Arrendatario' => array(
            'className' => 'Arrendatario',
            'foreignKey' => 'arrendatario_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
        ),
        'Funeraria' => array(
            'className' => 'Funeraria',
            'foreignKey' => 'funeraria_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
        ),
        'Tumba' => array(
            'className' => 'Tumba',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
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
        
        //Vector con las distintas monedas aceptadas en los pagos
        $this->moneda = array(
            'Pesetas' => __('Pesetas', true),
            'Euros' => __('Euros (€)', true)
        );
        
        //Vector con las distintos tipos de pagadores aceptados en los pagos
        $this->pagador = array(
            'Particular' => __('Particular', true),
            'Funeraria' => __('Funeraria', true)
        );
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
    }
    
    /**
     * valida_arrendatario method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_arrendatario($check) {
        
        //Extraer el ID del arrendatario
        if (!empty($this->data['Pago']['arrendatario_id'])) {
            $id = $this->data['Pago']['arrendatario_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe un arrendatario con el ID especificado
        $arrendatario = $this->Arrendatario->find('first', array(
         'conditions' => array(
          'Arrendatario.id' => $id,
         ),
         'fields' => array(
          'Arrendatario.id'
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si existe el arrendatario especificado
        if (empty($arrendatario['Arrendatario']['id'])) {
            //Devolver error
            return false;
        }
        else{
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
    }
    
    /**
     * valida_funeraria method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_funeraria($check) {
        
        //Extraer el ID de la funeraria
        if (!empty($this->data['Pago']['funeraria_id'])) {
            $id = $this->data['Pago']['funeraria_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe una funeraria con el ID especificado
        $funeraria = $this->Funeraria->find('first', array(
         'conditions' => array(
          'Funeraria.id' => $id,
         ),
         'fields' => array(
          'Funeraria.id'
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si existe la funeraria especificada
        if (empty($funeraria['Funeraria']['id'])) {
            //Devolver error
            return false;
        }
        else{
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
    }
    
    /**
     * valida_tumba method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_tumba($check) {
        
        //Extraer el ID de la tumba
        if (!empty($this->data['Pago']['tumba_id'])) {
            $id = $this->data['Pago']['tumba_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe una tumba con el ID especificado
        $tumba = $this->Tumba->find('first', array(
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
        else{
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
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
        'fecha' => array('type' => 'like'),
        'total' => array('type' => 'like'),
        'entregado' => array('type' => 'like'),
        'moneda' => array('type' => 'value'),
        'clave' => array('type' => 'query', 'method' => 'buscarPago'),
    );
    
    /**
     * buscarPago method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarPago ($data = array()) {
        
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
          'DATE_FORMAT(Pago.fecha,"%d/%m/%Y") LIKE' => $comodin,
         )
        );
        
    }

}
