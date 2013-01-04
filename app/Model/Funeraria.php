<?php
App::uses('AppModel', 'Model');
/**
 * Funeraria Model
 *
 * @property Arrendatario $Arrendatario
 */
class Funeraria extends AppModel {

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
	public $displayField = 'nombre';

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
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'direccion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
 * hasAndBelongsToMany associations
 *
 * @var array
 */
/*	public $hasAndBelongsToMany = array(
		'Arrendatario' => array(
			'className' => 'Arrendatario',
			'joinTable' => 'arrendatarios_funerarias',
			'foreignKey' => 'funeraria_id',
			'associationForeignKey' => 'arrendatario_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => '',
		)
	);*/

	public $hasMany = array(
		'ArrendatarioFuneraria' => array(
			'className' => 'ArrendatarioFuneraria',
			'foreignKey' => 'funeraria_id',
			'dependent' => false,
		)
	);

/**
 * Field names accepted for search queries.
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

	public function filterNombre($data = array()) {
		if (empty($data['clave'])) {
			return array();
		}
		$nombre = '%' . $data['clave'] . '%';

		return array(
			'OR'  => array(
				/*$this->Arrendatario . */'Funeraria.nombre LIKE' => $nombre,
				/*$this->alias . *///'Persona.apellido1 LIKE' => $nombre,
				/*$this->alias . *///'Persona.apellido2 LIKE' => $nombre,
				/*$this->alias . *///'Persona.dni LIKE' => $nombre,
				/*$this->alias . *///'CONCAT(Persona.nombre," ",Persona.apellido1) LIKE' => $nombre,
				/*$this->alias . *///'CONCAT(Persona.nombre," ",Persona.apellido1," ",Persona.apellido2) LIKE' => $nombre,
			));
	}

}
