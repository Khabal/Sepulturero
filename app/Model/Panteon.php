<?php

App::uses('AppModel', 'Model');

/**
 * Panteon Model
 *
 * @property Tumba $Tumba
 */
class Panteon extends AppModel {
    
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
    public $useTable = 'panteones';
    
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
    public $displayField = 'localizacion';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Panteon';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Panteon';
    
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
        'localizacion' => 'CONCAT("Familia: ", Panteon.familia, " - Número: ", Panteon.numero_panteon,  " - Patio: ", Panteon.patio)'
    );
    
    /**
     * List of behaviors
     *
     * @var array
     */
    public $actsAs = array();
    
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
                'message' => 'Error inesperado al generar ID de panteón.',
            ),
        ),
        'tumba_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de tumba.',
            ),
        ),
        'familia' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La familia no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 2, 100),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La familia debe tener entre 2 y 100 caracteres.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑçÇáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙâÂêÊîÎôÔûÛüÜ \'\-]{2,100}$/i',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La familia sólo puede contener caracteres alfabéticos.',
            ),
        ),
        'numero_panteon' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de panteón no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 1, 4),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de panteón debe tener entre 1 y 4 caracteres.',
            ),
            'numeronatural' => array(
                'rule' => array('naturalNumber', false),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de panteón sólo puede contener caracteres numéricos.',
            ),
        ),
        'patio' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El patio no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 1, 2),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El patio debe tener entre 1 y 2 caracteres.',
            ),
            'numeronatural' => array(
                'rule' => array('naturalNumber', false),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El patio sólo puede contener caracteres numéricos.',
            ),
        ),
    );
    
    /**
     * ----------------------
     * Model associations
     * ----------------------
     */
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
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
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
    }
    
}
