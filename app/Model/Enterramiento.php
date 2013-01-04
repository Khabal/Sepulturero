<?php
App::uses('AppModel', 'Model');
/**
 * Enterramiento Model
 *
 * @property Difunto $Difunto
 * @property Licencia $Licencia
 * @property Tumba $Tumba
 * @property Tasa $Tasa
 */
class Enterramiento extends AppModel {

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
		'difunto_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'licencia_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tumba_id' => array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
/*	public $hasOne = array(
		'Difunto' => array(
			'className' => 'Difunto',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Licencia' => array(
			'className' => 'Licencia',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/

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
			'fields' => '',
			'order' => ''
		),
		'Difunto' => array(
			'className' => 'Difunto',
			'foreignKey' => 'difunto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Licencia' => array(
			'className' => 'Licencia',
			'foreignKey' => 'licencia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
/*	public $hasAndBelongsToMany = array(
		'Tasa' => array(
			'className' => 'Tasa',
			'joinTable' => 'enterramientos_tasas',
			'foreignKey' => 'enterramiento_id',
			'associationForeignKey' => 'tasa_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);*/

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EnterramientoTasa' => array(
			'className' => 'EnterramientoTasa',
			'foreignKey' => 'enterramiento_id',
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
 * Field names accepted
 *
 * @var array
 * @see SearchableBehavior
 */
	public $filterArgs = array(
          'clave' => array('type' => 'query', /*'field' => 'generico',*/ 'method' => 'filterNombre'),//condicionesBusquedaRapida
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
				/*$this->Arrendatario . */'Enterramiento.fecha LIKE' => $nombre,
				/*$this->Arrendatario . */'Persona.nombre LIKE' => $nombre,
				/*$this->alias . */'Persona.apellido1 LIKE' => $nombre,
				/*$this->alias . */'Persona.apellido2 LIKE' => $nombre,
				/*$this->alias . */'Persona.dni LIKE' => $nombre,
				/*$this->alias . */'CONCAT(Persona.nombre," ",Persona.apellido1) LIKE' => $nombre,
				/*$this->alias . */'CONCAT(Persona.nombre," ",Persona.apellido1," ",Persona.apellido2) LIKE' => $nombre,
			));
	}

}
