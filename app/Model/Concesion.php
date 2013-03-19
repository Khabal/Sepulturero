<?php

App::uses('AppModel', 'Model');

/**
 * Concesion Model
 *
 * @property Arrendamiento $Arrendamiento
  */
class Concesion extends AppModel {
    
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
    public $useTable = 'concesiones';
    
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
    public $displayField = 'tipo';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Concesion';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Concesion';
    
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
    public $virtualFields = array();
    
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
                'message' => 'Error inesperado al generar ID de concesión.',
            ),
        ),
        'tipo' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El tipo de concesión no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El tipo de concesión debe tener entre 2 y 50 caracteres.',
            ),
        ),
        'anos_concesion' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Los años de concesión no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 1, 3),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Los años de concesión debe tener entre 1 y 3 caracteres.',
            ),
            'numeronatural' => array(
                'rule' => array('naturalNumber', false),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Los años de concesión sólo puede contener caracteres numéricos.',
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
        'Arrendamiento' => array(
            'className' => 'Arrendamiento',
            'foreignKey' => 'concesion_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
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
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
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
        'tipo' => array('type' => 'like'),
        'anos_concesion' => array('type' => 'like'),
        'clave' => array('type' => 'query', 'method' => 'buscarConcesion'),
    );
    
    /**
     * buscarConcesion method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarConcesion ($data = array()) {
        
        //Comprobar que se haya introducido un término de búsqueda
        if (empty($data['clave'])) {
            //Devolver condiciones de la búsqueda
            return array();
        }
	
        //Construir comodín para búsqueda
        $comodin = '%' . $data['clave'] . '%';
        
        //Devolver condiciones de la búsqueda
        return array(
         'OR'  => array(
          'Concesion.tipo LIKE' => $comodin,
          'Concesion.anos_concesion LIKE' => $comodin,
         )
        );
        
    }
    
}
