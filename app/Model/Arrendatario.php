<?php

App::uses('AppModel', 'Model');

/**
 * Arrendatario Model
 *
 * @property Persona $Persona
 * @property Funeraria $Funeraria
 * @property ArrendatarioFuneraria $ArrendatarioFuneraria
 * @property Tumba $Tumba
 * @property ArrendatarioTumba $ArrendatarioTumba
 */
class Arrendatario extends AppModel {
    
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
    public $useTable = 'arrendatarios';
    
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
    public $displayField = 'nombre_completo';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Arrendatario';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Arrendatario';
    
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
    public $_schema = array(
    );
    
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
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'persona_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		/*'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
		'direccion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'La dirección no se puede dejar en blanco',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'localidad' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'caracteres' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'provincia' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pais' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El país no puede dejarse en blanco',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'codigo_postal' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'telefono' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El teléfono contiene caraceteres extraños',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'correo_electronico' => array(
			'numeric' => array(
				'rule' => array('email'),
				'message' => 'El correo electrónico introducido no es válido',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
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
        'Persona' => array(
            'className' => 'Persona',
            'foreignKey' => 'persona_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
        ),
    );
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ArrendatarioFuneraria' => array(
            'className' => 'ArrendatarioFuneraria',
            'foreignKey' => 'arrendatario_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ),
        'ArrendatarioTumba' => array(
            'className' => 'ArrendatarioTumba',
            'foreignKey' => 'arrendatario_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
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
     * @access public
     */
    public function __construct($id = false, $table = null, $ds = null) {
        
        //Añadir campos virtuales de "Persona"
        $this->virtualFields += $this->Persona->virtualFields;
        
        //Vector de estados de arrendamiento de una tumba
        $this->estado = array(
         'Antiguo' => __('Antiguo', true),
         'Actual' => __('Actual', true),
        );
        
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
        'clave' => array('type' => 'query', 'method' => 'filterArrendatario'),
    );
    
    /**
     * filterArrendatario method
     *
     * @return array
     */
    public function filterArrendatario ($data = array()) {
        
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
          'Persona.nombre LIKE' => $comodin,
          'Persona.apellido1 LIKE' => $comodin,
          'Persona.apellido2 LIKE' => $comodin,
          'Persona.dni LIKE' => $comodin,
          'CONCAT(Persona.nombre," ",Persona.apellido1) LIKE' => $comodin,
          'CONCAT(Persona.nombre," ",Persona.apellido1," ",Persona.apellido2) LIKE' => $comodin,
         )
        );
        
    }

}
