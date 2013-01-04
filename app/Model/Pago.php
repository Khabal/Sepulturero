<?php
App::uses('AppModel', 'Model');
/**
 * Pago Model
 *
 * @property Tasa $Tasa
 * @property Documento $Documento
 */
class Pago extends AppModel {

/**
 * Behaviors
 *
 * @var array
 * @access public
 */
	public $actsAs = array('Containable', 'Search.Searchable');

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'cementerio';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'fecha';

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
		'tasa_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fecha' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cantidad' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'moneda' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Tasa' => array(
			'className' => 'Tasa',
			'foreignKey' => 'tasa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Documento' => array(
			'className' => 'Documento',
			'foreignKey' => 'pago_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

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
				/*$this->Arrendatario . */'Pago.motivo LIKE' => $nombre,
				/*$this->alias . */'DATE_FORMAT(Pago.fecha,"%d/%m/%Y") LIKE' => $nombre,
				/*$this->alias . */'Tasa.tipo LIKE' => $nombre,

			));
	}
/**
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 * @access public
 */
	public function __construct($id = false, $table = null, $ds = null) {
		//$this->virtualFields += $this->Persona->virtualFields;
		parent::__construct($id, $table, $ds);
		$this->moneda = array(
			'Pesetas' => __('Pesetas', true),
			'Euros (€)' => __('Euros (€)', true));

	}

}
