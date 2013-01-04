<?php
App::uses('AppModel', 'Model');
/**
 * Nicho Model
 *
 * @property Tumba $Tumba
 */
class Nicho extends AppModel {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Nicho';

/**
 * Primary key
 *
 * @var string
 */
	public $primaryKey = 'id';

/**
 * Number of associations to recurse
 *
 * @var integer
 */
	public $recursive = 1;

/**
 * Database table name
 *
 * @var string
 */
	public $table = 'nichos';

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'cementerio';

/**
 * Use database table
 *
 * @var string
 */
	public $useTable = 'nichos';

	public $virtualFields = array(
		'identificador' => 'CONCAT("Número: ",
			Nicho.numero_nicho, " - Fila: ", Nicho.fila, " - Patio: ", Nicho.patio)'
	);

	public $displayField = 'identificador';

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
		'numero_nicho' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fila' => array(
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
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Tumba' => array(
			'className' => 'Tumba',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
