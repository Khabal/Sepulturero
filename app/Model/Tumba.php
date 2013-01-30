<?php

App::uses('AppModel', 'Model');

/**
 * Tumba Model
 *
 * @property Columbario $Columbario
 * @property Exterior $Exterior
 * @property Nicho $Nicho
 * @property Panteon $Panteon
 * @property Difunto $Difunto
 * @property Enterramiento $Enterramiento
 * @property Arrendatario $Arrendatario
 * @property Traslado $Traslado
 */
class Tumba extends AppModel {
    
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
    public $useTable = 'tumbas';
    
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
    public $name = 'Tumba';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Tumba';
    
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

	);
    
    /**
     * ----------------------
     * Model associations
     * ----------------------
     */
    
    /**
     * hasOne associations
     *
     * @var array
     */
    public $hasOne = array(
        'Columbario' => array(
            'className' => 'Columbario',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
        'Exterior' => array(
            'className' => 'Exterior',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
        'Nicho' => array(
            'className' => 'Nicho',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
        'Panteon' => array(
            'className' => 'Panteon',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
    );
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ArrendatarioTumba' => array(
            'className' => 'ArrendatarioTumba',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'Difunto' => array(
            'className' => 'Difunto',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'Enterramiento' => array(
            'className' => 'Enterramiento',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'TrasladoTumba' => array(
            'className' => 'TrasladoTumba',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
            'exclusive' => false,
        ),
    );


/**
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 */
	public function __construct($id = false, $table = null, $ds = null) {

        //Añadir campos virtuales de las distintas tumbas
        $this->virtualFields['id_columbario'] = $this->Columbario->virtualFields['identificador'];
        $this->virtualFields['id_exterior'] = $this->Exterior->virtualFields['identificador'];
        $this->virtualFields['id_nicho'] = $this->Nicho->virtualFields['identificador'];
        $this->virtualFields['id_panteon'] = $this->Panteon->virtualFields['identificador'];

		$this->tipo = array(
			'Columbario' => __('Columbario', true),
			'Exterior' => __('Exterior', true),
			'Nicho' => __('Nicho', true),
			'Panteón' => __('Panteón', true));

		parent::__construct($id, $table, $ds);
	}

/**
 * Field names accepted
 *
 * @var array
 * @see SearchableBehavior
 */
	public $filterArgs = array(
          'clave' => array('type' => 'query', /*'field' => 'generico',*/ 'method' => 'filterNombre'),
		//array('name' => 'nombre', 'type' => 'like', 'field' => 'Persona.nombre'),
		/*array('name' => 'apellido1', 'type' => 'like', 'field' => 'Persona.apellido1'),
		array('name' => 'apellido2', 'type' => 'like', 'field' => 'Persona.apellido2'),*/
	);

	public function filterNombre($data = array()/*, $field = null*/) {
		if (empty($data['clave'])) {//$this->params->query
			return array();
		}
		$nombre = '%' . $data['clave'] . '%';
//print($nombre);
		return array(
			'OR'  => array(
			//	/*$this->alias . */'Persona.nombre_completo LIKE' => $nombre,
				/*$this->Arrendatario . */'Tumba.tipo LIKE' => $nombre,
//BUSCAR POR ELEMENTOS SEPARADOS DE CADA TIPO DE TUMBA
				/*$this->alias . */'CONCAT("Número: ", Columbario.numero_columbario, " - Fila: ", Columbario.fila, " - Patio: ", Columbario.patio) LIKE' => $nombre,
				/*$this->alias . */'CONCAT("Número: ", Nicho.numero_nicho, " - Fila: ", Nicho.fila, " - Patio: ", Nicho.patio) LIKE' => $nombre,
				/*$this->alias . */'CONCAT("Familia: ", Panteon.familia, " - Número: ", Panteon.numero_panteon,  " - Patio: ", Panteon.patio) LIKE' => $nombre,

			));
	}

}
